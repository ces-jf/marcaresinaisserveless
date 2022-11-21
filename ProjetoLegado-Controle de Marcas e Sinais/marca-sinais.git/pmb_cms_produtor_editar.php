<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);

require_once ('pmb_cabecalho.php');

if (isset($_GET['id']))
{
    $id = anti_injection($_GET['id']);
    $sql = "select idlocalidade, nome, cpf, ie, endereco, telefone from cms_produtores where idprodutor = " . $id;
    //$result = pg_query($conect, $sql)
    //or die("Nao foi possivel conectar no banco de dados!");
	
	$sql = $db->query($sql);

    //$linha = pg_fetch_array ( $result );
	$linha = $db->fetchArray($sql);	
    $local = $linha['idlocalidade'];
    $nome = $linha['nome'];
    $cpf = $linha['cpf'];
    $ie = $linha['ie'];
    $endereco = $linha['endereco'];
    $telefone = $linha['telefone'];
}
else
{
    $id = "";
    $local = "";
    $nome = "";
    $cpf = "";
    $ie = "";
    $endereco = "";
    $telefone = "";
}


?>

<SCRIPT>
    function validadados()
    {
        if (formulario.idlocalidade.value == "")
        {
            alert("Informe a localidade!")
            return (false)
        }

        if (formulario.nome.value == "")
        {
            alert("Informe o nome!")
            return (false)
        }

        if (formulario.cpf.value == "")
        {
            alert("Informe o CPF!")
            return (false)
        }

        if (formulario.ie.value == "")
        {
            alert("Informe a Inscricao Estadual!")
            return (false)
        }

        formulario.submit();

    }
</SCRIPT>
<form action="pmb_cms_produtor_salvar.php" method="post" name="formulario" onSubmit="return validadados()">
<table border="0" width="650">
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Produtor</th>
    <tr><td><input type="hidden" name="id" value="<?php echo $id; ?>"></td></tr>
    <tr>
	<td><label>Localidade </label>
        <select name="localidade" size="1">
    	    <?php
		$sql = "select idlocalidade, localidade from cms_localidades order by localidade";
            
		//$result = pg_query($conect, $sql)
		//or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);
    
    		while ($linha = $db->fetchArray($sql) ) {
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
	<td><label>Nome </label><input type="text" name="nome" value="<?php echo $nome; ?>" maxlength="70"></td>
    </tr>
    <tr>
	<td><label>CPF </label><input type="text" name="cpf" value="<?php echo $cpf; ?>" maxlength="11"></td>
    </tr>
    <tr>
	<td><label>Inscri&ccedil;&atilde;o Estadual </label><input type="text" name="ie" value="<?php echo $ie; ?>" maxlength="25"></td>
    </tr>
    <tr>
	<td><label>Endere&ccedil;o </label><input type="text" name="endereco" value="<?php echo $endereco; ?>" maxlength="60"></td>
    </tr>
    <tr>
	<td><label>Telefone </label><input type="text" name="telefone" value="<?php echo $telefone; ?>" maxlength="15"></td>
    </tr>
    <tr>
	<td><input type="submit" value="Salvar">
	    <input type="reset" value="Cancelar" onClick="location.href='pmb_cms_produtor.php'"></td>
    </tr>
</table>
</form>

<?php
require_once ('pmb_rodape.php');
?>