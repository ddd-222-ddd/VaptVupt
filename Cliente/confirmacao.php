<?php
include 'config.php';

$pedido_id = $_GET['pedido_id'];

$sql = "SELECT * FROM PEDIDOS WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$pedido = $stmt->get_result()->fetch_assoc();

$sql = "SELECT * FROM ITENS_PEDIDO WHERE PEDIDO_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$itens_pedido = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Pedido</title>
</head>
<body>
    <h1>Pedido Confirmado</h1>
    <p>Pedido ID: <?php echo $pedido['ID']; ?></p>
    <p>Data e Hora: <?php echo $pedido['DATA_HORA']; ?></p>
    <p>Total: R$ <?php echo number_format($pedido['TOTAL'], 2, ',', '.'); ?></p>
    <h2>Itens do Pedido</h2>
    <ul>
        <?php while ($item = $itens_pedido->fetch_assoc()): ?>
            <li><?php echo htmlspecialchars($item['PRODUTO_NOME']); ?> - R$ <?php echo number_format($item['PRECO_UNITARIO'], 2, ',', '.'); ?> x <?php echo $item['QUANTIDADE']; ?></li>
        <?php endwhile; ?>
    </ul>
    <a href="cardapio.php">Voltar ao cardápio</a>
</body>
</html>
