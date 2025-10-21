<?php 
session_start();
if (isset($_SESSION["username"])) {
  header("Location: halaman_utama.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Proyek</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #9A3412 0%, #451A03 100%);
        }
    </style>
</head>
<body>
    <div class="header finisher-header flex items-center justify-center min-h-screen" style="width: 100%; height: 300px;">
        <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl w-full max-w-md border border-gray-700">
            <div class="flex justify-center mb-8">
                <img src="asset/welcomeback.png" alt="Selamat Datang Kembali" class="w-full max-w-xs mx-auto">
            </div>
            <form action="login_logic.php" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-300 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all text-gray-100">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-300 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all text-gray-100">
                </div>
                <button type="submit" class="w-full bg-orange-700 text-orange-100 font-bold py-3 px-4 rounded-lg hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all transform hover:-translate-y-1">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>

<script src="finisher-header.es5.min.js" type="text/javascript"></script>
<script type="text/javascript">
new FinisherHeader({
  "count": 5,
  "size": {
    "min": 900,
    "max": 1500,
    "pulse": 0
  },
  "speed": {
    "x": {
      "min": 0,
      "max": 0.3
    },
    "y": {
      "min": 0,
      "max": 0
    }
  },
  "colors": {
    "background": "#451a03",
    "particles": [
      "#f97316",
      "#ea580c",
      "#fed7aa"
    ]
  },
  "blending": "lighten",
  "opacity": {
    "center": 0.15,
    "edge": 0.05
  },
  "skew": 0,
  "shapes": [
    "s"
  ]
});
</script>

</html>