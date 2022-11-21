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

?>

<form name="formulario" method="post" action="pmb_cms_localidade.php">
    <table border=0 width=650>
        <tr>
            <td align='center' class='td-titulo1'>Pesquisa</th>
        <tr><td></td></tr>
        <tr>
            <td><input type="text" name="where"> <input type="submit" name="pesquisar" value="Pesquisar"></td>
        </tr>
        <tr>
            <td><br><input type="reset" value="Voltar" onClick="location.href='pmb_cms_localidade.php'"></td></tr>
        <tr>
            <td><br></td></tr>
    </table>
</form>

<?php
    require_once ('pmb_rodape.php');
?>