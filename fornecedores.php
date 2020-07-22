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
                	
    
					setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                	if(isset($_SESSION['logado'])):
                    $logout = "logout.php";
                       echo '<span class="mr-5"> Usuário: ' . $dadosuser['nome'] .'</span>'. strftime('%d/%m/%Y'); 

                       echo "<a class='btn btn-sair' href='$logout'>Sair</a>";
                        endif;
                      ?></div>

               </nav>
              </div>
              <nav class="navbar nav-color-p">
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

              <div class="cadastro-fornecedor mt-5 container">
                    <h2>Cadastrar Fornecedor</h2>
            <form class="col-12" action="cadastrar.php" method="post" name="formlogin">
              <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="Text" name="nome" id="nome" placeholder="Nome do fornecedor " required>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="Text" name="area" id="area" placeholder="Area do fornecedor " required>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="Text" name="contato" id="contato" placeholder="contato " required>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="tel" name="telefone" id="telefone" placeholder="Telefone " required>
              </div>
             
              
              <input class="ml-3 btn btn-primary" type="submit" value="Cadastrar" name="btn-cadastrar-fornecedor" required>
            </form>
          </div>


          <div class="consulta-fornecedor mt-5 container">
                    <h2>Fornecedores cadastrados</h2>
          <table class="table mt-2 table-striped">
             <thead class="thead-dark">
                    <th cope="col">Nome</th>
            <th cope="col">Ações</th>
          
            </thead>
            <?php

                $sql = "SELECT * FROM fornecedor";
              if(mysqli_query($connect, $sql)):
                $resultado = mysqli_query($connect, $sql);

                while ($dados = mysqli_fetch_array($resultado)):

                  echo "<tr><td>" . $dados['nome']. "</td><td><button type='button' class='btn btn-xs btn-warning mt-2 ml-2' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $dados['id'] ."' data-nomefornecedor='" . $dados['nome'] ."' data-areafornecedor='". $dados['area'] ."' data-contatofornecedor='". $dados['contato'] ."' data-telefonefornecedor='". $dados['telefone'] ."'>Editar</button><button type='button' class='btn btn-xs btn-success ml-2 mt-2' data-toggle='modal' data-target='#myModal' data-whatever='" . $dados['id'] ."' data-nomefornecedor='" . $dados['nome'] ."' data-areafornecedor='". $dados['area'] ."' data-contatofornecedor='". $dados['contato'] ."' data-telefonefornecedor='". $dados['telefone'] ."'>Visualizar</button><a name='btn-excluir-fornecedor' class='btn btn-xs btn-danger mt-2 ml-2' href='excfornecedor.php?pagina=1&id=" . $dados['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a></td></tr>";
            
                endwhile;
              
              endif;

            ?>    
                    
                  </td>
                </tr>
<!-- Inicio Modal editar -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Fornecedor</h4>
        </div>
        <div class="modal-body">
        <form method="POST" action="processa.php" enctype="multipart/form-data">
          <div class="form-group">
          <label for="recipient-name" class="control-label">Nome do fornecedor:</label>
          <input name="nome" type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
          <label for="recipient-area" class="control-label">Aréa do fornecedor:</label>
          <input name="area" type="text" class="form-control" id="recipient-area">
          </div>
          <div class="form-group">
          <label for="recipient-contato" class="control-label">Contato:</label>
          <input name="contato" type="text" class="form-control" id="recipient-contato">
          </div>
          <div class="form-group">
          <label for="recipient-telefone" class="control-label">Telefone:</label>
          <input name="telefone" type="text" class="form-control" id="recipient-telefone">
          </div>


        <input name="id" type="hidden" class="form-control" id="id-fornecedor" value="">
        
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-danger" name="btn-editar-fornecedor">Alterar</button>
       
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="myModalLabel">Informações</h4>
                      </div>
                      <div class="modal-body">
                        <h3>Informações Sobre o fornecedor</h3>
                        <p><?php echo $dados['id']; ?></p>
                        <h5>Nome do Fornecedor:</h5> <p id="text-name"></p>
                        <h5>Aréa do fornecedor:</h5> <p id="text-area"></p>
                        <h5>Contato:</h5> <p id="text-contato"></p>
                        <h5>Telefone:</h5><p id="text-telefone"></p>
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
      var recipientnome = button.data('nomefornecedor')
      var recipientarea = button.data('areafornecedor')
      var recipientcontato = button.data('contatofornecedor')
      var recipienttelefone = button.data('telefonefornecedor')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-fornecedor').val(recipient)
      modal.find('#recipient-name').val(recipientnome)
      modal.find('#recipient-area').val(recipientarea)
      modal.find('#recipient-contato').val(recipientcontato)
      modal.find('#recipient-telefone').val(recipienttelefone)
      
    });

     $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var recipientnome = button.data('nomefornecedor')
      var recipientarea = button.data('areafornecedor')
      var recipientcontato = button.data('contatofornecedor')
      var recipienttelefone = button.data('telefonefornecedor')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-fornecedor').text(recipient)
      modal.find('#text-name').text(recipientnome)
      modal.find('#text-area').text(recipientarea)
      modal.find('#text-contato').text(recipientcontato)
      modal.find('#text-telefone').text(recipienttelefone)
      
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