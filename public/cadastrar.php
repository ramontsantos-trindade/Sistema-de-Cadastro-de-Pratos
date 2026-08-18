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

// Recebe e limpa as entradas
$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validação dos campos
if (!empty($nome) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    try {
        $sql  = "INSERT INTO usuarios (nome, email) VALUES (:nome, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email
        ]);

        echo "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
} else {
    echo "Por favor, preencha o nome e um e-mail válido.";
}
?>