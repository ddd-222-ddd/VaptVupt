<?php
include 'config.php';
session_start();

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['total_pedido']) && is_numeric($_POST['total_pedido'])) {
        $total = $_POST['total_pedido'];

        try {
            $conn->begin_transaction();

            $sql_pedido = "INSERT INTO PEDIDOS (DATA_HORA, TOTAL, STATUS) VALUES (NOW(), ?, 'Pendente')";
            $stmt_pedido = $conn->prepare($sql_pedido);
            $stmt_pedido->bind_param("d", $total);
            $stmt_pedido->execute();
            $pedido_id = $stmt_pedido->insert_id;

            $sql_itens = "INSERT INTO ITENS_PEDIDO (PEDIDO_ID, PRODUTO_NOME, QUANTIDADE, PRECO_UNITARIO) VALUES (?, ?, ?, ?)";
            $stmt_itens = $conn->prepare($sql_itens);

            foreach ($carrinho as $item) {
                $stmt_itens->bind_param("isid", $pedido_id, $item['nome'], $item['quantidade'], $item['preco']);
                $stmt_itens->execute();
            }

            $conn->commit();
            unset($_SESSION['carrinho']);
            header("Location: confirmacao.php?pedido_id=" . $pedido_id);
            exit();

        } catch (Exception $e) {
            $conn->rollback();
            echo "Erro ao finalizar o pedido: " . $e->getMessage();
        }
    } else {
        echo "Total do pedido inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Carrinho de Compras</h1>

    <?php if (!empty($carrinho)): ?>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrinho as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['quantidade'] * $item['preco'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form action="carrinho.php" method="post">
            <input type="hidden" name="total_pedido" value="<?php echo $total; ?>">
            <button type="submit">Finalizar Pedido</button>
        </form>

    <?php else: ?>
        <p>O carrinho está vazio.</p>
    <?php endif; ?>
</body>
</html>
