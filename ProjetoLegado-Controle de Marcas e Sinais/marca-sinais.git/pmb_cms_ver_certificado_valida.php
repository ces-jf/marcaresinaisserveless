<?php
require_once ('pmb_conecta.php');

require_once ('pmb_cabecalho_ver.php');

?>

<form method="post" action="pmb_cms_ver_certificado_valida.php" name="formulario">
<table border=0 width=650>
    <tr>
        <td colspan='3' align='center' class='td-titulo1' width='650'>Valida Certificado</td>
    </tr>
    <tr><td></td></tr>
    <tr>
	<td colspan='3'>
	    Certificado n&ordm;. <input type="text" name="numero">
	    <input type="submit" value="Buscar">
	</td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td align='center' colspan='3' class='td-titulo2'></td>
    <tr>
    <tr><td><br></td></tr>

    <?php
	if (isset($_POST['numero'])) {
	    $numero = $_POST['numero'];
	    
	    $data = substr($numero, 6, 2) . "/" . substr($numero, 4, 2) . "/" . substr($numero, 0, 4);
	    $hora = substr($numero, 8, 2) . ":" . substr($numero, 10, 2) . ":" . substr($numero, 12, 2);
	    $sequencia = substr($numero, 14, 1);
	
	    require_once ('pmb_conecta.php');
    
    	    $sql = "select 
			tipo, 
			localidade, 
			produtor, 
			cpf, 
			data_certificado,
			hora_certificado,
			numero,
			caminho
		from 
		    cms_certificados
		where
		    data_certificado = '$data'
		and
		    hora_certificado = '$hora'
		and
		    sequencia = $sequencia";

	   // $result = pg_query($conect, $sql);

		$sql = $db->query($sql);	   
	
	    if ($linha = $db->fetchArray($sql)) {
	
		$tipo = $linha['tipo'];
	    
		if ($tipo = "m")
		    $tipo = "Marca";
		else
		    $tipo = "Sinal";
		
		$localidade = $linha['localidade'];
		$produtor = $linha['produtor'];
		$cpf = $linha['cpf'];
		$data = $linha['data_certificado'];
		$hora = $linha['hora_certificado'];
		$numero = $linha['numero'];
		$sequencia = $linha['sequencia'];
		$caminho = $linha['caminho'];
		
		echo "<tr>
        		<td align='center' valign='bottom'>
		<table width='100%' border='0'>
            	    <tr>
                	<td align='center'>
			    <img src='" . $caminho . "' width='100%'>
			</td>
		    </tr>
		    <tr>
                	<td>N&uacute;mero: $numero</td>
		    </tr>
		    <tr>
                	<td>Produtor: $produtor</td>
		    </tr>
		    <tr>
                	<td>CPF: $cpf</td>
		    </tr>
		    <tr>
                	<td>Localidade: $localidade</td>
		    </tr>
		    <tr>
                	<td>Data: $data</td>
		    </tr>
		    <tr>
                	<td>Hora: $hora</td>
		    </tr>
        	</table></td></tr>";
	    }
	    else {
		echo "<tr>
			<td colspan='3'>Certificado inv&aacute;lido</td>
		    </tr>";
	    }
	    
        }
	
    ?>
    <tr><td><br></td></tr>
</table>
</form>

<?php
    require_once ('pmb_rodape.php');
?>