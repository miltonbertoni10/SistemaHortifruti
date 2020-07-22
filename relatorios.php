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


$result_pedidos = "SELECT id, titulo, cor, inicio, fim, empresa FROM pedidos";
$resultado_pedidos = mysqli_query($connect, $result_pedidos);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
	<title>PRISMA AUTOMAÇÃO COMERCIAL</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href='CSS/fullcalendar.min.css' rel='stylesheet' />
  <link href='CSS/fullcalendar.print.min.css' rel='stylesheet' media='print' />
      <link href='CSS/personalizado.css' rel='stylesheet' />
      
      <script src='JS/moment.min.js'></script>
      <script src='JS/jquery.min.js'></script>
      <script type="text/javascript" src="JS/bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" href="CSS/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
      <script src='JS/fullcalendar.min.js'></script>
      <script src='locale/pt-br.js'></script>
      <meta name="theme-color" content="#117938">
      <link rel="icon" href="IMG/icon.png">

<body>
	<div>
		<nav class="navbar nav-color-s">
  <a class="navbar-brand" href="..\..\"> 
    <img src="IMG/logoprisma.png" width="170" height="85" class="d-inline-block align-top" alt="">
    </a>
    <span class="title-empresa">Lista Prisma Automação</span>
			
                      
                <div class="painel-user">  


                	<?php 
                	date_default_timezone_set('America/Sao_Paulo');
 
					setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
                	if(isset($_SESSION['logado'])):
                    $logout = "logout.php";
                       echo '<span class="mr-5"> Usuário: ' . $dadosuser['nome'] .'</span>'. strftime('%d/%m/%Y');  
                       echo "<a class='btn btn-sair' href='$logout'>Sair</a>";
                        endif;
                      ?></div>

               </nav>
              </div>
              <nav class="navbar nav-color-p ">
                <div class="container">
                   <a class="nav-link active" href="painel.php"><img src="IMG/home.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Início</span></a>
              	  <a class="nav-link" href="cadempresa.php"><img src="IMG/empresa.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Cad. Empresa</span></a>
			  <a class="nav-link" href="produtos.php"><img src="IMG/produtos.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Produtos</span></a>
			  <a class="nav-link" href="fornecedores.php"><img src="IMG/fornecedor.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Fornecedores</span></a>
			  <a class="nav-link" href="pedidos.php"><img src="IMG/pedidos.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Pedidos</span></a>
			  <a class="nav-link" href="lista_geral.php"><img src="IMG/listapedidos.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Lista Geral</span></a>
        <a class="nav-link" href="relatorios.php"><img src="IMG/relatorios.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Relatorios</span></a>
        </div >
              </nav>
               <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>



              <div class="container mt-5">
                <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>?data=consultar" method="GET" name="formconsulta">
                <h3 class="mt-5">Selecione uma opção abaixo para gerar o relatorio</h3>
                

                 <div class="col-sm-5">
                <input type="radio" name="check" id="fornCheck" onchange="habilitarForn()" value="fornecedor" /> Por fornecedor

                <?php 

                 echo "<select name='fornecedor[]' class='form-control' id='fornecedor' disabled>
                    <option value=''>Selecione</option>";

              $sql_empresa = "SELECT * FROM fornecedor";
                  $resultado_empresa = mysqli_query($connect, $sql_empresa);
              while ($dados_empresa = mysqli_fetch_array($resultado_empresa)){
                      echo 
                   
                    "<option style='color:#000; background-color:".$dados_empresa['cor'].";' value='".$dados_empresa['nome']. "'>".$dados_empresa['nome']."</option>";

                  }
                  echo "</select>";

                ?>
                </div>

                 <div class="col-sm-5">
                <input type="radio" name="check" id="empresaCheck" onchange="habilitarEmpresa()" value="empresa" /> Por Loja

                <?php

               $sql = "SELECT * FROM empresa";
                if(mysqli_query($connect, $sql)):
                  $resultado = mysqli_query($connect, $sql);
                ?>

                  <select name="empresa" class="form-control" id="empresa" disabled>
                    <option value="">Selecione</option>
                    <?php
                    while ($dados = mysqli_fetch_array($resultado)):
                      echo 
                    "<option style='color:#000; background-color:".$dados['cor'].";' alue='".$dados['nome']. "'>".$dados['nome']."</option>";

                  endwhile;
                  endif;

                  ?>
                </div>

                <div class="col-sm-5">
                <input type="radio" name="check" id="geralCheck" onchange="habilitarGeral()" value="Geral" />Geral


                </div>

             <div class="form-group">
              <h3>Data</h3>

              <div class="col-sm-5">
                <div class="input-group date">
                  <input type="date" name="data" class="form-control" id="exemplo" >
                </div>

              </div>
              </div>
              
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" onclick="calculaTotal();" value="Consultar" class="btn btn-success">Gerar Lista</button>
              </div>
            </div>
          </form>
           

           <?php
             if(isset($_GET['data'])):  

          $data = mysqli_escape_string($connect, $_GET['data']);
          $_SESSION['data'] =  $data;
          $sql_data = "SELECT * FROM pedidos WHERE inicio = '$data'";
          $resultado_data = mysqli_query($connect, $sql_data);
          $resulto_dt = mysqli_num_rows($resultado_data);

        if( $resulto_dt == 0){
           echo "<div class='alert alert-danger' role='alert'>Não há pedidos para esse dia!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }else{
          if (empty($_GET['check'])) {
             echo "<div class='alert alert-danger' role='alert'>Selecione uma opção de consulta!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";


          }else if ($_GET['check'] == "empresa") {
          $empresa =  $_GET['empresa'];

          $sql_pedido = "SELECT id FROM pedidos WHERE empresa = '$empresa'";
          $resultado_pedido = mysqli_query($connect, $sql_pedido);
          $dados_pedido = mysqli_fetch_array($resultado_pedido);
          
          $id_pedido = $dados_pedido['id'];

          $sql_itens = "SELECT * FROM itenspedidos WHERE idpedido = '$id_pedido'";
          $resultado_itens = mysqli_query($connect, $sql_itens);
          

          $id_lista = "SELECT id FROM lista WHERE data = '$data'";
          $resultado_id = mysqli_query($connect, $id_lista);
          $dados_id = mysqli_fetch_array( $resultado_id);
          $id_lista = $dados_id['id'];


          $lista = "SELECT * FROM lista_geral WHERE idlista = ' $id_lista'";
          $resultado_lista = mysqli_query($connect, $lista);
          $dados_lista = mysqli_fetch_array( $resultado_lista);

          echo "<div class='scrolltable'><table class='table tabletd mt-2 table-striped'><thead class='thead-dark'>" ;
               echo "<th cope='col'>Produtos</th><th cope='col'>Tipo</th><th cope='col'>Quantidade</th><th cope='col'>Valor</th></thead>";

         while ($dados_itens = mysqli_fetch_array($resultado_itens)) {

            $produto = $dados_itens['nome'];
              $valor = $dados_itens['quantidade'] * $dados_lista['repasse'];

              $sql = "SELECT unidade FROM produto WHERE nome = '$produto'";
              $resultados = mysqli_query($connect, $sql);
              $dados_prod = mysqli_fetch_array($resultados);
              
             echo "<tr><td>".$dados_itens['nome']."</td><td>". $dados_prod['unidade']."</td><td>". $dados_itens['quantidade']."</td><td>". $valor."</td></tr>";
            $total = $valor;
            $valor = 0;

            
         

          }
          echo "</table>";

          echo "</div>";


           
          }else if ($_GET['check'] == "fornecedor") {
            echo "<div class='alert alert-danger' role='alert'>fornecedor<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

          }

         }
          
          endif;
          

           ?>
           </div>

    </body>

    <script type="text/javascript"> 
      function habilitarForn(){
        if(document.getElementById('fornCheck').checked){
            document.getElementById('fornecedor').removeAttribute("disabled");
             document.getElementById('empresa').setAttribute("disabled", "disabled");
              document.getElementById('geralCheck').setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById('onoff').value=''; //Evita que o usuário defina um texto e desabilite o campo após realiza-lo
            document.getElementById('fornecedor').setAttribute("disabled", "disabled");
        }
    }

     function habilitarEmpresa(){
        if(document.getElementById('empresaCheck').checked){
            document.getElementById('empresa').removeAttribute("disabled");
              document.getElementById('fornecedor').setAttribute("disabled", "disabled");
               document.getElementById('geralCheck').setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById('onoff').value=''; //Evita que o usuário defina um texto e desabilite o campo após realiza-lo
            document.getElementById('motivo').setAttribute("disabled", "disabled");
        }
    }

     function habilitarGeral(){
       if(document.getElementById('geralCheck').checked){
            document.getElementById('empresa').removeAttribute("disabled");
              document.getElementById('fornecedor').setAttribute("disabled", "disabled");
               document.getElementById('empresaCheck').setAttribute("disabled", "disabled");
        }
        else {
            document.getElementById('onoff').value=''; //Evita que o usuário defina um texto e desabilite o campo após realiza-lo
            document.getElementById('motivo').setAttribute("disabled", "disabled");
        }
    }
    </script>


</html>