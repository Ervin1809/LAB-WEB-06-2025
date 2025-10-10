<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-xs">
            <form action="proses_login.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h1 class="text-center text-2xl font-bold mb-6">Login</h1>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
                    </div>
                    <?php
                        unset($_SESSION['error']);
                    ?>
                <?php endif; ?>
            <table class="border-separate border-spacing-y-2">
                <tr>
                    <td class="pr-2">Username:</td>
                    <td><input type="text" name="username" class="border rounded px-2 py-1" required></td>
                </tr>
                <tr>
                    <td class="pr-2">Password:</td>
                    <td><input type="password" name="password" class="border rounded px-2 py-1"></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center pt-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Login</button>
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>


    
</body>
</html>