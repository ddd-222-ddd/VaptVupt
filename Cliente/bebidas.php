<?php
include 'config.php';
session_start();

$sql = "SELECT NOME, DESC_PROD, PRECO, FOTO FROM PRODUTOS WHERE TIPO = 'drink'";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio</title>
    <style>
        .menu-item {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
            width: 400px;
        }
        .menu-item img {
            max-width: 100%;
            height: auto;
        }
        .menu-item-description {
            margin-top: 10px;
        }
        .quantity-control button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .quantity-control span {
            margin: 0 10px;
        }
        .add-to-cart {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Cardápio</h1>
    <form action="carrinho.php" method="post" id="menu-form">
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

    <script>
        function adjustQuantity(id, amount) {
            var quantityElement = document.getElementById('quantity-' + id);
            var inputElement = document.getElementById('input-' + id);
            var quantity = parseInt(quantityElement.textContent) + amount;
            if (quantity < 0) quantity = 0;
            quantityElement.textContent = quantity;
            inputElement.value = quantity;
        }

        function addToCart(name, price) {
            var quantity = document.getElementById('input-' + 'comida' + name).value;
            if (quantity > 0) {
                alert(name + ' adicionado ao carrinho por R$ ' + (price * quantity).toFixed(2));
                document.forms["menu-form"].submit(); // Submeter o formulário
            } else {
                alert("Selecione uma quantidade maior que zero.");
            }
        }
    </script>
</body>
</html>
