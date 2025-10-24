<?php
include_once 'config.php';
include_once 'auth.php';
requireLogin();

if (!isProjectManager() && !isSuperAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$message_type = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create' && (isProjectManager() || isSuperAdmin())) {
            $nama_tugas = trim($_POST['nama_tugas']);
            $deskripsi = trim($_POST['deskripsi']);
            $project_id = (int)$_POST['project_id'];
            $assigned_to = !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null;
            
            if (!empty($nama_tugas) && !empty($project_id)) {
                if (canAccessProject($project_id)) {
                    $stmt = $conn->prepare("INSERT INTO tasks (nama_tugas, deskripsi, project_id, assigned_to, status) VALUES (?, ?, ?, ?, 'belum')");
                    $stmt->bind_param("ssii", $nama_tugas, $deskripsi, $project_id, $assigned_to);
                    
                    if ($stmt->execute()) {
                        $message = "Task created successfully.";
                        $message_type = 'success';
                    } else {
                        $message = "Error creating task: " . $conn->error;
                        $message_type = 'danger';
                    }
                } else {
                    $message = "You don't have permission to create tasks in this project.";
                    $message_type = 'danger';
                }
            } else {
                $message = "Please fill in all required fields.";
                $message_type = 'warning';
            }
        } 
        elseif ($_POST['action'] === 'update' && (isProjectManager() || isSuperAdmin())) {
            $task_id = (int)$_POST['task_id'];
            $nama_tugas = trim($_POST['nama_tugas']);
            $deskripsi = trim($_POST['deskripsi']);
            $status = $_POST['status'];
            $project_id = (int)$_POST['project_id'];
            $assigned_to = !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null;
            
            $valid_statuses = ['belum', 'proses', 'selesai'];
            if (!in_array($status, $valid_statuses)) {
                $status = 'belum';
            }
            
            if (canAccessProject($project_id)) {
                $stmt = $conn->prepare("UPDATE tasks SET nama_tugas=?, deskripsi=?, status=?, project_id=?, assigned_to=? WHERE id=?");
                $stmt->bind_param("sssiii", $nama_tugas, $deskripsi, $status, $project_id, $assigned_to, $task_id);
                
                if ($stmt->execute()) {
                    $message = "Task updated successfully.";
                    $message_type = 'success';
                    $redirect_url = 'tasks.php';
                    if (isset($_GET['project_id'])) {
                        $redirect_url .= '?project_id=' . (int)$_GET['project_id'];
                    }
                    header("Location: $redirect_url");
                    exit();
                } else {
                    $message = "Error updating task: " . $conn->error;
                    $message_type = 'danger';
                }
            } else {
                $message = "You don't have permission to update this task.";
                $message_type = 'danger';
            }
        } 
        elseif ($_POST['action'] === 'delete') {
            $task_id = (int)$_POST['task_id'];
            
            $stmt = $conn->prepare("SELECT t.project_id FROM tasks t WHERE t.id = ?");
            $stmt->bind_param("i", $task_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $project_id = $row['project_id'];
                
                if (canAccessProject($project_id)) {
                    $delete_stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
                    $delete_stmt->bind_param("i", $task_id);
                    
                    if ($delete_stmt->execute()) {
                        $message = "Task deleted successfully.";
                        $message_type = 'success';
                    } else {
                        $message = "Error deleting task: " . $conn->error;
                        $message_type = 'danger';
                    }
                } else {
                    $message = "You don't have permission to delete this task.";
                    $message_type = 'danger';
                }
            } else {
                $message = "Task not found.";
                $message_type = 'warning';
            }
        }
    }
}

$project_id_filter = isset($_GET['project_id']) ? (int)$_GET['project_id'] : null;

$tasks = [];
$projects = [];
$team_members = [];

