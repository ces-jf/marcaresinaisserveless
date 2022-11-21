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
            alert("Senha alterada com sucesso!");
          </script>';
        break;
    case 2: //erro ao salvar
        echo '<script language="Javascript">
            alert("Produtor nao pode ser salvo!");
          </script>';
        break;
    case 3: //excluida com sucesso
        echo '<script language="Javascript">
            alert("Produto excluido com sucesso!");
          </script>';
        break;
    case 4: //erro ao excluir
        echo '<script language="Javascript">
            alert("Produtor nao pode ser excluido!");
          </script>';
        break;
}

echo"
<table border='0' width='650'>
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Acesso R&aacute;pido</th>
    <tr><td></td></tr>
    <tr>
	<td>
	    <a href='pmb_cms_localidade_editar.php'>Cadastrar nova Localidade</a>
	</td>
    </tr>
    <tr>
	<td>
	    <br>
	    <a href='pmb_cms_produtor_editar.php'>Cadastrar novo Produtor</a>
	</td>
    </tr>
    <tr>
	<td>
	    <br>
	    <a href='pmb_cms_marca_editar.php'>Cadastrar nova Marca</a>
	</td>
    </tr>
    <tr>
	<td>
	    <br>
	    <a href='pmb_cms_sinal_editar.php'>Cadastrar novo Sinal</a>
	</td>
    </tr>
</table>";

    require_once ('pmb_rodape.php');
?>