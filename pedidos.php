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
      <script>


      $(document).ready(function() {
        $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month'
          },
          defaultDate: Date(),
          navLinks: true, // can click day/week names to navigate views
          editable: true,
          eventLimit: true,
          selectable: true,
          selectHelper: true,

          select: function(start, end){
            $('#cadastrar #start').val(moment(start).format('DD/MM/YYYY'));
            $('#cadastrar #end').val(moment(end).format('DD/MM/YYYY'));
            $('#cadastrar').modal('show');            
          },

         eventClick: function(event) {

            $('#visualizar #id').text(event.id);
            $('#visualizar #id').val(event.id);
            $('#visualizar #title').text(event.title);
            $('#visualizar #start').text(event.start.format('DD/MM/YYYY'));
            $('#visualizar #empresa').text(event.content);

               $('#visualizar').modal('show');
                        
            },
          events: [
            <?php
              while($row = mysqli_fetch_array($resultado_pedidos)){
                ?>
                {
                id: '<?php echo $id_pedido = $row['id']; ?>',
                title: '<?php echo $row['titulo']; ?>',
                start: '<?php echo $row['inicio']; ?>',
                end: '<?php echo $row['fim']; ?>',
                content: '<?php echo $row['empresa']; ?>',
                color: '<?php echo $row['cor']; ?>',
                },<?php
              }
            ?>
          ]
        });
      });

    </script>

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
               <?php
                  if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
            <div class="mt-5" id='calendar'></div>
            <!-- INICIO MODAL VISUALIZAR -->
          <div class="modal" tabindex="-1" role="dialog" id="visualizar">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Informações do pedido</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
              <input type="hidden" name="iduser" id="id">
              <dl>
              <dt>ID do Pedido</dt>
              <dd id="id"></dd>
              <dt>Nome do Pedido</dt>
              <dd id="title"></dd>
              <dt>Pedido para dia</dt>
              <dd id="start"></dd>
              <dt>Realizado por</dt>
              <dd id="empresa"></dd>
              
              
            </dl>
            </div>
            <div class="modal-footer">
              <form  action="detalhes_pedido.php" method="POST" name="formlogin">
               <input name="id" type="hidden" class="form-control" id="id" value="">
                <button type="submit" class="btn btn-success">Mais Informações</button>
              </form>

              <form  action="editar_lista.php" method="POST" name="formlogin">
               <input name="id" type="hidden" class="form-control" id="id" value="">
               <button type="submit" name="btn-editar-pedido" class="btn btn-warning">Editar</button>

              </form>
                 
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
             
            </div>
          </div>
        </div>
      </div>
         <!-- FIM DO MODAL -->
         <!-- INICIO MODAL CADASTRAR -->
         <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center">Criar lista de produtos</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="cadlistaOk" method="POST" action="cadlistaprod.php">

               <?php

               $sql = "SELECT * FROM empresa";
                if(mysqli_query($connect, $sql)):
                  $resultado = mysqli_query($connect, $sql);
                ?>

                <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Empresa</label>
                <div class="col-sm-10">
                  <select name="empresa" class="form-control" id="empresa">
                    <option value="">Selecione</option>
                    <?php
                    while ($dados = mysqli_fetch_array($resultado)):
                      echo 
                    "<option style='color:#000; background-color:".$dados['cor'].";' alue='".$dados['nome']. "'>".$dados['nome']."</option>";

                  endwhile;
                  endif;

                  ?>
                  
                  </select>
                </div>
              </div>


              
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Data</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
                </div>
              </div>
              

                <?php 
                 $sql = "SELECT * FROM produto ORDER BY nome";
                if(mysqli_query($connect, $sql)):
                  $resultado = mysqli_query($connect, $sql);
                    
                    ?>
                  <table class="table container">
                 <thead class="thead-dark">
                <th cope="col" width="50%">Nome</th>
                <th cope="col" width="25%">Medida</th>
                <th cope="col" width="25%">Quantidade</th>
                </thead>
                <?php

                    while ($dados = mysqli_fetch_array($resultado)):
                      $produto[] = $dados['nome'];
                      
                      echo "<tr><td><input type='text' class='form-control' name='produto[]' value='". mb_strtoupper($dados['nome'], 'UTF-8')."' readonly= readonly>

                      </td><td><input type='text' class='form-control' name='medida[]' value='". mb_strtoupper($dados['unidade'], 'UTF-8')."' readonly= readonly></td><td><input type='number' class='form-control' name='quantidade[]' placeholder='Quantidade'></td></tr>";
                    endwhile;
                  endif;
                  $_SESSION['produto'][] = $produto;

                ?>
                </table>
          

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">

                  <a name='btn-finalizar' class="btn btn-primary" data-confirm='Tem certeza de que deseja finalizar o pedido?'>Finalizar</a>
                  <button type="submit" name="btn-salvar" class="btn btn-success">Salvar</button>
                </div>
              </div>
            </form>
        
      </div>
    </div>

    <script type="text/javascript">
        function DataHora(evento, objeto){
        var keypress=(window.event)?event.keyCode:evento.which;
        campo = eval (objeto);
        if (campo.value == '00/00/0000'){
          campo.value=""
        }
       
        caracteres = '0123456789';
        separacao1 = '/';
        separacao2 = ' ';
        conjunto1 = 2;
        conjunto2 = 5;
        conjunto3 = 10;
        conjunto4 = 13;
        conjunto5 = 16;
        if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19)){
          if (campo.value.length == conjunto1 )
          campo.value = campo.value + separacao1;
          else if (campo.value.length == conjunto2)
          campo.value = campo.value + separacao1;
          else if (campo.value.length == conjunto3)
          campo.value = campo.value + separacao2;
          else if (campo.value.length == conjunto4)
          campo.value = campo.value + separacao3;
          else if (campo.value.length == conjunto5)
          campo.value = campo.value + separacao3;
        }else{
          event.returnValue = false;
        }
      }

      $(document).ready(function(){
        $('a[data-confirm]').click(function(ev){
          var href = $(this).attr('href');
          if(!$('#confirm-delete').length){
            $('body').append('<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header bg-danger text-white">Finalizar<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que deseja finalizar o pedido? Ao clicar em finalizar não será possivel mais editar</div><div class="modal-footer"><button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button><button type="submit" name="btn-finalizar" class="btn btn-primary"  id="dataComfirmOK">Finalizar</button></div></div></div></div>');
          }
           $('#confirm-delete').modal({show: true});

          $('#dataComfirmOK').click(function(ev){
              $("#cadlistaOk").submit();
            });

      return false;

    
      });
    });
    </script>
    </script>

</body>
</html>