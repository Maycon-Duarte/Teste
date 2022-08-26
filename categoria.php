<?php
    include('functions.php');
    $id = $_GET['id'];
    $conn = conectar();
    $dadosFabricante = mysqli_query($conn, "SELECT * FROM fabricantes WHERE id = '$id' ORDER BY nome ASC") or die("Erro");
    while($dados = mysqli_fetch_assoc($dadosFabricante)){
        echo '<option value="'.$dados['categoria1'].'">'.$dados['categoria1'].'</option>';
        if($dados['categoria2']!==''){
            echo '<option value="'.$dados['categoria2'].'">'.$dados['categoria2'].'</option>';
        }
        if($dados['categoria3']!==''){
            echo '<option value="'.$dados['categoria3'].'">'.$dados['categoria3'].'</option>';
        }
    }

?>