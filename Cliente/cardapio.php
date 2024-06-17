<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Cardapio</title>
    <link rel="stylesheet" href="./Css/styles.css">
</head>
<body>
<header>
    <h1>Menu da Lanchonete</h1>
  </header>
  <nav>
    <a href="?page=comida"><button class="nav-button" onclick="showContent('comida')">Comida</button></a>
    <a href="?page=bebidas"><button class="nav-button" onclick="showContent('bebidas')">Bebida</button></a>
    <a href="?page=combos"><button class="nav-button" onclick="showContent('promocoes')">Combos</button></a>
    <a href="?page=carrinho"><button class="nav-button" onclick="showContent('combos')">Carrinho</button></a>
  </nav> 

<?php

include('config.php');

    switch (@$_REQUEST['page']) {
        case 'comida':
            include('comida.php');
            break;

            case 'carrinho':
                include('carrinho.php');
                break;

                case 'combos':
                    include('combos.php');
                    break;

                    case 'bebidas':
                        include('bebidas.php');
                        break;       
        
        default:
            echo "<h1>Bem vindo ^-^/</h1>";
            break;
    }

?>
</body>
</html>