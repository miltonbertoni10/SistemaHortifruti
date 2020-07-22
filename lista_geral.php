
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
  <script type="text/javascript" src="JS/jquery.maskMoney.min.js"></script>
  <meta name="theme-color" content="#117938">
  <link rel="icon" href="IMG/icon.png">
</head>
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
      </div>
              </nav>

              
      <div class="container geral">
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>?data=consultar" method="GET" name="formconsulta">
    				 <div class="form-group">
    					<h3 class="mt-5">Data</h3>

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
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
            

      if(isset($_GET['data'])):
       
          $data = mysqli_escape_string($connect, $_GET['data']);
          $_SESSION['data'] =  $data;

        $sql_data = "SELECT * FROM pedidos WHERE inicio = '$data'";
        $resultado_data = mysqli_query($connect, $sql_data);
        $resulto_dt = mysqli_num_rows($resultado_data);

        if( $resulto_dt == 0){
           echo "<div class='alert alert-danger' role='alert'>Não há pedidos para esse dia!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }else{

        

          $sql_produto = "SELECT * FROM produto ORDER BY nome";
          $resultado_produto = mysqli_query($connect, $sql_produto);
          $result_prod = mysqli_num_rows($resultado_produto);

          echo "<div class='scrolltable'><table class='table tabletd mt-2 table-striped'><thead class='thead-dark'>" ;
               echo "<th cope='col'>Produtos</th><th cope='col'>Tipo</th></thead>";
         while ($dadosprod = mysqli_fetch_array($resultado_produto)) {

             echo "<tr><td>".$dadosprod['nome']."</td><td>".$dadosprod['unidade']."</td></tr>";

          }
          echo "</table>";
          

          $sql = "SELECT * FROM pedidos WHERE inicio = '$data'";
          $resultado = mysqli_query($connect, $sql);

            
            while ($dados_pedidos = mysqli_fetch_array($resultado)) {
              $id = $dados_pedidos['id'];
              $id_array[] = $id;
              echo "<table id='produtos-table' class='table tableh mt-2 table-striped'><thead class='thead-dark'>" ;
              echo "<th cope='col'>".$dados_pedidos['id']." ". $dados_pedidos['empresa']."</th></thead>";

            $sql_itens = "SELECT * FROM itenspedidos WHERE idpedido = '$id'";
            $result = mysqli_query($connect, $sql_itens);

               while ($dados = mysqli_fetch_array($result)) {

               echo "<tr><td>".$dados['quantidade']."</td></tr>";
             }
             echo "</table>";
          
          }
          echo "</div>";

        $sql = "SELECT * FROM lista";
        $resultad = mysqli_query($connect, $sql);
        $dados = mysqli_fetch_array($resultad);

        if($dados['data'] == $data){

          $dados_d = $dados['id'];

          echo "<div class='scrolltable'><form class='col-12 center mb-4'  action='processa.php' method='POST' name='formcadastra'>
          <table class='table mt-2 table-striped'>
             <thead class='thead-dark'>
              <th cope='col' >Produto</th>
              <th cope='col' >Tipo</th>
              <th cope='col' >Total</th>
              <th cope='col' >Preço</th>
              <th cope='col'>Repasse</th>
              <th cope='col' >Fornecedor</th>
            </thead>";

        $sql_lista = "SELECT * from lista_geral WHERE idlista ='$dados_d'";

          $resultado_sql = mysqli_query($connect, $sql_lista);
          $sql_produto = "SELECT * FROM produto ORDER BY nome";
          $resultado_prod = mysqli_query($connect, $sql_produto);

            while ($dados = mysqli_fetch_array($resultado_sql)) {
              $dadosprod = mysqli_fetch_array($resultado_prod);
               echo "<tr><td><input type='text' class='form-control' name='produto[]'value='".$dadosprod['nome']."' readonly= readonly  ></td><td><input type='text' class='form-control' name='tipo[]'value='".$dadosprod['unidade']."' readonly= readonly  ></td><td><input type='number' class='form-control' name='quantidade[]'value='".$dados['total']."' readonly= readonly  ></td><td><input type='text' class='form-control' name='preco[]' id='maskmoney' value='".$dados['preco']."' readonly= readonly  ></td><td><input type='text' class='form-control' name='repasse[]' value='".$dados['repasse']."' readonly= readonly></td>";

               echo "<td><input type='text' name='fornecedor[]' class='form-control' id='empresa' readonly= readonly value='".$dados['fornecedor']. "'></td></tr>";     

             }
          echo 
        "</table>
        <button type='submit' class='btn btn-danger' name='btn_enviar_geral'>Excluir</button> 
        <button type='submit' class='btn btn-warning' name='btn_enviar_geral'>Editar</button> 
      </form></div>";


         
        }else{


            ?>


            </script>
            <form class="col-12 center"  action="processa_geral.php" method="POST" name="formcadastra">
          <table class="table mt-2 table-striped">
             <thead class="thead-dark">
              <th cope="col" width="20%">Produto</th>
              <th cope="col" width="10%">Tipo</th>
              <th cope="col"width="10%">Total</th>
              <th cope="col"width="10%">Preço</th>
              <th cope="col"width="10%">Repasse</th>
              <th cope="col" width="20%">Fornecedor</th>
            </thead>


             <?php



          $nuns = '' . implode(',', $id_array) . '';

        $sql_itens = "SELECT itenspedidos.*,sum(case when itenspedidos.nome = itenspedidos.nome  then +itenspedidos.quantidade
        else itenspedidos.quantidade
        end) as 'quantidade'
        from
            itenspedidos
            WHERE idpedido IN ($nuns)
        group by
            nome
        order by
            nome";

          $result = mysqli_query($connect, $sql_itens);
          $sql_produto = "SELECT * FROM produto ORDER BY nome";
          $resultado_prod = mysqli_query($connect, $sql_produto);

            while ($dados = mysqli_fetch_array($result)) {
              $dadosprod = mysqli_fetch_array($resultado_prod);
               echo "<tr><td><input type='text' class='form-control' name='produto[]'value='".$dadosprod['nome']."' readonly= readonly  ></td><td><input type='text' class='form-control' name='tipo[]'value='".$dadosprod['unidade']."' readonly= readonly  ></td><td><input type='number' class='form-control' name='quantidade[]'value='".$dados['quantidade']."' readonly= readonly  ></td><td><input type='text' class='form-control' name='preco[]' id='maskmoney' placeholder='Preço'></td><td><input type='text' class='form-control' name='repasse[]' placeholder='Repasse'></td>";

               echo "<td><select name='fornecedor[]' class='form-control' id='empresa'>
                    <option value=''>Selecione</option>";

              $sql_empresa = "SELECT * FROM fornecedor";
                  $resultado_empresa = mysqli_query($connect, $sql_empresa);
              while ($dados_empresa = mysqli_fetch_array($resultado_empresa)){
                      echo 
                   
                    "<option style='color:#000; background-color:".$dados_empresa['cor'].";' value='".$dados_empresa['nome']. "'>".$dados_empresa['nome']."</option>";

                  }
                  echo "</select></td></tr>";     

             }
          echo 
        "</table>
        <button type='submit' class='btn btn-primary' name='btn_enviar_geral'>Finalizar</button> 
      </form>";

           }
         }
          
          endif;
          

      ?>
    		</div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
		
		<script type="text/javascript">

      $(document).ready(function () {
   
        $(document).ready(function($){
               // Configuração padrão.
               $("#maskmoney").maskMoney({decimal:",", thousands:"."});              
       });


			$('#exemplo').datepicker({	
				format: "dd/mm/yyyy",	
				language: "pt-BR",
				startDate: '+0d',
			});


      $(document).ready(function () {
        $('#dtHorizontalExample').DataTable({
          "scrollX": true
        });
        $('.dataTables_length').addClass('bs-select');
      });
		</script>

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>

</body>
</html>