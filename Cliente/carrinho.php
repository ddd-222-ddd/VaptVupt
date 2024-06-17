<?php
include 'config.php';
session_start();

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

// Verificar se houve envio de POST para finalizar o pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar se o campo total_pedido foi enviado e é um número válido
    if (isset($_POST['total_pedido']) && is_numeric($_POST['total_pedido'])) {
        $total = $_POST['total_pedido'];

        // Inserir o pedido na tabela PEDIDOS
        $sql = "INSERT INTO PEDIDOS (DATA_HORA, TOTAL, STATUS) VALUES (NOW(), ?, 'Pendente')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $total);

        try {
            $stmt->execute();
            $pedido_id = $stmt->insert_id;

            // Inserir os itens do pedido na tabela ITENS_PEDIDO
            foreach ($carrinho as $item) {
                $sql = "INSERT INTO ITENS_PEDIDO (PEDIDO_ID, PRODUTO_NOME, QUANTIDADE, PRECO_UNITARIO) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isid", $pedido_id, $item['nome'], $item['quantidade'], $item['preco']);
                $stmt->execute();
            }

            // Limpar o carrinho após finalizar o pedido
            unset($_SESSION['carrinho']);

            // Redirecionar para a página de confirmação
            header("Location: confirmacao.php?pedido_id=" . $pedido_id);
            exit();

        } catch (mysqli_sql_exception $e) {
            // Tratar exceção caso ocorra um erro na execução da query
            echo "Erro ao finalizar o pedido: " . $e->getMessage();
        }
    } else {
        echo "Total do pedido inválido.";
    }
}
?>
