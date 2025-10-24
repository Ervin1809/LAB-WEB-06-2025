<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a class="text-xl font-bold" href="dashboard.php">Project Management System</a>
            
            <?php if (isLoggedIn()): ?>
                <div class="flex items-center space-x-4">
                    <a class="hover:text-gray-300" href="dashboard.php">Dashboard</a>
                    
                    <?php if (isSuperAdmin()): ?>
                        <a class="hover:text-gray-300" href="users.php">Manage Users</a>
                    <?php endif; ?>
                    
                    <?php if (isProjectManager() || isSuperAdmin()): ?>
                        <a class="hover:text-gray-300" href="projects.php">Manage Projects</a>
                    <?php endif; ?>
                    
                    <?php if (isProjectManager() || isSuperAdmin()): ?>
                        <a class="hover:text-gray-300" href="tasks.php">Manage Tasks</a>
                    <?php endif; ?>
                    
                    <?php if (isTeamMember()): ?>
                        <a class="hover:text-gray-300" href="my_tasks.php">My Tasks</a>
                    <?php endif; ?>
                    
                    <div>
                        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">Logout</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>