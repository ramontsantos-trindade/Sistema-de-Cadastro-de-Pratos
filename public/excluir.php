<?php

require_once "../infra/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: ../index.php");
    exit;
}

$sql = "DELETE FROM prato WHERE id = ?";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar exclusão: " . $conexao->error);
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    die("Erro ao excluir prato: " . $stmt->error);
}

$stmt->close();
$conexao->close();

header("Location: ../index.php");
exit;