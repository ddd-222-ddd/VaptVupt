<?php
include 'config.php';
session_start();

$sql = "SELECT NOME, DESC_PROD, PRECO, FOTO FROM PRODUTOS WHERE TIPO = 'food'";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cardápio</title>
</head>
<body>
    <h1>Cardápio</h1>
    <form action="carrinho.php" method="post">
        <?php
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo '<div class="menu-item">';
                if (!empty($row["FOTO"])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row["FOTO"]) . '" alt="Imagem do produto">';
                } else {
                    echo '<img src="./img/comida.avif" alt="Imagem padrão">';
                }
                echo '<div class="menu-item-description">';
                echo '<p>' . htmlspecialchars($row["NOME"]) . '</p>';
                echo '<p>' . htmlspecialchars($row["DESC_PROD"]) . '</p>';
                echo '<div class="quantity-control">';
                echo '<button type="button" onclick="adjustQuantity(\'comida' . $row["NOME"] . '\', -1)">-</button>';
                echo '<span id="quantity-comida' . $row["NOME"] . '">0</span>';
                echo '<button type="button" onclick="adjustQuantity(\'comida' . $row["NOME"] . '\', 1)">+</button>';
                echo '<input type="hidden" name="quantidade[' . htmlspecialchars($row["NOME"]) . ']" id="input-comida' . htmlspecialchars($row["NOME"]) . '" value="0">';
                echo '<button type="button" onclick="addToCart(\'' . htmlspecialchars($row["NOME"]) . '\', ' . htmlspecialchars($row["PRECO"]) . ')">Adicionar - R$ ' . number_format($row["PRECO"], 2, ',', '.') . '</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Nenhum produto encontrado.";
        }
        ?>
        <button type="submit">Finalizar Compra</button>
    </form>

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
            alert(name + ' adicionado ao carrinho por R$ ' + price.toFixed(2));
        }
    </script>
</body>
</html>
