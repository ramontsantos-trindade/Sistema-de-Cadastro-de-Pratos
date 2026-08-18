<?php
require_once __DIR__ . '/../infra/conexao.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($nome) && !empty($email)) {
        $stmt = mysqli_prepare($conexao, "INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            
            header("Location: ../index.php"); 
            exit;
        } else {
            $erro = "Erro ao cadastrar no banco de dados.";
        }
    } else {
        $erro = "Preencha todos os campos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
</head>
<body>

    <header>
        <h1>Sistema do Restaurante</h1>
        <nav>
            
            <a href="../index.php">Pratos</a> | 
            <a href="cadastrar_usuario.php">Usuários</a>
        </nav>
    </header>

    <h2>Cadastrar Colaborador</h2>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= $erro ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required><br><br>
        <input type="email" name="email" placeholder="E-mail" required><br><br>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>