<?php
include_once 'config.php';
include_once 'auth.php';
requireLogin();

if (!isSuperAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $role = $_POST['role'];
            $project_manager_id = !empty($_POST['project_manager_id']) ? (int)$_POST['project_manager_id'] : null;
            
            if (!empty($username) && !empty($password)) {
                $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $check_stmt->bind_param("s", $username);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                
                if ($check_result->num_rows > 0) {
                    $message = "Username already exists.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    if ($role === 'Team Member' && $project_manager_id) {
                        $stmt = $conn->prepare("INSERT INTO users (username, password, role, project_manager_id) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("sssi", $username, $hashed_password, $role, $project_manager_id);
                    } else {
                        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $hashed_password, $role);
                    }
                    
                    if ($stmt->execute()) {
                        $message = "User created successfully.";
                    } else {
                        $message = "Error creating user: " . $conn->error;
                    }
                }
            } else {
                $message = "Please fill in all required fields.";
            }
        } 
        elseif ($_POST['action'] === 'update') {
            $user_id = $_POST['user_id'];
            $username = trim($_POST['username']);
            $role = $_POST['role'];
            $project_manager_id = !empty($_POST['project_manager_id']) ? (int)$_POST['project_manager_id'] : null;
            
            $password_update = "";
            $params = [];
            $types = "sss";
            $params[] = &$username;
            $params[] = &$role;
            $params[] = &$user_id;
            
            if (!empty($_POST['password'])) {
                $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $password_update = ", password = ?";
                $types = "sssi";
                array_splice($params, 2, 0, [&$hashed_password]);
                $params[] = &$user_id;
            }
            
            if ($role === 'Team Member' && $project_manager_id) {
                if (!empty($_POST['password'])) {
                    $sql = "UPDATE users SET username = ?, role = ?, password = ?, project_manager_id = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssi", $username, $role, $hashed_password, $project_manager_id, $user_id);
                } else {
                    $sql = "UPDATE users SET username = ?, role = ?, project_manager_id = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssi", $username, $role, $project_manager_id, $user_id);
                }
            } else {
                if (!empty($_POST['password'])) {
                    $sql = "UPDATE users SET username = ?, role = ?, password = ?, project_manager_id = NULL WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssi", $username, $role, $hashed_password, $user_id);
                } else {
                    $sql = "UPDATE users SET username = ?, role = ?, project_manager_id = NULL WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $username, $role, $user_id);
                }
            }
            
            if ($stmt->execute()) {
                $message = "User updated successfully.";
            } else {
                $message = "Error updating user: " . $conn->error;
            }
        } 
        elseif ($_POST['action'] === 'delete') {
            $user_id = $_POST['user_id'];
            
            if ($user_id == getUserId()) {
                $message = "You cannot delete your own account.";
            } else {
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'Super Admin'");
                $stmt->bind_param("i", $user_id);
                
                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $message = "User deleted successfully.";
                } else {
                    $message = "Error deleting user: " . $conn->error;
                }
            }
        }
    }
}

$users = [];
$userId = getUserId();
$stmt = $conn->prepare("
    SELECT u.*, m.username as manager_name 
    FROM users u 
    LEFT JOIN users m ON u.project_manager_id = m.id 
    WHERE u.id != ? 
    ORDER BY u.role, u.username
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

$project_managers = [];
$pm_stmt = $conn->prepare("SELECT id, username FROM users WHERE role = 'Project Manager' ORDER BY username");
$pm_stmt->execute();
$pm_result = $pm_stmt->get_result();
$project_managers = $pm_result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Project Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#64748b',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6">Manage Users</h2>
        
        <?php if (!empty($message)): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <!-- Add New User Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Add New User</h3>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="create">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" required>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="role" name="role" required onchange="toggleManagerField()">
                            <option value="Super Admin">Super Admin</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="Team Member">Team Member</option>
                        </select>
                    </div>
                    <div id="project_manager_field" class="hidden">
                        <label for="project_manager_id" class="block text-gray-700 text-sm font-bold mb-2">Project Manager</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="project_manager_id" name="project_manager_id">
                            <option value="">Select Project Manager</option>
                            <?php foreach ($project_managers as $pm): ?>
                                <option value="<?php echo $pm['id']; ?>"><?php echo htmlspecialchars($pm['username']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add User
                    </button>
                </div>
            </form>
        </div>
        
        <?php if (isset($_GET['edit_id'])): ?>
        <?php
        $edit_id = (int)$_GET['edit_id'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        ?>
        <!-- Edit User Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Edit User</h3>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="user_id" value="<?php echo $edit_id; ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_username" name="username" 
                               value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div>
                        <label for="edit_password" class="block text-gray-700 text-sm font-bold mb-2">New Password (leave blank to keep current)</label>
                        <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_password" name="password">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="edit_role" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_role" name="role" required onchange="toggleEditManagerField()">
                            <option value="Super Admin" <?php echo ($user['role'] == 'Super Admin') ? 'selected' : ''; ?>>Super Admin</option>
                            <option value="Project Manager" <?php echo ($user['role'] == 'Project Manager') ? 'selected' : ''; ?>>Project Manager</option>
                            <option value="Team Member" <?php echo ($user['role'] == 'Team Member') ? 'selected' : ''; ?>>Team Member</option>
                        </select>
                    </div>
                    <div id="edit_project_manager_field" class="<?php echo ($user['role'] == 'Team Member') ? 'block' : 'hidden'; ?>">
                        <label for="edit_project_manager_id" class="block text-gray-700 text-sm font-bold mb-2">Project Manager</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="edit_project_manager_id" name="project_manager_id">
                            <option value="">Select Project Manager</option>
                            <?php foreach ($project_managers as $pm): ?>
                                <option value="<?php echo $pm['id']; ?>" 
                                    <?php echo ($user['project_manager_id'] == $pm['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($pm['username']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update User
                    </button>
                    
                    <a href="users.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</a>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">User List</h3>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Username</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Project Manager</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $user['id']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $user['role']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($user['manager_name'] ?? 'N/A'); ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="users.php?edit_id=<?php echo $user['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm">Edit</a>
                                <?php if ($user['role'] !== 'Super Admin'):  ?>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm ml-1">Delete</button>
                                </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">No users found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleManagerField() {
            const roleSelect = document.getElementById('role');
            const managerField = document.getElementById('project_manager_field');
            
            if (roleSelect.value === 'Team Member') {
                managerField.classList.remove('hidden');
                managerField.classList.add('block');
            } else {
                managerField.classList.remove('block');
                managerField.classList.add('hidden');
            }
        }
        
        function toggleEditManagerField() {
            const roleSelect = document.getElementById('edit_role');
            const managerField = document.getElementById('edit_project_manager_field');
            
            if (roleSelect.value === 'Team Member') {
                managerField.classList.remove('hidden');
                managerField.classList.add('block');
            } else {
                managerField.classList.remove('block');
                managerField.classList.add('hidden');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            toggleManagerField();
            
            if (document.getElementById('edit_role')) {
                toggleEditManagerField();
            }
        });
    </script>
</body>
</html>