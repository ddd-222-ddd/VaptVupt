<?php
if (file_exists("db.php")) {
    echo "Arquivo db.php encontrado.<br>";
} else {
    die("Arquivo db.php não encontrado.");
}

include "db.php";

if (isset($conn)) {
    echo "Conexão com o banco de dados estabelecida.<br>";
} else {
    die("Falha ao estabelecer conexão com o banco de dados.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pedido_id']) && is_numeric($_POST['pedido_id'])) { // Validação do input
        $pedido_id = $_POST['pedido_id']; // Usando 'pedido_id' conforme esperado

        $sql = "UPDATE PEDIDOS SET STATUS = 'Concluído' WHERE ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) { // Verificação se a preparação do statement foi bem-sucedida
            $stmt->bind_param("i", $pedido_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                header("Location: index.php");
                exit();
            } else {
                echo "Erro: Nenhum registro foi atualizado.";
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da declaração: " . $conn->error;
        }
    } else {
        echo "ID de pedido inválido.";
    }
} else {
    echo "Método de requisição inválido.";
}

$conn->close(); // Fechando a conexão com o banco de dados
?>
