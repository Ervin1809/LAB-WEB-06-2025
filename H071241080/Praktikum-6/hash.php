<?php

$passwords = [
    "12345",
];

foreach ($passwords as $pass) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    echo "Password: $pass<br>";
    echo "Hash: $hash<br><br>";
}
?>
