<?php
require_once 'conexao.php';
//sessao
session_start();

//botao enviar
if(isset($_POST['btn-entrar'])):
	$erros = array();
	$login = mysqli_escape_string($connect, $_POST['login']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);

	if(empty($login) or empty($senha)):
		$erros[] = "<div class='alert alert-danger col-md-6'>Os campos login e senha precisam ser preenchidos</div>";
	else:
		$sql = "SELECT nome FROM usuarios WHERE nome = '$login'";
		$resultado = mysqli_query($connect, $sql);
		if(mysqli_num_rows($resultado) > 0):
			$senha = md5($senha);
			$sql = "SELECT * FROM usuarios WHERE nome = '$login' AND senha = '$senha' ";
			$resultado = mysqli_query($connect, $sql);

			if(mysqli_num_rows($resultado) == 1):
				$dados = mysqli_fetch_array($resultado);
				if($dados['acesso'] == 1):
				mysqli_close($connect);
				$_SESSION['logado'] = true;
				$_SESSION['id_usuario'] = $dados['id'];
				header('location: painel.php');
			else:
				$erros[] = "<div class='alert alert-danger col-md-6'>Você não tem permissão para acessar!</div>";
			endif;
			else:
				$erros[] = "<div class='alert alert-danger col-md-6'>Usuario e senha não conferem!</div>";
			endif;	
		else:
			$erros[] = "<div class='alert alert-danger col-md-6'>Usuario inexistente!</div>";
		endif;
	endif;
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<title>PRISMA AUTOMAÇÃO COMERCIAL</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="CSS/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/bootstrap.js"></script>
	<meta name="theme-color" content="#117938">
	<link rel="icon" href="IMG/icon.png">
</head>
<body class="nav-color-p">
	<div class="container center mt-5 pt-5">

	<div  align="center" class="col-md-12">
		<a href="..\..\" class="logo-index" title="Sistema de Hortifruti"><img src="IMG/logoprisma.png"><span class="badge badge-secondary">V. 1.0</span></a>
		<h5 class="nome-logo mt-5">Lista Prisma Automação</h5>
						<?php
							if(!empty($erros)):
								foreach ($erros as $erro):
									echo $erro;
								endforeach;		
							endif
						?>
						<form class="col-12 center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formlogin">
							<div class="center mb-2 col-md-6">
								<input class="form-control" type="text" name="login" placeholder="Entre com o usuario">
							</div>
							<div class="center col-md-6">
								<input class="form-control " type="password" name="senha" placeholder="Digite a senha">
							</div>
							<input  class="btn btn-entrar mt-3" type="submit" value="Entrar" name="btn-entrar">
						</form>

					</div>
					<div class="footer container mt-5 alert ">
						<p>Software desenvolvido pela Prisma Automação Comercial - 2018 Todos os direitos reservados.</p>
					</div>
		</div>

</body>
</html>