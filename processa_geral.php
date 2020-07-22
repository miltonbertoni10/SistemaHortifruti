<?php
require_once 'conexao.php';
session_start();

//cadastro de empresa
if(isset($_POST['btn_enviar_geral'])):
	$nome =  $_POST['produto'];
	$tipo = $_POST['tipo'];
	$quantidade = $_POST['quantidade'];
	$preco = $_POST['preco'];
	$repasse = $_POST['repasse'];
	$fornecedor = $_POST['fornecedor'];
	$data = $_SESSION['data'];
	
		$i = 0;	

	$sql = "INSERT INTO lista (data) VALUES ('$data')";
		mysqli_query($connect, $sql);

	if($id = mysqli_insert_id($connect)){
		foreach($nome as $nomes){
				$tipos = $tipo[$i];
				$quantidades = $quantidade[$i];
				$precos = $preco[$i];
				$repasses = $repasse[$i];
				$fornecedores = $fornecedor[$i];

				$sql = "INSERT INTO lista_geral (nome, tipo, total, preco, repasse, fornecedor, idlista) VALUES ('$nomes', '$tipos', '$quantidades', '$precos','$repasses', '$fornecedores', '$id')";
				mysqli_query($connect, $sql);
				$i++;
	}


	if(mysqli_insert_id($connect)){

	$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>A lista foi cadastrada com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: lista_geral.php");
			
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao finalizar lista <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: lista_geral.php");
		
	}

			
			}
	

	endif;