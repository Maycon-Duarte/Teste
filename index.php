<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <?php 
    include("functions.php");
    if(isset($_POST['AdicionarFabricante'])){
        adicionarFabricante($_POST["fabricante"], $_POST["categoria1"], $_POST["categoria2"], $_POST["categoria3"]);
        header("refresh:0");
    }
    if(isset($_POST['AdicionarProduto'])){
        adicionarProduto($_POST['produto'], $_POST['fabricante'], $_POST['categoria'], $_POST['valor']);
        header("refresh:0");
    }
    if(isset($_GET['deletar'])){
        deletarProduto($_GET['deletar']);
        header("index.php");
    }
    if(isset($_POST['alterarProduto'])){
        alterarProduto($_POST['id'], $_POST['nome'], $_POST['fabricante'], $_POST['categoria'], $_POST['valor']);
        header("refresh:0");
    }
    
    ?>
    <title>Document</title>
</head>
<body onload="carregar()">
    <section class="conteudo">
        <form action="index.php" method="POST" id="formFabricante">
            <legend>Fabricante e Categoria</legend>
            <label>Fabricante</label><br>
            <input class="textInput" type="text" name="fabricante" required><br>
            <label>Categoria:</label><br>
            <input class="textInput" type="text" name="categoria1" required><br>
            <input class="textInput" type="text" name="categoria2"><br>
            <input class="textInput" type="text" name="categoria3"><br>
            <input class="submit" type="submit" name="AdicionarFabricante" value="Adicionar">
        </form>
        <form action="index.php" method="POST" id="formProdutos">
            <legend>Produtos</legend>
            <label>Nome do Produto</label><br>
            <input class="textInput" type="text" name="produto" required><br>
            <label>Fabricante</label><br>
            <select id="fabricante" name="fabricante">
            <?php
                $conn = conectar();
                $dadosFabricante = mysqli_query($conn, "SELECT * FROM fabricantes ORDER BY nome ASC") or die("Erro");
                while($dados = mysqli_fetch_assoc($dadosFabricante)){
                    echo '<option value="'.$dados['id'].'">'.$dados['nome'].'</option>';
                }
            ?>
            </select><br>
            <label>Categoria</label><br>
            <select id="categoria" name="categoria">
                <option value="Categoria">Categoria</option>
            </select><br>
            <label>Preço</label><br>
            R$ <input class="textInput" type="number" name="valor" step="0.01" min="0.01" required><br>
            <input class="submit" type="submit" name="AdicionarProduto" value="Adicionar">
        </form>
    </section>
    <section class="conteudo">
        <input id="search" type="search">
        <table id="table">
            <?php
                $dadosProdutos = mysqli_query($conn, "SELECT * FROM produtos ORDER BY id ASC") or die("Erro");
                echo "<tr><td>ID</td><td>Nome Produto</td><td>Fabricante</td><td>Categoria</td><td>Preço</td><td></td><td></td></tr>";
                while($dados = mysqli_fetch_assoc($dadosProdutos)){
                    $nome = $dados['nome'];
                    $fabricante = $dados['fabricante'];
                    $categoria = $dados['categoria'];
                    $valor = $dados['valor'];

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
            ?>
        </table>
    </section>
    <div id="modal">
    <form action="index.php" method="POST" id="formModal" >
            <legend>Produtos</legend>
            <label>Nome do Produto</label><br>
            <input id="idModal" type="text" style="display: none;" name="id">
            <input id="modalNome" class="textInput" type="text" name="nome"><br>
            <label>Fabricante:</label><br>
            <select id="modalFabricante" name="fabricante">
            <?php
                $conn = conectar();
                $dadosFabricante = mysqli_query($conn, "SELECT * FROM fabricantes ORDER BY nome ASC") or die("Erro");
                while($dados = mysqli_fetch_assoc($dadosFabricante)){
                    echo '<option value="'.$dados['id'].'">'.$dados['nome'].'</option>';
                }
            ?>
            </select><br>
            <label>Categoria</label><br>
            <select id="modalCategoria" name="categoria">
                <option value="Categoria">Categoria</option>
            </select><br>
            <label>Preço</label><br>
            R$ <input id="modalValor" class="textInput" type="number" name="valor" step="0.01" min="0.01" required><br>
        </form>
        <input class="submit" type="submit" name="alterarProduto" value="Alterar" form="formModal">
        <button onclick="fecharModal()">Cancelar</button>
    </div>
    <script>

    $('#fabricante').change(function(){
        //console.log("executado");
        var select = document.getElementById("fabricante");
        var id = select.options[select.selectedIndex].value;
        $.ajax({
			type:'POST',
			dataType: 'html',
			url: 'categoria.php?id='+id,
			success: function (msg) {
				$('#categoria').html(msg);
			} 
		});
        console.log('categoria.php?id='+id);
    })

    $('#modalFabricante').change(function(){
        //console.log("executado");
        var select = document.getElementById("modalFabricante");
        var id = select.options[select.selectedIndex].value;
        $.ajax({
			type:'POST',
			dataType: 'html',
			url: 'categoria.php?id='+id,
			success: function (msg) {
				$('#modalCategoria').html(msg);
			} 
		});
        console.log('categoria.php?id='+id);
    })

    function carregar(){
        var select = document.getElementById("fabricante");
        var id = select.options[select.selectedIndex].value;
        $.ajax({
			type:'POST',
			dataType: 'html',
			url: 'categoria.php?id='+id,
			success: function (msg) {
				$('#categoria').html(msg);
			} 
		});
        console.log('categoria.php?id='+id);
    }

    function carregarModal(){
        var select = document.getElementById("modalFabricante");
        var id = select.options[select.selectedIndex].value;
        $.ajax({
			type:'POST',
			dataType: 'html',
			url: 'categoria.php?id='+id,
			success: function (msg) {
				$('#modalCategoria').html(msg);
			} 
		});
        console.log('categoria.php?id='+id);
    }

    

    $("#search").keyup(function(){
        var search = document.getElementById("search").value;
        $.ajax({
			type:'POST',
			dataType: 'html',
			url: 'table.php?search='+search,
			success: function (msg) {
				$('#table').html(msg);
			} 
		});
        console.log("executado"+search);
    })

    function editar(id, nome, fabricante, categoria, valor){
        document.getElementById("modal").style.display = "block";
        document.getElementById("modalNome").value = nome;
        document.getElementById("modalFabricante").value = fabricante;
        document.getElementById("modalCategoria").value = categoria;
        document.getElementById("modalValor").value = valor;
        document.getElementById("idModal").value = id;
        carregarModal();
    }

    function fecharModal(){
        document.getElementById("modal").style.display = "none";
    }

    
    </script>
</body>
</html>