<?php
$search = $_GET['search'];
include('functions.php');
$conn = conectar();

echo "<tr><td>ID</td><td>Nome Produto</td><td>Fabricante</td><td>Categoria</td><td>Preço</td><td></td><td></td></tr>";
if($search==='' or $search==='undefined'){
    $dadosProdutos = mysqli_query($conn, "SELECT * FROM produtos ORDER BY id ASC") or die("Erro");
    while($dados = mysqli_fetch_assoc($dadosProdutos)){
        echo "
        <tr>
            <td>"
                .$dados['id'].
            "</td>
            <td>"
                .$dados['nome'].
            "</td>
            <td>"
                .fabricanteById($dados['fabricante']).
            "</td>
            <td>"
                .$dados['categoria'].
            "</td>
            <td>R$ "
                .$dados['valor'].
            "</td>
            <td style='text-align:center'>
                ".'<button onclick="editar('."'".$dados["id"]."',"."'".$dados["nome"]."',"."'".$dados["fabricante"]."',"."'".$dados["categoria"]."',"."'".$dados["valor"]."',".')">Editar</button>'."
                <a href='index.php?deletar=".$dados['id']."'><button>Deletar</button></a>
            </td>
        </tr>";
    }
}else{
    $dadosProdutos = mysqli_query($conn, "SELECT * FROM produtos WHERE nome like '%$search%' ORDER BY id ASC") or die("Erro");
    while($dados = mysqli_fetch_assoc($dadosProdutos)){
        echo "
        <tr>
            <td>"
                .$dados['id'].
            "</td>
            <td>"
                .$dados['nome'].
            "</td>
            <td>"
                .fabricanteById($dados['fabricante']).
            "</td>
            <td>"
                .$dados['categoria'].
            "</td>
            <td>R$ "
                .$dados['valor'].
            "</td>
            <td style='text-align:center'>
                ".'<button onclick="editar('."'".$dados["id"]."',"."'".$dados["nome"]."',"."'".$dados["fabricante"]."',"."'".$dados["categoria"]."',"."'".$dados["valor"]."',".')">Editar</button>'."
                <a href='index.php?deletar=".$dados['id']."'><button>Deletar</button></a>
            </td>
        </tr>";
    }
}

?>