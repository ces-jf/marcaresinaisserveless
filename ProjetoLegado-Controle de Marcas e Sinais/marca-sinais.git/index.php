<?php
/*

 @author Rafael Rodrigues Bastos
 @updated 01/12/2012 by Alex Camargo
 Controle de Marcas e Sinais

 Copyright (C) 2008 PMB - Prefeitura Municipal de Bagé
                          webmaster@bage.rs.gov.br

 Este arquivo é parte do programa Controle de Marcas e Sinais.
 
 Controle de Marcas e Sinais é um software livre; você pode
 redistribui-lo e/ou modifica-lo dentro dos termos da Licença
 Pública Geral GNU como publicada pela Fundação do Software
 Livre (FSF); na versão 2 da Licença, ou (na sua opnião)
 qualquer versão.

 Este programa é distribuido na esperança que possa ser util, mas
 SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUAÇÂO a
 qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença
 Pública Geral GNU para maiores detalhes.
 Você deve ter recebido uma cópia da Licença Pública Geral GNU
 junto	com este programa, se não, escreva para a Fundação do
 Software Livre (FSF) Inc., 51 Franklin St, Fifth Floor, Boston,
 MA  02110-1301 USA.

*/

if ($_GET['erro'] == 1) {
    echo '<script language="Javascript">
            alert("Usuário ou senha inválida!");
          </script>';
}

?>

<form action="pmb_login.php" method="post" name="formulario">
    <table border="0" width="100%" height="100%"><tr><td align="center" valign="center">
    <table border=0>
	<tr>
	    <td colspan="3" align="center">
			<img src="imagens/cabecalho_login.png">
	    </td>
	</tr>
    <tr>
        <td colspan="3" align="center">
			<font size="5" color="black">
				login
			</font>
	    </td>
    </tr>
	<tr>
	    <td colspan="3">
			<br>
	    </td>
	</tr>
    <tr>
        <td align="right">
			usu&aacute;rio
		</td>
        <td>
			<input type="text" name="login">
	    </td>
        <td rowspan="2">
			<a href="pmb_cms_ver_marca.php">consulta</a>
	    </td>
    </tr>
    <tr>
        <td align="right">
			senha
	    </td>
        <td>
			<input type="password" name="senha">
	    </td>
    </tr>
    <tr>
        <td colspan="3" align="center">
			<input type="submit" value="ok">
	    </td>
    </tr>
	<tr>
		<td colspan="3" align="center">
			<img src="imagens/rodape_login.png">
		</td>
	</tr>
</table>
</td></tr></table>
</form>
