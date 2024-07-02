<?php
$host = '127.0.0.1';
$db = 'dbsistemaesmeralda';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$port = 3306;
//$port = 3307;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

global $pdo; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
    die('Error al conectar con la base de datos: ' . $e->getMessage());
    echo "Error de conexión: " . $e->getMessage();
}
?>