<?php
$sql = "SELECT * FROM PRODUTOS";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    echo "<div>";
    echo "<table class='table table-hover table-striped table-bordered'>";
    echo "<tr>";
    echo "<th>#</th>";
    echo "<th>NOME</th>";
    echo "<th>DESCRIÇÃO</th>";
    echo "<th>PREÇO</th>";
    echo "<th>TIPO</th>";
    echo "<th>FOTO</th>";
    echo "<th>AÇÕES</th>";
    echo "</tr>";

    while ($row = $res->fetch_object()) {
        
        $id = isset($row->ID) ? $row->ID : 'N/A';
        $nome = isset($row->NOME) ? $row->NOME : 'N/A';
        $desc_prod = isset($row->DESC_PROD) ? $row->DESC_PROD : 'N/A';
        $preco = isset($row->PRECO) ? $row->PRECO : 'N/A';
        $tipo = isset($row->TIPO) ? $row->TIPO : 'N/A';
        $foto = isset($row->FOTO) ? base64_encode($row->FOTO) : null;

        echo "<tr>";
        echo "<td>" . $id . "</td>";
        echo "<td>" . $nome . "</td>";
        echo "<td>" . $desc_prod . "</td>";
        echo "<td>" . $preco . "</td>";
        echo "<td>" . $tipo . "</td>";
        if ($foto) {
            echo '<td><img src="data:image/jpeg;base64,' . $foto . '" height="50" /></td>';
        } else {
            echo '<td>Sem foto</td>';
        }
        echo "<td>
            <button onclick=\"location.href='?page=editar&id=" . $id . "';\" class='btn btn-warning'>Editar</button>
            <button onclick=\"if(confirm('Tem certeza que deseja excluir?')){location.href='?page=salvar&acao=excluir&id=" . $id . "';}else{false}\"class='btn btn-danger'>Excluir</button>
            </td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    print "<script>alert('Nenhum resultado encontrado.');</script>";
}

$conn->close();
?>
