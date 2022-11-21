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
            alert("Produtor salvo com sucesso!");
          </script>';
        break;
    case 2: //erro ao salvar
        echo '<script language="Javascript">
            alert("Produtor nao pode ser salvo!");
          </script>';
        break;
    case 3: //excluida com sucesso
        echo '<script language="Javascript">
            alert("Produtor excluido com sucesso!");
          </script>';
        break;
    case 4: //erro ao excluir
        echo '<script language="Javascript">
            alert("Produtor nao pode ser excluido!");
          </script>';
        break;
}

?>

<script>
    function valida_exc() {
	var retorno = confirm('Confirma exclusao do produtor?');
	
	return (retorno);
    }
</script>

<form method="post" action="pmb_cms_produtor.php" name="formulario">
<table border=0 width=650>
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Produtores</th>
    <tr><td></td></tr>
    <tr>
        <td colspan="3" align="center">
	    <input type="button" value="Incluir Produtor" onClick="location.href='pmb_cms_produtor_editar.php'">
	    <input type="button" value="Voltar" onClick="location.href='pmb_cms.php'">
	</td>
    </tr>
    <tr>
        <td><br></td></tr>
    <tr>
        <td colspan='6' align='center' class='td-titulo2'>Filtro</th>
    <tr><td></td></tr>
    <tr>
        <td><label>Nome </label><input type="text" name="produtor" value="<?php if (isset($_POST['produtor'])) echo $_POST['produtor']; else echo ""; ?>">
	</td>
    </tr>
    <tr>
        <td>
	    <input type="submit" value="Buscar">
	</td>
    </tr>
    <tr>
        <td colspan='6' align='center' class='td-titulo2'></th>
    <tr><td></td></tr>
    <tr><td><br></td></tr>

    <?php
	if (isset($_POST['produtor']))
	    if ($_POST['produtor'] != "") {
		$produtor = strtolower($_POST['produtor']);
		$where = "where nome like '%".addslashes($produtor)."%'";
	    }

        require_once ('pmb_conecta.php');
    
        $sql = "select idprodutor, nome from cms_produtores $where order by nome";
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
				
		$sql = $db->query($sql); 

        $cores[0] = "#FFFFFF";
		$cores[1] = "#F5F6ED";

        while ( $linha = $db->fetchArray($sql) ) {
            $idprodutor = $linha['idprodutor'];
            $nome = $linha['nome'];
    
            echo "<tr bgcolor='" . $cores[$cor] . "'>
                    <td>
			<a href='pmb_cms_produtor_detalhe.php?id=$idprodutor'>$nome</a>
		    </td>
                    <td align='center'>
			<a href='pmb_cms_produtor_editar.php?id=$idprodutor' title='Editar'><img src='imagens/editar.jpg' width='18' height='18' border='0'></a>
                	<a href='pmb_cms_produtor_excluir.php?id=$idprodutor' title='Excluir' onClick='return valida_exc()'><img src='imagens/excluir.jpg' width='18' height='18' border='0'></a>
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
</form>

<?php
    require_once ('pmb_rodape.php');
?>