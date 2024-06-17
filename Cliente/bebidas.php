<?php
include 'config.php';
session_start();

$sql = "SELECT NOME, DESC_PROD, PRECO, FOTO FROM PRODUTOS WHERE TIPO = 'drink'";
$res = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantidade']) && is_array($_POST['quantidade'])) {
        foreach ($_POST['quantidade'] as $nome => $quantidade) {
            $quantidade = intval($quantidade);
            if ($quantidade > 0) {
                $preco = $_POST['preco'][$nome];
                $item = [
                    'nome' => $nome,
                    'quantidade' => $quantidade,
                    'preco' => $preco
                ];
                $_SESSION['carrinho'][] = $item;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Cardápio</h1>
    <form action="bebidas.php" method="post" id="menu-form">
        <?php if ($res->num_rows > 0): ?>
            <?php while ($row = $res->fetch_assoc()): ?>
                <div class="menu-item">
                    <?php if (!empty($row["FOTO"])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row["FOTO"]); ?>" alt="Imagem do produto">
                    <?php else: ?>
                        <img src="./img/comida.avif" alt="Imagem padrão">
                    <?php endif; ?>
                    <div class="menu-item-description">
                        <p><?php echo htmlspecialchars($row["NOME"]); ?></p>
                        <p><?php echo htmlspecialchars($row["DESC_PROD"]); ?></p>
                        <div class="quantity-control">
                            <button type="button" onclick="adjustQuantity('<?php echo 'comida' . $row["NOME"]; ?>', -1)">-</button>
                            <span id="quantity-<?php echo 'comida' . $row["NOME"]; ?>">0</span>
                            <button type="button" onclick="adjustQuantity('<?php echo 'comida' . $row["NOME"]; ?>', 1)">+</button>
                            <input type="hidden" name="quantidade[<?php echo htmlspecialchars($row["NOME"]); ?>]" id="input-<?php echo 'comida' . htmlspecialchars($row["NOME"]); ?>" value="0">
                            <input type="hidden" name="preco[<?php echo htmlspecialchars($row["NOME"]); ?>]" value="<?php echo htmlspecialchars($row["PRECO"]); ?>">
                            <button type="button" onclick="addToCart('<?php echo htmlspecialchars($row["NOME"]); ?>', <?php echo htmlspecialchars($row["PRECO"]); ?>)" class="add-to-cart">Adicionar - R$ <?php echo number_format($row["PRECO"], 2, ',', '.'); ?></button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum produto encontrado.</p>
        <?php endif; ?>
    </form>

    <a href="carrinho.php">Ver Carrinho</a>

    <script src="bebidas.js"></script>
</body>
</html>
