<?php
session_start();
include_once("conexao.php");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)){
	$result = "DELETE FROM fornecedor WHERE id='$id'";
	$resultado_fornecedor = mysqli_query($connect, $result);
	if(mysqli_affected_rows($connect)){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
  		Excluido com sucesso!</div>";
		header("Location: fornecedores.php");
		}else{
			
			$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao excluir!</div>";
			header("Location: fornecedores.php");
		}
	}else{	
		$_SESSION['msg'] = "<div class='alert alert-danger'>Necessario selecionar um item!</div>";
		header("Location: fornecedores.php");
	}

	