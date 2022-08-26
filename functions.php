<?php
function conectar(){
    // DADOS PARA CONEXÃO
		$servername = "localhost";
		$database = "banco";
		$username = "root";
		$password = "";
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $database);
		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}else{
			return $conn;
		}
}
function adicionarFabricante($nome, $c1, $c2, $c3){
    $conn = conectar();
    mysqli_query($conn, "INSERT INTO fabricantes (nome, categoria1, categoria2, categoria3) VALUES ('$nome', '$c1', '$c2', '$c3')") or die("erro");
}
function alterarProduto($id, $nome, $fabricante, $categoria, $valor){
    $conn = conectar();
    mysqli_query($conn, "UPDATE produtos SET nome='$nome', fabricante='$fabricante', categoria='$categoria', valor='$valor' WHERE id='$id'") or die("erro");
}
function adicionarProduto($nome, $fabricante, $categoria, $valor){
    $conn = conectar();
    mysqli_query($conn, "INSERT INTO produtos (nome, fabricante, categoria, valor) VALUES ('$nome', '$fabricante', '$categoria', '$valor')") or die("erro");
}
function deletarProduto($id){
    $conn = conectar();
    mysqli_query($conn, "DELETE FROM produtos WHERE id='$id'") or die("erro");
}
function fabricanteById($id){
    $conn = conectar();
    $dados = mysqli_query($conn, "SELECT * FROM fabricantes WHERE id='$id'") or die("Erro");
    $array = mysqli_fetch_array($dados);
    return $array['nome'];
}


?>