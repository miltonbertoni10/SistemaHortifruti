<?php
require_once 'conexao.php';
session_start();

//cadastro de empresa
if(isset($_POST['btn-cadastrar-empresa'])):
	$nomeempresa = mysqli_escape_string($connect, $_POST['nome']);
	$endereco = mysqli_escape_string($connect, $_POST['endereco']);
	$cor = mysqli_escape_string($connect, $_POST['cor']);
	
	$sql = "INSERT INTO empresa (nome, endereco, cor) VALUES ('$nomeempresa', '$endereco', '$cor')";
	if(mysqli_query($connect, $sql)):
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
  		Empresa Cadastrada com sucesso!</div>";
		header('location: cadempresa.php');
	else:
		$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao cadastrar!</div>";
		header('location: cadempresa.php');
	endif;
	endif;
//cadastro de produtos
	if(isset($_POST['btn-cadastrar-produto'])):
	$tipo = mysqli_escape_string($connect, $_POST['tipo']);
	$produto = mysqli_escape_string($connect, $_POST['produto']);
	$unidade = mysqli_escape_string($connect, $_POST['unidade']);
	$comprador = mysqli_escape_string($connect, $_POST['comprador']);
	$percentual = mysqli_escape_string($connect, $_POST['percentual']);
	$fracao = mysqli_escape_string($connect, $_POST['fracao']);
	

	$sql = "INSERT INTO produto (nome, tipo, unidade, comprador, percentual, fracao) VALUES ('$produto', '$tipo','$unidade', '$comprador', '$percentual', '$fracao')";
	
	if(mysqli_query($connect, $sql)):
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
  		Produto cadastrado com sucesso!</div>";
		header('location: produtos.php');
	else:
		$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao cadastrar!</div>";
		header('location: produtos.php');
	endif;
	endif;
//cadastro de fornecedores
	if(isset($_POST['btn-cadastrar-fornecedor'])):
	$nome = mysqli_escape_string($connect, $_POST['nome']);
	$area = mysqli_escape_string($connect, $_POST['area']);
	$contato = mysqli_escape_string($connect, $_POST['contato']);
	$telefone = mysqli_escape_string($connect, $_POST['telefone']);
	
	$sql = "INSERT INTO fornecedor (nome, area, contato,telefone) VALUES ('$nome', '$area','$contato','$telefone')";
	if(mysqli_query($connect, $sql)):
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
  		Fornecedor cadastrado com sucesso!</div>";
		header('location: fornecedores.php');
	else:
		$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao cadastrar!</div>";
		header('location: fornecedores.php');
	endif;
	endif;




?>