if (isSuperAdmin()) {
    if ($project_id_filter) {
        $stmt = $conn->prepare("
            SELECT t.*, p.nama_proyek, u.username as assigned_user 
            FROM tasks t 
            LEFT JOIN projects p ON t.project_id = p.id 
            LEFT JOIN users u ON t.assigned_to = u.id 
            WHERE t.project_id = ? 
            ORDER BY t.id DESC
        ");
        $stmt->bind_param("i", $project_id_filter);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("
            SELECT t.*, p.nama_proyek, u.username as assigned_user 
            FROM tasks t 
            LEFT JOIN projects p ON t.project_id = p.id 
            LEFT JOIN users u ON t.assigned_to = u.id 
            ORDER BY t.id DESC
        ");
    }
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    
    $projects_result = $conn->query("SELECT id, nama_proyek FROM projects ORDER BY nama_proyek");
    $projects = $projects_result->fetch_all(MYSQLI_ASSOC);
    
    $members_result = $conn->query("SELECT id, username FROM users WHERE role = 'Team Member' ORDER BY username");
    $team_members = $members_result->fetch_all(MYSQLI_ASSOC);
} elseif (isProjectManager()) {
    $user_id = getUserId();
    
    if ($project_id_filter) {
        $stmt = $conn->prepare("
            SELECT t.*, p.nama_proyek, u.username as assigned_user 
            FROM tasks t 
            LEFT JOIN projects p ON t.project_id = p.id 
            LEFT JOIN users u ON t.assigned_to = u.id 
            WHERE t.project_id = ? AND p.manager_id = ? 
            ORDER BY t.id DESC
        ");
        $stmt->bind_param("ii", $project_id_filter, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $stmt = $conn->prepare("
            SELECT t.*, p.nama_proyek, u.username as assigned_user 
            FROM tasks t 
            LEFT JOIN projects p ON t.project_id = p.id 
            LEFT JOIN users u ON t.assigned_to = u.id 
            WHERE p.manager_id = ? 
            ORDER BY t.id DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    
    $stmt = $conn->prepare("SELECT id, nama_proyek FROM projects WHERE manager_id = ? ORDER BY nama_proyek");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    $stmt = $conn->prepare("
        SELECT u.id, u.username 
        FROM users u 
        WHERE u.role = 'Team Member' AND u.project_manager_id = ? 
        ORDER BY u.username
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $team_members = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$current_project_name = '';
if ($project_id_filter && !empty($projects)) {
    foreach ($projects as $project) {
        if ($project['id'] == $project_id_filter) {
            $current_project_name = $project['nama_proyek'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tasks - Project Management System</title>
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
<body class="bg-gray-50 min-h-screen">
    <?php include 'navbar.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Tasks</h2>
            
            <?php if (!empty($message)): ?>
                <div class="mb-6 px-4 py-3 rounded-lg border <?php 
                    echo $message_type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : 
                        ($message_type === 'danger' ? 'bg-red-50 border-red-200 text-red-700' : 
                        ($message_type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-700' : 
                        'bg-blue-50 border-blue-200 text-blue-700'));
                ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isProjectManager() || isSuperAdmin()): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <?php echo isset($_GET['edit_id']) ? 'Edit Task' : 'Add New Task'; ?>
                    </h3>
                </div>
                <div class="p-6">
                    <form method="POST">
                        <input type="hidden" name="action" value="<?php echo isset($_GET['edit_id']) ? 'update' : 'create'; ?>">
                        
                        <?php if (isset($_GET['edit_id'])): ?>
                            <?php
                            $edit_id = (int)$_GET['edit_id'];
                            $stmt = $conn->prepare("
                                SELECT t.*, p.nama_proyek 
                                FROM tasks t 
                                LEFT JOIN projects p ON t.project_id = p.id 
                                WHERE t.id = ?
                            ");
                            $stmt->bind_param("i", $edit_id);
                            $stmt->execute();
                            $task = $stmt->get_result()->fetch_assoc();
                            
                            if (!$task || !canAccessProject($task['project_id'])) {
                                echo '<div class="text-red-600">Task not found or access denied.</div>';
                                echo '</form></div></div>';
                                include 'footer.php';
                                exit();
                            }
                            ?>
                            <input type="hidden" name="task_id" value="<?php echo $edit_id; ?>">
                        <?php endif; ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="nama_tugas" class="block text-sm font-medium text-gray-700 mb-2">Task Name *</label>
                                <input type="text" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       id="nama_tugas" 
                                       name="nama_tugas" 
                                       value="<?php echo isset($task) ? htmlspecialchars($task['nama_tugas']) : ''; ?>" 
                                       required>
                            </div>
                            <div>
                                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">Project *</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        id="project_id" 
                                        name="project_id" 
                                        required>
                                    <option value="">Select Project</option>
                                    <?php foreach ($projects as $project): ?>
                                        <option value="<?php echo $project['id']; ?>" 
                                            <?php echo (isset($task) && $task['project_id'] == $project['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($project['nama_proyek']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3"><?php echo isset($task) ? htmlspecialchars($task['deskripsi']) : ''; ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        id="assigned_to" 
                                        name="assigned_to">
                                    <option value="">Unassigned</option>
                                    <?php foreach ($team_members as $member): ?>
                                        <option value="<?php echo $member['id']; ?>" 
                                            <?php echo (isset($task) && $task['assigned_to'] == $member['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($member['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if (isset($_GET['edit_id'])): ?>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        id="status" 
                                        name="status">
                                    <option value="belum" <?php echo (isset($task) && $task['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                    <option value="proses" <?php echo (isset($task) && $task['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                    <option value="selesai" <?php echo (isset($task) && $task['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <?php echo isset($_GET['edit_id']) ? 'Update Task' : 'Add Task'; ?>
                            </button>
                            
                            <?php if (isset($_GET['edit_id'])): ?>
                                <a href="tasks.php<?php echo $project_id_filter ? '?project_id=' . $project_id_filter : ''; ?>" 
                                   class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                    Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Tasks List -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Task List</h3>
                    <?php if ($project_id_filter && $current_project_name): ?>
                        <p class="text-sm text-gray-600 mt-1">
                            Filter: <?php echo htmlspecialchars($current_project_name); ?>
                            <a href="tasks.php" class="ml-2 text-blue-600 hover:text-blue-800">Clear Filter</a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($tasks as $task): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo $task['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">
                                    <?php echo htmlspecialchars(strlen($task['deskripsi']) > 50 ? substr($task['deskripsi'], 0, 50) . '...' : $task['deskripsi']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($task['assigned_user'] ?? 'Unassigned'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full <?php 
                                        switch($task['status']) {
                                            case 'belum': echo 'bg-gray-200 text-gray-800'; break;
                                            case 'proses': echo 'bg-yellow-100 text-yellow-800'; break;
                                            case 'selesai': echo 'bg-green-100 text-green-800'; break;
                                            default: echo 'bg-gray-200 text-gray-800';
                                        }
                                    ?>">
                                        <?php echo htmlspecialchars($task['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="tasks.php?edit_id=<?php echo $task['id']; ?><?php echo $project_id_filter ? '&project_id=' . $project_id_filter : ''; ?>" 
                                       class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                        Edit
                                    </a>
                                    
                                    <?php if (canAccessProject($task['project_id'])): ?>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($tasks)): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    No tasks found.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>