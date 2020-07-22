<?php
	session_start();
	include_once("conexao.php");
if(isset($_POST['btn-editar-fornecedor'])):
	$id = mysqli_real_escape_string($connect, $_POST['id']);
	$nome = mysqli_real_escape_string($connect, $_POST['nome']);
	$area = mysqli_real_escape_string($connect, $_POST['area']);
	$contato = mysqli_real_escape_string($connect, $_POST['contato']);
	$telefone = mysqli_real_escape_string($connect, $_POST['telefone']);

	$result = "UPDATE fornecedor SET nome='$nome', area =  '$area', contato = '$contato', telefone= '$telefone' WHERE id = '$id'";
	
	$resultado_fornecedor = mysqli_query($connect, $result);	

		if(mysqli_affected_rows($connect) != 0){
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
	  		Alterado com sucesso!</div>";
			header('location: fornecedores.php');	
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao Alterar!</div>";
			header('location: fornecedores.php');
		}
		
	endif;

	if(isset($_POST['btn-editar-produto'])):
	$id = mysqli_real_escape_string($connect, $_POST['id']);
	$nome = mysqli_real_escape_string($connect, $_POST['nome']);
	$tipo = mysqli_real_escape_string($connect, $_POST['tipo']);
	$unidade = mysqli_real_escape_string($connect, $_POST['unidade']);




	$result = "UPDATE produto SET nome='$nome', tipo =  '$tipo', unidade = '$unidade' WHERE id = '$id'";
	
	$resultado_fornecedor = mysqli_query($connect, $result);	

		if(mysqli_affected_rows($connect) != 0){
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
	  		Alterado com sucesso!</div>";
			header('location: produtos.php');	
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao Alterar!</div>";
			header('location: produtos.php');
		}
		
	endif;

	if(isset($_POST['btn-editar-empresa'])):
	$id = mysqli_real_escape_string($connect, $_POST['id']);
	$nome = mysqli_real_escape_string($connect, $_POST['nome']);
	$endereco = mysqli_real_escape_string($connect, $_POST['endereco']);

	$result = "UPDATE empresa SET nome='$nome', endereco =  '$endereco' WHERE id = '$id'";
	
	$resultado_fornecedor = mysqli_query($connect, $result);	

		if(mysqli_affected_rows($connect) != 0){
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
	  		Alterado com sucesso!</div>";
			header('location: cadempresa.php');	
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao Alterar!</div>";
			header('location: cadempresa.php');
		}
		
	endif;


	if(isset($_POST['btn-editar-lista'])):

	$idlist = mysqli_real_escape_string($connect, $_POST['idlist']);
	$empresa = mysqli_real_escape_string($connect, $_POST['empresa']);
	$start = mysqli_real_escape_string($connect, $_POST['start']);

	echo $start = date('Y/d/m',  strtotime($start));
	$title = $empresa ." " . date('d/m/Y',  strtotime($start));

	$sql_cor = "SELECT cor FROM empresa WHERE nome = '$empresa'";
	$resultado = mysqli_query($connect, $sql_cor);
	$dados = mysqli_fetch_array($resultado);

	$cor = $dados['cor'];

	$result = "UPDATE pedidos SET titulo = '$title', cor = '$cor', inicio= '$start', fim ='$start', empresa='$empresa'  WHERE id = '$idlist'";

				mysqli_query($connect, $result);



				$sql_produto = "SELECT id,nome FROM itenspedidos WHERE idpedido = '$idlist'";

				$resultado = mysqli_query($connect, $sql_produto);
				$i=0;
				while ($dados = mysqli_fetch_array($resultado)) {
					$id = $dados['id'];
					$nome = $dados['nome'];
					$quantidade = $_POST["quantidade"][$i];
                   $sql = "UPDATE itenspedidos SET nome = '$nome', quantidade = '$quantidade' WHERE idpedido = '$idlist' AND id ='$id'";
					mysqli_query($connect, $sql);
 					$i++;
				}
	

		if(mysqli_affected_rows($connect) != 0){
			$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>
	  		Alterado com sucesso!</div>";
	  		header('location: pedidos.php');
	  		
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger'>Ocorreu um erro ao Alterar!</div>";	
			header('location: pedidos.php');
		}
		
	endif;

?>