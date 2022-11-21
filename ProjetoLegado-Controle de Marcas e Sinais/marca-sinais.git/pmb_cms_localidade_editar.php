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
    $sql = "select localidade from cms_localidades where idlocalidade = ".$id;
    //$result = pg_query($conect, $sql)
    //or die("Nao foi possivel conectar no banco de dados!");
	$sql = $db->query($sql);


    //while ( $linha = pg_fetch_array ( $result ) ) {
	while ( $linha = $db->fetchArray($sql) ) {
        $localidade = $linha['localidade'];
    }
}
else
{
    $id = "";
    $localidade = "";
}


?>

<SCRIPT>
    function validadados()
    {
        if (formulario.localidade.value == "")
        {
            alert("Informe a localidade!")
            return (false)
        }

        formulario.submit();

    }
</SCRIPT>

<form action="pmb_cms_localidade_salvar.php" method="post" name="formulario" onSubmit="return validadados()">
<table border="0" width="650">
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Localidade</th>
    <tr>
	<td><input type="hidden" name="id" value="<?php echo $id; ?>"></td>
    </tr>
    <tr>
	<td><label>Localidade </label><input type="text" name="localidade" value="<?php echo $localidade; ?>"></td>
    </tr>
    <tr>
        <td><input type="submit" value="Salvar">
	<input type="reset" value="Cancelar" onClick="location.href='pmb_cms_localidade.php'"></td>
    </tr>
</table>
</form>

<?php
require_once ('pmb_rodape.php');
?>