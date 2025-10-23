<?php
include_once 'config.php';
include_once 'auth.php';
requireLogin();

if (!isTeamMember()) {
    header('Location: dashboard.php');
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['status'];
    $userId = getUserId();
    
    $stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param("ii", $task_id, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $update_stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $update_stmt->bind_param("si", $new_status, $task_id);
        
        if ($update_stmt->execute()) {
            $message = "Task status updated successfully.";
        } else {
            $message = "Error updating task status: " . $conn->error;
        }
    } else {
        $message = "You can only update tasks assigned to you.";
    }
}

$tasks = [];
$userId = getUserId();
$stmt = $conn->prepare("
    SELECT t.*, p.nama_proyek 
    FROM tasks t 
    LEFT JOIN projects p ON t.project_id = p.id 
    WHERE t.assigned_to = ? 
    ORDER BY t.status ASC, t.id DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks - Project Management System</title>
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
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'navbar.php'; ?>
    
    <main class="container mx-auto px-4 py-8 flex-1">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800">My Tasks</h2>
                <p class="text-gray-600 mt-2">Manage and track your assigned tasks</p>
            </div>
            
            <?php if (!empty($message)): ?>
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Tasks Assigned to Me</h3>
                </div>
                
                <div class="p-6">
                    <?php if (!empty($tasks)): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($tasks as $task): ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo htmlspecialchars($task['id']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($task['nama_tugas']); ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs"><?php echo htmlspecialchars(strlen($task['deskripsi']) > 50 ? substr($task['deskripsi'], 0, 50) . '...' : $task['deskripsi']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars($task['nama_proyek']); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full
                                                <?php 
                                                    switch($task['status']) {
                                                        case 'belum': echo 'bg-gray-200 text-gray-800'; break;
                                                        case 'proses': echo 'bg-yellow-100 text-yellow-800'; break;
                                                        case 'selesai': echo 'bg-green-100 text-green-800'; break;
                                                        default: echo 'bg-gray-200 text-gray-800';
                                                    }
                                                ?>
                                            ">
                                                <?php echo htmlspecialchars($task['status']); ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <form method="POST" class="flex items-center space-x-2">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="task_id" value="<?php echo (int)$task['id']; ?>">
                                                
                                                <select name="status" 
                                                        class="block w-32 px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                                        onchange="this.form.submit()">
                                                    <option value="belum" <?php echo ($task['status'] == 'belum') ? 'selected' : ''; ?>>Belum</option>
                                                    <option value="proses" <?php echo ($task['status'] == 'proses') ? 'selected' : ''; ?>>Proses</option>
                                                    <option value="selesai" <?php echo ($task['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                </select>
                                                
                                                <button type="submit" 
                                                        class="px-3 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-150">
                                                    Update
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks assigned</h3>
                            <p class="mt-1 text-sm text-gray-500">You don't have any tasks assigned to you at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    
</body>
</html>