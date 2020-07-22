<?php
	session_start();
	include_once('conexao.php');
	$idpedido = $_POST['id_pedido'];

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Contato</title>
	<head>
	<body>
		<?php
		$result_pedido = "SELECT * FROM pedidos WHERE id = '$idpedido'";
		$resultado_pedido = mysqli_query($connect , $result_pedido);
		$rowpedido = mysqli_fetch_assoc($resultado_pedido);

		$arquivo = "pedido$idpedido.xls";
		$titulo = $rowpedido['titulo'];
		$empresa = $rowpedido['empresa'];
		$date = $rowpedido['inicio'];

		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="6">Planilha de Pedido</tr>';
		$html .= "<td colspan='6'>Pedido: $titulo</tr>";
		$html .= "<td colspan='6'>Empresa: $empresa</tr>";
		$html .= "<td colspan='6'>Data: $date</tr>";
		$html .= '</tr>';


	
		
		$html .= '<tr>';
		$html .= '<td><b>Id</b></td>';
		$html .= '<td><b>Produto</b></td>';
		$html .= '<td><b>Quantidade</b></td>';
		$html .= '</tr>';

		$result_itens = "SELECT * FROM itenspedidos WHERE idpedido = '$idpedido'";
		$resultado_itens = mysqli_query($connect , $result_itens);
		
		while($row_itens = mysqli_fetch_assoc($resultado_itens)){

			$html .= '<tr>';
			$html .= '<td>'.$row_itens["id"].'</td>';
			$html .= '<td>'.$row_itens["nome"].'</td>';
			$html .= '<td>'.$row_itens["quantidade"].'</td>';
			$html .= '</tr>';
			;
		}
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>