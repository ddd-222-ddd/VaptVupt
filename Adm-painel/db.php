<?php
if (!defined('HOST')) {
    define('HOST', 'localhost');
}

if (!defined('USER')) {
    define('USER', 'root');
}

if (!defined('PASS')) {
    define('PASS', 'Asd_123!');
}

if (!defined('BASE')) {
    define('BASE', 'food');
}

$conn = new MySQLi(HOST, USER, PASS, BASE);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
