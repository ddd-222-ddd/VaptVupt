<?php
include "db.php";
session_start();

$sql = "SELECT * FROM PEDIDOS WHERE STATUS = 'Pendente' ORDER BY DATA_HORA DESC";
$pedidos = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Garçom</title>
</head>
<body>
    <h1>Pedidos Pendentes</h1>
    <?php if ($pedidos->num_rows > 0): ?>
        <ul>
            <?php while ($pedido = $pedidos->fetch_assoc()): ?>
                <li>
                    <p>Pedido ID: <?php echo $pedido['ID']; ?></p>
                    <p>Data e Hora: <?php echo $pedido['DATA_HORA']; ?></p>
                    <p>Total: R$ <?php echo number_format($pedido['TOTAL'], 2, ',', '.'); ?></p>
                    <h2>Itens do Pedido</h2>
                    <ul>
                        <?php
                        $sql = "SELECT * FROM ITENS_PEDIDO WHERE PEDIDO_ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $pedido['ID']);
                        $stmt->execute();
                        $itens_pedido = $stmt->get_result();
                        while ($item = $itens_pedido->fetch_assoc()): ?>
                            <li><?php echo htmlspecialchars($item['PRODUTO_NOME']); ?> - R$ <?php echo number_format($item['PRECO_UNITARIO'], 2, ',', '.'); ?> x <?php echo $item['QUANTIDADE']; ?></li>
                        <?php endwhile; ?>
                    </ul>
                    <form method="POST" action="atualizar_pedido.php">
                        <input type="hidden" name="pedido_id" value="<?php echo $pedido['ID']; ?>">
                        <button type="submit">Marcar como Concluído</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Nenhum pedido pendente.</p>
    <?php endif; ?>
</body>
</html>
