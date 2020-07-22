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

 $idList = $_POST['id'];
 $sqlList= "SELECT * FROM pedidos WHERE id = '$idList'";
$resultadoList = mysqli_query($connect, $sqlList);
$dadosList = mysqli_fetch_array($resultadoList);

?>
<!DOCTYPE html>
<html>
<head>
	<title>PRISMA AUTOMAÇAO COMERCIAL</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="CSS/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="CSS/estilo.css">
	<script type="text/javascript" src="JS/bootstrap.js"></script>
  <meta name="theme-color" content="#0B6121">
  <link rel="icon" href="IMG/icon.png">
</head>
<body>

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
                    <h2>Pedido Nº <?php echo $dadosList['id'];?></h2>
      <div class="dropdown">
        <span class="glyphicon glyphicon-cog btn-lg text-success" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          <li><a href="form_contato.php">Cadastrar</a></li>
          <li><a href="gerar_planilha.php">Gerar Relatório Excel</a></li>
          <li><a href="#">Gerar Relatório PDF</a></li>
        </ul>
      </div>

      <form class="col-12" action="gerar_planilha.php" method="post" name="formlogin">
      <input name="id_pedido" type="hidden" class="form-control" id="id" value="<?php echo $_POST['id']; ?>">
      <div class="row">
        <div class="pull-right">          
          <button type='submit' class='btn btn-sm btn-success mb-2 navbar-right'>Gerar Excel</button>
        </div>
      </div>
    </form>
            <form class="col-12" action="cadastrar.php" method="post" name="formlogin">
              <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
              <div class="form-group">
                <p>Nome: <?php echo $dadosList['titulo'];?></p>
                <p>Empresa: <?php echo $dadosList['empresa'];?></p>
                <p>Data: <?php echo $dadosList['inicio'];?></p>
              </div>
              <div class="form-group">
                <div class="col-sm-10">
                <?php 
                  
                 $sql = "SELECT * FROM produto";
                if(mysqli_query($connect, $sql)):
                  $resultado_prod = mysqli_query($connect, $sql);
                  $dados_produto = mysqli_fetch_array($resultado_prod)
                    ?>
                    <table class="table container">
                 <thead class="thead-dark">
                <th cope="col" width="40%">Nome</th>
                <th cope="col" width="20%">Medida</th>
                <th cope="col" width="20%">Fração</th>
                <th cope="col" width="20%">Quantidade</th>
                </thead>
                <?php
                $sql_qtd = "SELECT nome, quantidade FROM itenspedidos WHERE idpedido ='$idList' ORDER BY nome";
                if(mysqli_query($connect, $sql_qtd)):
                  $resultado = mysqli_query($connect, $sql_qtd);

                    while ($dados = mysqli_fetch_array($resultado)):
                      
                      
                      echo "<tr><td><input type='text' class='form-control' name='nomeproduto[]' value='" . mb_strtoupper($dados['nome'], 'UTF-8')."' disabled></td></td><td><input type='text' class='form-control' value='".$dados_produto['unidade']."' disabled></td><td><input type='text' class='form-control' value='".$dados_produto['fracao']."' disabled></td><td><input type='number' class='form-control' value='".$dados['quantidade']."' disabled></td></tr>";
                    endwhile;
                  endif;
                  endif;

                ?>
                </table>
              </div>
            </div>


              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
    
                  <a href="pedidos.php" class="btn btn-danger">Voltar</a>
            
                 
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  


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