<?php
include_once '../infra/conect.php';

$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');

$sql = "INSERT INTO livros (titulo,autor,ano) VALUES ('$nome','$email')";

mysqli_query($conexao, $sql);

header("Location: ../index.php");
?>''