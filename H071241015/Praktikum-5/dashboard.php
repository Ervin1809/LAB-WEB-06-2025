<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}

require 'data.php';

$loggedInUser = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
            </div>

            <?php if ($loggedInUser['username'] === 'adminxxx'): ?>
                <h2 class="text-2xl mb-4">Selamat Datang, Admin!</h2>
                <p class="mb-4">Berikut adalah seluruh data pengguna:</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 border">Nama</th>
                                <th class="py-2 px-4 border">Username</th>
                                <th class="py-2 px-4 border">Email</th>
                                <th class="py-2 px-4 border">Fakultas</th>
                                <th class="py-2 px-4 border">Angkatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['faculty'] ?? '-'); ?></td>
                                    <td class="py-2 px-4 border"><?php echo htmlspecialchars($user['batch'] ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <h2 class="text-2xl mb-4">Selamat Datang, <?php echo htmlspecialchars($loggedInUser['name']); ?>!</h2>
                <p class="mb-4">Berikut adalah data Anda:</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <tbody>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50 w-1/4">Nama</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['name']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Username</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['username']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Email</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['email']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Jenis Kelamin</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['gender']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Fakultas</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['faculty']); ?></td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 border-r font-semibold bg-gray-50">Angkatan</td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($loggedInUser['batch']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>