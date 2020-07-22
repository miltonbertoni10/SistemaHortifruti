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
			  <a class="nav-link" href="pedidos.php"><img class="pedidos-img" src="IMG/pedidos.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Pedidos</span></a>
			  <a class="nav-link" href="lista_geral.php"><img src="IMG/listapedidos.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Lista Geral</span></a>
        <a class="nav-link" href="relatorios.php"><img src="IMG/relatorios.svg" width="60" height="60" class="d-inline-block align-top" alt=""><span>Relatorios</span></a>
        </div>
              </nav>

              <div class="cadastro-empresa mt-5 container">
                    <h2>Cadastrar Produto</h2>
            <form class="col-12" action="cadastrar.php" method="post" name="formlogin">
              <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
              <div class="mb-2 col-md-6">
                <select class="form-control" name="tipo">
                  <option value="frutas">Frutas</option>
                  <option value="verduras">Verduras</option>
                  <option value="legumes">Legumes</option>
                  <option value="outros">Outros</option>
                </select>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="Text" name="produto" id="produto" placeholder="Nome do produto" required>
              </div>
              <div class="mb-2 col-md-6">
                <select class="form-control" name="unidade" required>
                  <option value="caixa">Caixa</option>
                  <option value="saco">Saco</option>
                  <option value="KG">Kg</option>
                  <option value="unidade">Unidade</option>
                  <option value="bandeja">Bandeja</option>
                </select>
              </div>
              <div class="mb-2 col-md-6">
                <select class="form-control" name="comprador" required>
                <option value="">Selecione</option>
                <option value="comprador1">comprador 1</option>
                <option value="comprador2">comprador 2</option>
                <option value="comprador3">comprador 3</option>
                <option value="comprador4">comprador 4</option>
                <option value="comprador5">comprador 5</option>
                <option value="comprador6">comprador 6</option>
                <option value="comprador7">comprador 7</option>
                <option value="comprador8">comprador 8</option>
                <option value="comprador9">comprador 9</option>
                <option value="comprador10">comprador 10</option>
                </select>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="text" name="percentual" id="percentual" placeholder="Percentual de repasse" required>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="number" name="fracao" id="fracao" placeholder="Fração" required>
              </div>
              
              
              <input class="ml-3 btn btn-primary" type="submit" value="Cadastrar" name="btn-cadastrar-produto" required>
            </form>

          </div>
          <div class="consulta-empresa mt-5 container">
                    <h2>Consultar</h2>
          <table class="table mt-2 table-striped">
             <thead class="thead-dark">
                    <th cope="col">Nome</th>
            <th cope="col">Ações</th>
            
          
            </thead>

