<?php
include_once 'config.php';
include_once 'auth.php';
requireLogin();

if (!isProjectManager() && !isSuperAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create' && (isProjectManager() || isSuperAdmin())) {
            $nama_proyek = trim($_POST['nama_proyek']);
            $deskripsi = trim($_POST['deskripsi']);
            $tanggal_mulai = $_POST['tanggal_mulai'];
            $tanggal_selesai = $_POST['tanggal_selesai'];
            
            $manager_id = isProjectManager() ? getUserId() : $_POST['manager_id'];
            
            if (!empty($nama_proyek) && !empty($tanggal_mulai) && !empty($tanggal_selesai)) {
                $stmt = $conn->prepare("INSERT INTO projects (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, manager_id) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $manager_id);
                
                if ($stmt->execute()) {
                    $message = "Project created successfully.";
                } else {
                    $message = "Error creating project: " . $conn->error;
                }
            } else {
                $message = "Please fill in all required fields.";
            }
        } 
        elseif ($_POST['action'] === 'update' && (isProjectManager() || isSuperAdmin())) {
            $project_id = $_POST['project_id'];
            $nama_proyek = trim($_POST['nama_proyek']);
            $deskripsi = trim($_POST['deskripsi']);
            $tanggal_mulai = $_POST['tanggal_mulai'];
            $tanggal_selesai = $_POST['tanggal_selesai'];
            
            if (canAccessProject($project_id)) {
                $stmt = $conn->prepare("UPDATE projects SET nama_proyek=?, deskripsi=?, tanggal_mulai=?, tanggal_selesai=? WHERE id=?");
                $stmt->bind_param("ssssi", $nama_proyek, $deskripsi, $tanggal_mulai, $tanggal_selesai, $project_id);
                
                if ($stmt->execute()) {
                    $message = "Project updated successfully.";
                } else {
                    $message = "Error updating project: " . $conn->error;
                }
            } else {
                $message = "You don't have permission to update this project.";
            }
        } 
        elseif ($_POST['action'] === 'delete') {
            $project_id = $_POST['project_id'];
            
            if (isSuperAdmin() || (isProjectManager() && getUserId() == getProjectManagerId($project_id))) {
                $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
                $stmt->bind_param("i", $project_id);
                
                if ($stmt->execute()) {
                    $message = "Project deleted successfully.";
                } else {
                    $message = "Error deleting project: " . $conn->error;
                }
            } else {
                $message = "You don't have permission to delete this project.";
            }
        }
    }
}

$projects = [];
if (isSuperAdmin()) {
    $result = $conn->query("SELECT p.*, u.username as manager_name FROM projects p LEFT JOIN users u ON p.manager_id = u.id ORDER BY p.id DESC");
    $projects = $result->fetch_all(MYSQLI_ASSOC);
} elseif (isProjectManager()) {
    $result = $conn->query("SELECT p.*, u.username as manager_name FROM projects p LEFT JOIN users u ON p.manager_id = u.id WHERE p.manager_id = " . getUserId() . " ORDER BY p.id DESC");
    $projects = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects - Project Management System</title>
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
        <h2 class="text-2xl font-bold mb-6">Manage Projects</h2>
        
        <?php if (!empty($message)): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isProjectManager() || isSuperAdmin()): ?>
        <!-- Add Project Form -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4"><?php echo isset($_GET['edit_id']) ? 'Edit Project' : 'Add New Project'; ?></h3>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="<?php echo isset($_GET['edit_id']) ? 'update' : 'create'; ?>">
                
                <?php if (isset($_GET['edit_id'])): ?>
                    <?php
                    $edit_id = (int)$_GET['edit_id'];
                    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
                    $stmt->bind_param("i", $edit_id);
                    $stmt->execute();
                    $project = $stmt->get_result()->fetch_assoc();
                    ?>
                    <input type="hidden" name="project_id" value="<?php echo $edit_id; ?>">
                <?php endif; ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_proyek" class="block text-gray-700 text-sm font-bold mb-2">Project Name</label>
                        <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama_proyek" name="nama_proyek" 
                               value="<?php echo isset($project) ? htmlspecialchars($project['nama_proyek']) : ''; ?>" required>
                    </div>
                    <div>
                        <?php if (isSuperAdmin()): ?>
                            <label for="manager_id" class="block text-gray-700 text-sm font-bold mb-2">Project Manager</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="manager_id" name="manager_id" required>
                                <option value="">Select Manager</option>
                                <?php
                                $managers = $conn->query("SELECT id, username FROM users WHERE role = 'Project Manager'");
                                while ($manager = $managers->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $manager['id']; ?>" 
                                        <?php echo (isset($project) && $project['manager_id'] == $manager['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($manager['username']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        <?php else: ?>
                            <input type="hidden" name="manager_id" value="<?php echo getUserId(); ?>">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="deskripsi" name="deskripsi" rows="3"><?php 
                        echo isset($project) ? htmlspecialchars($project['deskripsi']) : ''; 
                    ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                        <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal_mulai" name="tanggal_mulai" 
                               value="<?php echo isset($project) ? $project['tanggal_mulai'] : ''; ?>" required>
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                        <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal_selesai" name="tanggal_selesai" 
                               value="<?php echo isset($project) ? $project['tanggal_selesai'] : ''; ?>" required>
                    </div>
                </div>
                
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <?php echo isset($_GET['edit_id']) ? 'Update Project' : 'Add Project'; ?>
                    </button>
                    
                    <?php if (isset($_GET['edit_id'])): ?>
                        <a href="projects.php" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <?php endif; ?>
        
        <!-- Projects List -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Project List</h3>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Project Name</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Date</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">End Date</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Manager</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $project['id']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['nama_proyek']); ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars(substr($project['deskripsi'], 0, 50)) . (strlen($project['deskripsi']) > 50 ? '...' : ''); ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $project['tanggal_mulai']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo $project['tanggal_selesai']; ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?php echo htmlspecialchars($project['manager_name']); ?></td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="projects.php?edit_id=<?php echo $project['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded text-sm">Edit</a>
                                
                                <?php if (isSuperAdmin() || (isProjectManager() && getUserId() == $project['manager_id'])): ?>
                                <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm ml-1">Delete</button>
                                </form>
                                <?php endif; ?>
                                
                                <a href="tasks.php?project_id=<?php echo $project['id']; ?>" class="bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded text-sm ml-1">View Tasks</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($projects)): ?>
                        <tr>
                            <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">No projects found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
function getProjectManagerId($project_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT manager_id FROM projects WHERE id = ?");
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['manager_id'];
    }
    return null;
}
?>