<?php
require_once __DIR__ . '/../infra/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // RNF1 — Validação dos Campos
    if (!empty($nome) && !empty($email)) {
        // RNF2 — Prepared Statements
        $stmt = mysqli_prepare($conexao, "INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head><title>Cadastrar Usuário</title></head>
<body>
    <h2>Cadastrar Colaborador</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required><br><br>
        <input type="email" name="email" placeholder="E-mail" required><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>