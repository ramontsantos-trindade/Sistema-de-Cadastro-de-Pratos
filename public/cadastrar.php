<?php
$host = 'localhost';
$db   = 'restaurante';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

require 'conexao.php';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');

// RNF1 — Validação de Campos
if (!empty($nome) && !empty($email)) {
    $sql = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email
    ]);
}


?>