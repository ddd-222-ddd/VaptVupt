<?php
    switch ($_REQUEST['acao']) {

        case 'cadastrar':
            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST['nome'];
                $desc_prod = $_POST['desc_prod'];
                $preco = $_POST['preco'];
                $tipo = $_POST['tipo'];
                $foto = !empty($_FILES['foto']['tmp_name']) ? addslashes(file_get_contents($_FILES['foto']['tmp_name'])) : null;
            
                $sql = "INSERT INTO PRODUTOS (NOME, DESC_PROD, PRECO, TIPO, FOTO) VALUES ('$nome', '$desc_prod', '$preco', '$tipo', '$foto')";
            $res  = $conn->query($sql);
            
                if ($res === TRUE) {
                    print "<script>alert('Produto cadastrado com sucesso.');</script>";
                    print "<script>location.href='?page=cadastro-produtos'</script>";
                } else {
                    print "<script>alert('Falha em cadastrar.');</script>";
                    print "<script>location.href='?page=cadastro-produtos'</script>";
                }
            }
            break;

        case 'editar':

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nome = $_POST['nome'];
                $desc_prod = $_POST['desc_prod'];
                $preco = $_POST['preco'];
                $tipo = $_POST['tipo'];
        
                $foto_atual = isset($_FILES['foto_atual']) && !empty($_FILES['foto_atual']['tmp_name']) ? $_FILES['foto_atual']['tmp_name'] : null;
        
                if ($foto_atual !== null) {
                    $foto = addslashes(file_get_contents($foto_atual));
                } else {
                    $sql = "SELECT FOTO FROM PRODUTOS WHERE ID=".$_REQUEST['id'];
                    $res = $conn->query($sql);
                    $row = $res->fetch_object();
                    $foto = $row->FOTO;
                }
        
                $sql = "UPDATE PRODUTOS SET 
                        NOME='$nome', 
                        DESC_PROD='$desc_prod', 
                        PRECO='$preco', 
                        TIPO='$tipo', 
                        FOTO='$foto' 
                        WHERE ID=".$_REQUEST['id'];
        
                $res = $conn->query($sql);
                if ($res === TRUE) {
                    print "<script>alert('Produto editado com sucesso.');</script>";
                    print "<script>location.href='?page=produtos'</script>";
                } else {
                    print "<script>alert('Falha em editar produto.');</script>";
                    print "<script>location.href='?page=produtos'</script>";
                }
            }

            break;

        case 'excluir':
            $sql = "DELETE FROM PRODUTOS WHERE ID=".$_REQUEST['id'];

            $res = $conn->query($sql);
            
                if ($res === TRUE) {
                    print "<script>alert('Produto excluido com sucesso.');</script>";
                    print "<script>location.href='?page=produtos'</script>";
                } else {
                    print "<script>alert('Falha em excluir produto.');</script>";
                    print "<script>location.href='?page=produtos'</script>";
                }

            break;
    }