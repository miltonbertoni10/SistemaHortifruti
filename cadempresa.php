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
	<script type="text/javascript" src="JS/bootstrap.js"></script>
  <link rel="stylesheet" type="text/css" href="CSS/estilo.css">
  <script src="dist/js/bootstrap-colorpicker.js"></script>
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

              <div class="cadastro-empresa mt-5 container">
                    <h2>Cadastrar Empresa</h2>
            <form class="col-12" action="cadastrar.php" method="post" name="formlogin">
              <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="Text" name="nome" id="nome" placeholder="Nome do Comercio" required>
              </div>
              <div class="mb-2 col-md-6">
                <input class="form-control" type="text" name="endereco" id="endereco" placeholder="Endereço" required>
              </div>
                  <small id="emailHelp" class="form-text text-muted mb-2 ml-2">Selecione uma cor para ser vinculada a empresa</small>
                <div id="cp2" class="mb-2 input-group colorpicker-component formcolorpicker">
                   
              <div class="form-group">
                <div class="col-sm-10">
                  <select name="cor" class="form-control" id="color" required>
                    <option value="">Selecione</option>     
                    <option style="background-color:#FFD700;" value="#FFD700">Amarelo</option>
                    <option style="background-color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                    <option style="background-color:#FF4500;" value="#FF4500">Laranja</option>
                    <option style="background-color:#8B4513;" value="#8B4513">Marrom</option>  
                    <option style="background-color:#1C1C1C;" value="#1C1C1C">Preto</option>
                    <option style="background-color:#436EEE;" value="#436EEE">Royal Blue</option>
                    <option style="background-color:#A020F0;" value="#A020F0">Roxo</option>
                    <option style="background-color:#40E0D0;" value="#40E0D0">Turquesa</option>                    
                    <option style="background-color:#228B22;" value="#228B22">Verde</option>
                    <option style="background-color:#8B0000;" value="#8B0000">Vermelho</option>
                  </select>
                </div>
              </div>
                      
                  </div>

                

              <input class="ml-3 btn btn-primary" type="submit" value="Cadastrar" name="btn-cadastrar-empresa">
            </form>

          </div>
          <div class="consulta-empresa mt-5 container">
                    <h2>Empresas Cadastradas</h2>
          <table class="table mt-2 table-striped">
             <thead class="thead-dark">
            <th cope="col">Nome do Comercio</th>
            <th cope="col">Opções</th>
          
            </thead>
            <?php

                $sql = "SELECT * FROM empresa";
              if(mysqli_query($connect, $sql)):
                $resultado = mysqli_query($connect, $sql);

                while ($dados = mysqli_fetch_array($resultado)):

                  echo "<tr><td>". $dados['nome']. "</td><td><button type='button' class='btn btn-xs btn-warning mt-2 ml-2' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $dados['id'] ."' data-nomeempresa='" . $dados['nome'] ."' data-endereco='". $dados['endereco'] ."'>Editar</button><button type='button' class='btn btn-xs btn-success ml-2 mt-2' data-toggle='modal' data-target='#myModal' data-whatever='" . $dados['id'] ."' data-nomeempresa='" . $dados['nome'] ."' data-endereco='". $dados['endereco'] ."' >Visualizar</button><a name='btn-excluir-fornecedor' class='btn btn-xs btn-danger mt-2 ml-2' href='excempresa.php?id=" . $dados['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a></td></tr>";
                endwhile;
              
              endif;
            ?>
            </table>
            <!-- Inicio Modal editar -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Empresa</h4>
        </div>
        <div class="modal-body">
        <form method="POST" action="processa.php" enctype="multipart/form-data">
          <div class="form-group">
          <label for="recipient-name" class="control-label">Comercio:</label>
          <input name="nome" type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
          <label for="recipient-endereco" class="control-label">Endereço:</label>
          <input name="endereco" type="text" class="form-control" id="recipient-endereco">
          </div>
        


        <input name="id" type="hidden" class="form-control" id="id-empresa" value="">
        
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="btn-editar-empresa" class="btn btn-danger">Alterar</button>
       
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
                        <h3>Informações da empresa</h3>
                        <p><?php echo $dados['id']; ?></p>
                        <h5>Comercio:</h5> <p id="text-name"></p>
                        <h5>Endereço:</h5> <p id="text-endereco"></p>
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
      var recipientnome = button.data('nomeempresa')
      var recipientendereco = button.data('endereco')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-empresa').val(recipient)
      modal.find('#recipient-name').val(recipientnome)
      modal.find('#recipient-endereco').val(recipientendereco)
      
    });

     $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('whatever') // Extract info from data-* attributes
      var recipientnome = button.data('nomeempresa')
      var recipientendereco = button.data('endereco')

      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-title').text('ID ' + recipient)
      modal.find('#id-empresa').text(recipient)
      modal.find('#text-name').text(recipientnome)
      modal.find('#text-endereco').text(recipientendereco)

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