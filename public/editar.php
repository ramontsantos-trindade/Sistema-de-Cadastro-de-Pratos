<?php

require_once "../infra/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $preco = $_POST["preco"] ?? "";
    $categoria = trim($_POST["categoria"] ?? "");

    if ($nome === "" || $descricao === "" || $preco === "" || $categoria === "") {
        die("Todos os campos são obrigatórios.");
    }

    $sql = "UPDATE prato
            SET nome = ?, descricao = ?, preco = ?, categoria = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar atualização: " . $conexao->error);
    }

    $stmt->bind_param(
        "ssdsi",
        $nome,
        $descricao,
        $preco,
        $categoria,
        $id
    );

    if (!$stmt->execute()) {
        die("Erro ao atualizar prato: " . $stmt->error);
    }

    $stmt->close();
    $conexao->close();

    header("Location: ../index.php");
    exit;
}

$sql = "SELECT * FROM prato WHERE id = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$prato = $resultado->fetch_assoc();

$stmt->close();

if (!$prato) {
    die("Prato não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Prato</title>

    <link rel="stylesheet" href="../style/styles.css">
</head>

<body>

<header>
    <h1>Editar Prato</h1>
</header>

<main>

    <h2>Editar prato</h2>

    <form method="POST">

        <label for="nome">Nome:</label>
        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($prato["nome"]) ?>"
            required
        >

        <br>

        <label for="descricao">Descrição:</label>
        <input
            type="text"
            id="descricao"
            name="descricao"
            value="<?= htmlspecialchars($prato["descricao"]) ?>"
            required
        >

        <br>

        <label for="preco">Preço:</label>
        <input
            type="number"
            id="preco"
            name="preco"
            step="0.01"
            min="0"
            value="<?= htmlspecialchars($prato["preco"]) ?>"
            required
        >

        <br>

        <label for="categoria">Categoria:</label>
        <input
            type="text"
            id="categoria"
            name="categoria"
            value="<?= htmlspecialchars($prato["categoria"]) ?>"
            required
        >

        <br>

        <button type="submit">Salvar alterações</button>

        <a href="../index.php">Cancelar</a>

    </form>

</main>

</body>
</html>