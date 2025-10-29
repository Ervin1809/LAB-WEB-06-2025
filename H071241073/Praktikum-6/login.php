<?php
session_start();

$message = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white/95 backdrop-blur-md p-10 sm:p-12 rounded-2xl shadow-2xl w-full max-w-md border border-blue-100">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-700 tracking-tight">
                Sistem Manajemen Proyek
            </h1>
            <p class="text-gray-500 mt-2 text-sm">Silakan masuk untuk melanjutkan</p>
        </div>

        <!-- Pesan Error -->
        <?php if (!empty($message)) : ?>
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-5 text-center font-medium border border-red-200">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="POST" action="proses_login.php" class="space-y-6" autocomplete="off">
            <!-- Field dummy agar browser tidak autofill -->
            <input type="text" name="fakeuser" style="display:none" autocomplete="off">
            <input type="password" name="fakepass" style="display:none" autocomplete="new-password">

            <div>
                <label for="username" class="block text-sm font-semibold text-gray-600 mb-1">Username</label>
                <input
                    type="text"
                    id="username"
                    name="user_login"
                    placeholder="Masukkan username"
                    required
                    autocomplete="off"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
                >
            </div>

            <div class="relative">
                <label for="passwordInput" class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
                <input
                    id="passwordInput"
                    type="password"
                    name="pass_login"
                    placeholder="Masukkan password"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 pr-12"
                >
                <button
                    id="togglePassword"
                    type="button"
                    aria-pressed="false"
                    class="absolute bottom-3 right-3 text-gray-600 hover:text-gray-900 transition"
                >
                    <span id="toggleEmoji">👁️</span>
                </button>
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-xl text-base sm:text-lg transition transform hover:scale-105 shadow-md"
            >
                Masuk
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; <?= date('Y') ?> Sistem Manajemen Proyek</p>
        </div>
    </div>

    <script>
        (function(){
            const pwdInput = document.getElementById('passwordInput');
            const toggleBtn = document.getElementById('togglePassword');
            const toggleEmoji = document.getElementById('toggleEmoji');

            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                toggleEmoji.textContent = isPassword ? '🙈' : '👁️';
                toggleBtn.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
            });
        })();
    </script>

</body>
</html>
