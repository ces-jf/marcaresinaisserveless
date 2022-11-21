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

switch ($_GET['erro']) {
    case 1: //salva com sucesso
        echo '<script language="Javascript">
            alert("Localidade salva com sucesso!");
          </script>';
        break;
    case 2: //erro ao salvar
        echo '<script language="Javascript">
            alert("Localidade nao pode ser salva!");
          </script>';
        break;
    case 3: //excluida com sucesso
        echo '<script language="Javascript">
            alert("Localidade excluida com sucesso!");
          </script>';
        break;
    case 4: //erro ao excluir
        echo '<script language="Javascript">
            alert("Localidade nao pode ser excluida!");
          </script>';
        break;
    case 5: //erro ao excluir
        echo '<script language="Javascript">
            alert("Localidade ja cadastrada!");
          </script>';
        break;
}

if (isset($_POST['where']))
    $where = "where lower(localidade) similar to '%" . strtolower($_POST['where']) . "%'";
else
    $where = "";
    
?>

<script>
    function valida_exc() {
	var retorno = confirm('Confirma exclusao da localidade?');
	
	return (retorno);
    }
</script>

<table border=0 width=650>
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Localidades</th>
    <tr><td></td></tr>
    <tr>
        <td colspan="3" align="center">
	    <input type="button" value="Incluir Localidade" onClick="location.href='pmb_cms_localidade_editar.php'">
	    <input type="button" value="Voltar" onClick="location.href='pmb_cms.php'">
	</td>
    </tr>
    <tr>
        <td><br></td></tr>

    <?php
        require_once ('pmb_conecta.php');
    
        $sql = "select idlocalidade, localidade from cms_localidades $where order by localidade";
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);

    
        $cores[0] = "#FFFFFF";
	$cores[1] = "#F5F6ED";

        //while ( $linha = pg_fetch_array ( $result ) ) {
		while ( $linha = $db->fetchArray($result) ) {
            $idlocalidade = $linha['idlocalidade'];
            $localidade = $linha['localidade'];
    
            echo "<tr bgcolor='" . $cores[$cor] . "'>
                    <td>
			$localidade
		    </td>
                    <td align='center'>
			<a href='pmb_cms_localidade_editar.php?id=$idlocalidade' title='Editar'><img src='imagens/editar.jpg' width='18' height='18' border='0'></a>
                	<a href='pmb_cms_localidade_excluir.php?id=$idlocalidade' title='Excluir' onClick='return valida_exc()'><img src='imagens/excluir.jpg' width='18' height='18' border='0'></a>
		    </td>
                </tr>";
	    
	    if ($cor == 0)
		$cor = 1;
	    else
		$cor = 0;
        }
	
    ?>
    <tr>
        <td><br></td></tr>
    <tr>
        <td><br></td></tr>
</table>

<?php
    require_once ('pmb_rodape.php');
?>