

<?php

require_once __DIR__ . '/../infra/conexao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');

    
    if (!empty($nome) && $preco > 0 && !empty($categoria)) {

        
        $sql = "INSERT INTO prato (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            
            $stmt->bind_param("ssds", $nome, $descricao, $preco, $categoria);

            if ($stmt->execute()) {
                
                header("Location: ../index.php");
                exit();
            } else {
                echo "Erro ao salvar no banco de dados: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao preparar a consulta: " . $conexao->error;
        }

    } else {
        echo "Por favor, preencha todos os campos obrigatórios corretamente.";
    }

} else {
    
    header("Location: ../index.php");
    exit();
}

$conexao->close();
?>