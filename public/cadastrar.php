

<?php
// 1. Inclui o arquivo de conexão voltando uma pasta (../)
require_once __DIR__ . '/../infra/conexao.php';

// 2. Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura e limpa os campos enviados pelo formulário
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $categoria = trim($_POST['categoria'] ?? '');

    // 3. Valida se os campos obrigatórios foram preenchidos
    if (!empty($nome) && $preco > 0 && !empty($categoria)) {

        // Prepara a instrução SQL para inserir o prato
        $sql = "INSERT INTO prato (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            // "ssds" -> string, string, double/decimal, string
            $stmt->bind_param("ssds", $nome, $descricao, $preco, $categoria);

            if ($stmt->execute()) {
                // Sucesso: Redireciona de volta para a página principal (index.php)
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
    // Caso alguém tente acessar o arquivo diretamente pelo navegador
    header("Location: ../index.php");
    exit();
}

$conexao->close();
?>