<form class="col-12 center"  action="<?php echo $_SERVER['PHP_SELF'] ?>?palavra=consultar" method="GET" name="formconsulta">
              <div class="center mb-2 col-md-6">
                <input class="form-control" type="text" name="palavra" id="palavra" placeholder="Digite o nome do produto">
              </div>

              <input class="ml-3 btn btn-primary" type="submit" value="Consultar">
            </form>

            <?php
           
      if(isset($_GET['palavra'])):
          $palavra = mysqli_escape_string($connect, $_GET['palavra']);

          $sql = "SELECT * FROM produto WHERE nome LIKE '%$palavra%' ORDER BY nome ";

           if($resultado = mysqli_query($connect, $sql)):

          while ($dados = mysqli_fetch_array($resultado)):
            echo "<tr><td>" . mb_strtoupper($dados['nome'] , 'UTF-8'). "</td><td><button type='button' class='btn btn-xs btn-warning mt-2 ml-2' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $dados['id'] ."' data-nomeproduto='" . $dados['nome'] ."' data-tipoproduto='". $dados['tipo'] ."' data-unidadeproduto='". $dados['unidade'] ."'data-compradorproduto='". $dados['comprador'] ."'data-percentualproduto='". $dados['percentual'] ."'data-fracaoproduto='". $dados['fracao'] ."'>Editar</button><button type='button' class='btn btn-xs btn-success ml-2 mt-2' data-toggle='modal' data-target='#myModal' data-whatever='" . $dados['id'] ."' data-nomeproduto='" . $dados['nome'] ."' data-tipoproduto='". $dados['tipo'] ."' data-unidadeproduto='". $dados['unidade'] ."'data-compradorproduto='". $dados['comprador'] ."'data-percentualproduto='". $dados['percentual'] ."'data-fracaoproduto='". $dados['fracao'] ."' >Visualizar</button><a name='btn-excluir-fornecedor' class='btn btn-xs btn-danger mt-2 ml-2' href='excproduto.php?pagina=1&id=" . $dados['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a></td></tr>";
          endwhile;
        endif;
      endif;
        
            ?>
            </table>
                 <!-- Inicio Modal editar -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">

      <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title" id="exampleModalLabel">Empresa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
        </div>
        <div class="modal-body">
        <form method="POST" action="processa.php" enctype="multipart/form-data">
          <div class="form-group">
          <label for="recipient-name" class="control-label">Nome:</label>
          <input name="nome" type="text" class="form-control" id="recipient-name">
          </div>

           <div class="form-group">
             <label for="recipient-tipo" class="control-label">Tipo:</label>
                <select class="form-control" name="tipo">
                   <option id="recipient-tipo">Selecione</option>
                  <option value="frutas">Frutas</option>
                  <option value="verduras">Verduras</option>
                  <option value="legumes">Legumes</option>
                  <option value="outros">Outros</option>
                </select>
              </div>

              <div class="form-group">
                <label for="recipient-unidade" class="control-label">Medida:</label>
                <select class="form-control" name="unidade" required>
                  <option id="recipient-unidade">Selecione</option>
                  <option value="caixa">Caixa</option>
                  <option value="saco">Saco</option>
                  <option value="KG">Kg</option>
                  <option value="unidade">Unidade</option>
                  <option value="bandeja">Bandeja</option>
                </select>
              </div>

              <div class="form-group">
                <label for="recipient-comprador" class="control-label">Comprador:</label>
                <select class="form-control" name="comprador" required>
                <option id="recipient-comprador">Selecione</option>
                <option value="comprador1">comprador 1</option>
                <option value="comprador2">comprador 2</option>
                <option value="comprador3">comprador 3</option>
                <option value="comprador4">comprador 4</option>
                <option value="comprador5">comprador 5</option>
                <option value="comprador6">comprador 6</option>
                <option value="comprador7">comprador 7</option>
                <option value="comprador8">comprador 8</option>
                <option value="comprador9">comprador 9</option>
                <option value="comprador10">comprador 10</option>
                </select>
              </div>

          <div class="form-group">
          <label for="recipient-percentual" class="control-label">Percentual de repasse:</label>
          <input name="percentual" type="text" class="form-control" id="recipient-percentual">
          </div>
          <div class="form-group">
          <label for="recipient-fracao" class="control-label">Fração:</label>
          <input name="fracao" type="text" class="form-control" id="recipient-fracao">
          </div>
        


        <input name="id" type="hidden" class="form-control" id="id-produto" value="">
        
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="btn-editar-produto" class="btn btn-danger">Alterar</button>
       
        </form>
        </div>
        
      </div>
      </div>
    </div>
<!-- Fim modal editar -->
                <!-- Inicio Modal visualizar -->
                <div class="modal fade"  id="myModal<?php echo $dados['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title text-center" id="myModalLabel">Informações</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                      </div>
                      <div class="modal-body">
                        
                        <p><?php echo $dados['id']; ?></p>
                        <label for="produto">Produto: </label> <p id="text-name"></p>
                        Tipo: <p id="text-tipo"></p>
                        <h5>Unidade:</h5> <p id="text-unidade"></p>
                        <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Fim Modal -->
            </table>


 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>
  <script type="text/javascript">
    $('#exampleModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var recipientnome = button.data('nomeproduto')
      var recipienttipo = button.data('tipoproduto')
      var recipientunidade = button.data('unidadeproduto')
      var recipientcomprador = button.data('compradorproduto')
      var recipientpercentual = button.data('percentualproduto')
      var recipientfracao = button.data('fracaoproduto')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-produto').val(recipient)
      modal.find('#recipient-name').val(recipientnome)
      modal.find('#recipient-tipo').text(recipienttipo)
      modal.find('#recipient-unidade').text(recipientunidade)
      modal.find('#recipient-comprador').text(recipientcomprador)
      modal.find('#recipient-percentual').val(recipientpercentual)
      modal.find('#recipient-fracao').val(recipientfracao)
      
    });

     $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var recipientnome = button.data('nomeproduto')
      var recipienttipo = button.data('tipoproduto')
      var recipientunidade = button.data('unidadeproduto')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-produto').text(recipient)
      modal.find('#text-name').text(recipientnome)
      modal.find('#text-tipo').text(recipienttipo)
      modal.find('#text-unidade').text(recipientunidade)

    });

     $(document).ready(function(){
        $('a[data-confirm]').click(function(ev){
          var href = $(this).attr('href');
          if(!$('#confirm-delete').length){
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">EXCLUIR ITEM<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza de que deseja excluir o item selecionado?</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><a class="btn btn-danger text-white" id="dataComfirmOK">Apagar</a></div></div></div></div>');
          }
          $('#dataComfirmOK').attr('href', href);
              $('#confirm-delete').modal({show: true});
      return false;
    
      });
    });

  </script>


</body>
</html>