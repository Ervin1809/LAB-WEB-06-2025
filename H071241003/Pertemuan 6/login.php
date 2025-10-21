<?php 
session_start();

if(isset($_SESSION['username'])){
    header('Location: halaman_utama.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            height: 100vh;
            position: relative;
            font-family: Arial, sans-serif;
        }

        #aku {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        #kamu {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        #anu {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        label {
            display: block;
            margin-bottom: 4px;
        }

        input {
            padding: 6px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form action="login_logic.php" method="post" id="anu">
        <div id="aku">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Username" required><br>
        </div>
        <div id="kamu">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
