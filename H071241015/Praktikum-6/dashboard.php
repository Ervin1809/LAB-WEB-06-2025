<?php
include_once 'config.php';
include_once 'auth.php';
requireLogin();

$projects_count = 0;
$tasks_count = 0;
$assigned_tasks_count = 0;

if (isSuperAdmin()) {
    $projects_result = $conn->query("SELECT COUNT(*) as count FROM projects");
    $projects_count = $projects_result->fetch_assoc()['count'];
    
    $tasks_result = $conn->query("SELECT COUNT(*) as count FROM tasks");
    $tasks_count = $tasks_result->fetch_assoc()['count'];
    
    $assigned_tasks_count = $tasks_count;
} elseif (isProjectManager()) {
    $projects_result = $conn->query("SELECT COUNT(*) as count FROM projects WHERE manager_id = " . getUserId());
    $projects_count = $projects_result->fetch_assoc()['count'];
    
    $tasks_result = $conn->query("
        SELECT COUNT(*) as count 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id 
        WHERE p.manager_id = " . getUserId()
    );
    $tasks_count = $tasks_result->fetch_assoc()['count'];
    
    $assigned_tasks_count = $tasks_count;
} elseif (isTeamMember()) {
    $assigned_tasks_result = $conn->query("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = " . getUserId());
    $assigned_tasks_count = $assigned_tasks_result->fetch_assoc()['count'];
    
    $tasks_result = $conn->query("
        SELECT COUNT(*) as count 
        FROM tasks t 
        JOIN projects p ON t.project_id = p.id 
        WHERE p.id IN (
            SELECT DISTINCT project_id 
            FROM tasks 
            WHERE assigned_to = " . getUserId() . "
        )
    ");
    $tasks_count = $tasks_result->fetch_assoc()['count'];
    
    $projects_result = $conn->query("
        SELECT COUNT(DISTINCT p.id) as count 
        FROM projects p 
        JOIN tasks t ON p.id = t.project_id 
        WHERE t.assigned_to = " . getUserId()
    );
    $projects_count = $projects_result->fetch_assoc()['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Project Management System</title>
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
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Dashboard</h2>
            <p class="text-gray-600">Welcome, <strong><?php echo $_SESSION['username']; ?></strong> (Role: <?php echo $_SESSION['role']; ?>)</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-600 text-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">Projects</h3>
                <h4 class="text-3xl font-bold"><?php echo $projects_count; ?></h4>
                <p class="text-blue-100">Total Projects</p>
            </div>
            
            <div class="bg-green-600 text-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">Tasks</h3>
                <h4 class="text-3xl font-bold"><?php echo $tasks_count; ?></h4>
                <p class="text-green-100">Total Tasks</p>
            </div>
            
            <div class="bg-teal-600 text-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-2">Assigned Tasks</h3>
                <h4 class="text-3xl font-bold"><?php echo $assigned_tasks_count; ?></h4>
                <p class="text-teal-100">Tasks Assigned to You</p>
            </div>
        </div>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold mb-4">Quick Access</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <?php if (isSuperAdmin()): ?>
                    <a href="users.php" class="bg-white border border-blue-300 text-blue-700 hover:bg-blue-50 font-medium py-3 px-4 rounded-lg text-center transition-colors">Manage Users</a>
                <?php endif; ?>
                
                <?php if (isProjectManager() || isSuperAdmin()): ?>
                    <a href="projects.php" class="bg-white border border-green-300 text-green-700 hover:bg-green-50 font-medium py-3 px-4 rounded-lg text-center transition-colors">Manage Projects</a>
                <?php endif; ?>
                
                <?php if (isProjectManager() || isSuperAdmin()): ?>
                    <a href="tasks.php" class="bg-white border border-yellow-300 text-yellow-700 hover:bg-yellow-50 font-medium py-3 px-4 rounded-lg text-center transition-colors">Manage Tasks</a>
                <?php endif; ?>
                
                <?php if (isTeamMember()): ?>
                    <a href="my_tasks.php" class="bg-white border border-teal-300 text-teal-700 hover:bg-teal-50 font-medium py-3 px-4 rounded-lg text-center transition-colors">My Tasks</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>