<?php
// data.php
// Sumber data user (tanpa database)
// Simpan ini sebagai data.php dan include di file lain

$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        // password: admin123
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],
    [
        'email' => 'diesty@gmail.com',
        'username' => 'diesty_aja',
        'name' => 'Diesty Mendila Tappo',
        // password: diesty123
        'password' => password_hash('diesty123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'MIPA',
        'batch' => '2024',
    ],
    [
        'email' => 'nailah@gmail.com',
        'username' => 'nailah06',
        'name' => 'Nailah Mazaya',
        // password: nailah123
        'password' => password_hash('nailah123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Keperawatan',
        'batch' => '2024',
    ],
    [
        'email' => 'david@gmail.com',
        'username' => 'david59',
        'name' => 'Davidzen',
        // password: Davidzen123
        'password' => password_hash('Davidzen123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Mipa',
        'batch' => '2021',
    ],
    [
        'email' => 'Eryn@gmail.com',
        'username' => 'eryn23',
        'name' => 'Andi Eryn',
        // password: Eryn123
        'password' => password_hash('Eryn123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Teknik',
        'batch' => '2020',
    ],
];
