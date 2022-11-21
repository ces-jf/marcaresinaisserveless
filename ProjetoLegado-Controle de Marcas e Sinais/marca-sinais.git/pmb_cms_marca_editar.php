<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);

require_once('pmb_cabecalho.php');

if (isset($_GET['id']))
{
    $id = anti_injection($_GET['id']);
    $sql = "select idlocalidade, idprodutor, numero, ch_numero, ch_letra, ch_figura, caminho from cms_marcas where idmarca = ".$id;
   // $result = pg_query($conect, $sql)
    //or die("Nao foi possivel conectar no banco de dados!");
	$sql = $db->query($sql);

   // $linha = pg_fetch_array ( $result );
	$linha = $db->fetchArray($sql);
    $local = $linha['idlocalidade'];
    $produtor = $linha['idprodutor'];
    $numero = $linha['numero'];
    $ch_numero = $linha['ch_numero'];
    $ch_letra = $linha['ch_letra'];
    $ch_figura = $linha['ch_figura'];
    $caminho = $linha['caminho'];
}
else
{
    $id = "";
    $local = "";
    $produtor = "";
    $ch_numero = "";
    $ch_letra = "";
    $ch_figura = "";
    $caminho = "";
}


?>
<form action="pmb_cms_marca_salvar.php" enctype="multipart/form-data"method="post" name="formulario" onSubmit="return validadados()">
<table border="0" width="650">
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Marca</th>
    <tr>
	<td><input type="hidden" name="id" value="<?php echo $id; ?>"></td></tr>
    <?php 
	if (isset($_GET['id']))
	{    
	    $tamanho = getimagesize ($caminho);
	    
	    if ($tamanho[0] > 630)
		$largura = 630;
	    else
		$largura = $tamanho[0];
	    
	    echo "
		<tr>
		    <td align='center'><img src='" . $caminho . "' width='" . $largura . "'>
		    </td>
		</tr>";
	}
	else
	    echo "<tr>
		    <td><input type='file' name='arquivo'></td></tr>";
    ?>
    <tr>
	<td><label>Localidade </label>
	<select name="localidade" size="1">
    	    <?php
		$sql = "select idlocalidade, localidade from cms_localidades order by localidade";
            
		//$result = pg_query($conect, $sql)
		//or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);

    
    		while ( $linha = $db->fetchArray($sql) ) {
    	    	    $idlocalidade = $linha['idlocalidade'];
	    	        $localidade = utf8_decode($linha['localidade']);
    
    	    	    if ($local == $localidade)
			echo "<option value=" . $idlocalidade . " selected>" . $localidade . "</option>";
		    else
			echo "<option value=" . $idlocalidade . ">" . $localidade . "</option>";
		}
	    ?>
	</select></td>
    </tr>
    <tr>
	<td><label>Produtor </label>
	<select name="produtor" size="1">
    	    <?php
		$sql = "select idprodutor, nome from cms_produtores order by nome";
            
		//$result = pg_query($conect, $sql)
		//or die("Nao foi possivel conectar no banco de dados!");
		
			$sql = $db->query($sql);

    
    		while ($linha = $db->fetchArray($sql)) {
    	    	    $idprodutor = $linha['idprodutor'];
	    	    $nome = utf8_decode($linha['nome']);
    
    	    	    if ($produtor == $idprodutor)
			echo "<option value=" . $idprodutor . " selected>" . $nome . "</option>";
		    else
			echo "<option value=" . $idprodutor . ">" . $nome . "</option>";
		}
	    ?>
	</select></td>
    </tr>	
    <?php 
	if (isset($_GET['id']))
	{    
	    echo "<tr>
		    <td>
			<label>N&uacute;mero </label>
			<input type='text' name='numero' disabled value='" . $numero . "' maxlength='70'>
		    </td>
		</tr>";
	}
    ?>
    <tr>
	<td><label>Caracter&iacute;sticas: </label><br>
	<input type="checkbox" name="ch_numero" <?php if ($ch_numero == "s") echo "checked"; ?> >N&uacute;mero<br>
	<input type="checkbox" name="ch_letra" <?php if ($ch_letra == "s") echo "checked"; ?> >Letra<br>
	<input type="checkbox" name="ch_figura" <?php if ($ch_figura == "s") echo "checked"; ?> >Figura</td>
    </tr>
    <tr>
	<td align="center">
	    <input type="submit" value="Salvar">
	    <input type="reset" value="Cancelar" onClick="location.href='pmb_cms_marca.php'">
	</td>
    </tr>
</table>
</form>

<?php
require_once ('pmb_rodape.php');
?>