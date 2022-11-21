<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);

?>

<html>
<head>
    <title>.: Controle de Marcas e Sinais :.</title>
    <link rel="STYLESHEET" type="text/css" href="css/pmb_estilo.css">
</head>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">

<table width="787" cellspacing="0" cellpadding="0" border="0" align="center">
    <tr>
        <td colspan='2' align='center'>
            <img src="imagens/cabecalho.png">
        </td>
    </tr>
    <tr>
        <td width="140" align="left" valign="top" bgcolor="#F5F6ED">
            <table width="140" cellspacing="0" cellpadding="0" border="0">
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_cms.php" class="menu">In&iacute;cio</a></td>
                </tr>
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_cms_marca.php" class="menu">Marcas</a></td>
                </tr>
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_cms_sinal.php" class="menu">Sinais</a></td>
                </tr>
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_cms_produtor.php" class="menu">Produtores</a></td>
                </tr>
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_cms_localidade.php" class="menu">Localidades</a></td>
                </tr>
                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>

				<tr>
                    <td class="menu"><a href="pmb_cms_senha.php" class="menu">Alterar Senha</a></td>
                </tr>

                <tr><td><img src="imagens/pmb_nada.gif" width="100%"></td></tr>
                <tr>
                    <td class="menu"><a href="pmb_logoff.php" class="menu">Sair</a></td>
                </tr>
            </table>
        </td>
        <td valign="top">