<?php
session_start();

//Incluir conexao com BD
include_once("conexao.php");
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING);


if(!empty($start) && !empty($empresa)){



if(isset($_POST['btn-salvar'])){
	$data = explode(" ", $start);
	list($date, $hora) = $data;

	$data = substr($start,6,4)."-".substr($start,3,2)."-".substr($start,0,2);

	$sql = "SELECT * FROM pedidos WHERE inicio = '$data' AND empresa = '$empresa'";
	$resultado = mysqli_query($connect, $sql);

	if($dados = mysqli_num_rows($resultado)){

		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>O pedido para o dia $start já foi salvo ou finalizado! Edite o pedido caso não tenha sido finalizado ou entre em contato com o administrador para liberar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header('location: pedidos.php');
		

	}else{


	$sql_cor = "SELECT cor FROM empresa WHERE nome = '$empresa'";
	$resultado = mysqli_query($connect, $sql_cor);
	$dados = mysqli_fetch_array($resultado);

	$color = $dados['cor'];
	$title = $empresa ." ". date('d/m/Y',  strtotime($data));

	$salvar = 1;

	$sql = "INSERT INTO pedidos (titulo, cor, inicio, fim, empresa,final) VALUES ('$title', '$color', '$data', '$data',  '$empresa', '$salvar')";
	 mysqli_query($connect, $sql);

	if($id = mysqli_insert_id($connect)){
					$i = 0;
					
					foreach($_POST['produto'] as $produto){
						$quantidade = $_POST['quantidade'][$i];
						if(empty($quantidade)){
							$quantidade = 0;
							$sql = "INSERT INTO itenspedidos (nome, quantidade, idpedido) VALUES ('$produto','$quantidade','$id' )";
							mysqli_query($connect, $sql);
							$i++;
						}else{
							$sql = "INSERT INTO itenspedidos (nome,quantidade, idpedido) VALUES ('$produto','$quantidade','$id' )";
							mysqli_query($connect, $sql);
							$i++;
						}
					}	

	}
	$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O pedido foi salvo com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header('location: pedidos.php');

	}

	if(!mysqli_insert_id($connect)){

		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O pedido foi salvo mas ainda não foi finalizado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header('location: pedidos.php');
		
		
	}
}else{
	$data = explode(" ", $start);
	list($date, $hora) = $data;

	$data = substr($start,6,4)."-".substr($start,3,2)."-".substr($start,0,2);

	$sql = "SELECT * FROM pedidos WHERE inicio = '$data' AND empresa = '$empresa'";
	$resultado = mysqli_query($connect, $sql);

	if($dados = mysqli_num_rows($resultado)){

		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>O pedido para o dia $start já foi salvo ou finalizado! Edite o pedido caso não tenha sido finalizado ou entre em contato com o administrador para liberar<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header('location: pedidos.php');
		

	}else{


	$sql_cor = "SELECT cor FROM empresa WHERE nome = '$empresa'";
	$resultado = mysqli_query($connect, $sql_cor);
	$dados = mysqli_fetch_array($resultado);

	$color = $dados['cor'];
	$title = $empresa ." ". date('d/m/Y',  strtotime($data));

	$finalizar = 0;

	$sql = "INSERT INTO pedidos (titulo, cor, inicio, fim, empresa,final) VALUES ('$title', '$color', '$data', '$data',  '$empresa', '$finalizar')";
	 mysqli_query($connect, $sql);

	if($id = mysqli_insert_id($connect)){
					$i = 0;
					foreach($_POST['produto'] as $produto){
						$quantidade = $_POST['quantidade'][$i];
						if(empty($quantidade)){
							$quantidade = 0;
							$sql = "INSERT INTO itenspedidos (nome,quantidade, idpedido) VALUES ('$produto','$quantidade','$id' )";
							mysqli_query($connect, $sql);
							$i++;
						}else{
							$sql = "INSERT INTO itenspedidos (nome,quantidade, idpedido) VALUES ('$produto','$quantidade','$id' )";
							mysqli_query($connect, $sql);
							$i++;
						}
					}


	if(mysqli_insert_id($connect)){

		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>O pedido foi realizado com Sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header('location: pedidos.php');
		
		
	}						
	}
	}
}	
}