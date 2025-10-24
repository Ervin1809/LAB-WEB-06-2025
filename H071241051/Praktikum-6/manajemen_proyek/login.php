<?php
include 'koneksi.php';
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-sm">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login Sistem</h2>
        
        <?php
        if (isset($_GET['error'])) {
            echo "<p class='text-red-600 font-medium mb-4 text-center'>" . htmlspecialchars($_GET['error']) . "</p>";
        }
        ?>

        <form action="proses_login.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 font-medium mb-1">Username:</label>
                <input type="text" id="username" name="username" required
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password:</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-md transition">
                Login
            </button>
        </form>
    </div>
</body>
</html>