<?php

require_once 'conexao.php';
//sessao
session_start();


if(!isset($_SESSION['logado'])):
   header('location: index.php');
  endif;

//dados
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado = mysqli_query($connect, $sql);
$dadosuser = mysqli_fetch_array($resultado);

 $idList = $_POST['id'];
 $sqlList= "SELECT * FROM pedidos WHERE id = '$idList'";
$resultadoList = mysqli_query($connect, $sqlList);
$dadosList = mysqli_fetch_array($resultadoList);

$iduu = $_POST['data'];


?>
<!DOCTYPE html>
<html>
<head>
	<title>teste</title>
</head>
<body>
<?php
	echo $iduu;
?>
</body>
</html>