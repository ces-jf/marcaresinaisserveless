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
    case 5: //erro ao salvar
        echo '<script language="Javascript">
            alert("A senha deve possuir somente numeros!");
          </script>';
		break;
    case 6: //erro ao salvar
        echo '<script language="Javascript">
            alert("Erro ao alterar a senha!");
          </script>';
		break;		
}

?>

<script>

    function validadados()
    {
    
        if (formulario.novasenha.value != formulario.confirmasenha.value)
        {
            alert("Confirme a senha!");
            return (false);
        }
				
	return (true);			
    
    }

</script>

<form action="pmb_cms_senha_alterar.php" method="post" name="formulario" onSubmit="return validadados()">
    <table border="0" width="650">
        <tr>
	    <td colspan='6' align='center' class='td-titulo1'>Alterar Senha</th>
        <tr><td><br></td></tr>
	<tr>
	    <td><input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
	    <label>Senha atual </label><input type="password" name="senhaatual" maxlength="10"></td></tr>
        <tr><td><br></td></tr>
	<tr>
	    <td><label>Nova senha </label><input type="password" name="novasenha" maxlength="10"><small>(somente números)</small></td></tr>
        <tr><td><br></td></tr>
	<tr>
	    <td><label>Confirmar nova senha </label><input type="password" name="confirmasenha" maxlength="10"><small>(somente números)</small></td></tr>
        <tr><td><br></td></tr>
	<tr>
    	    <td align='center'><input type="submit" value="Salvar"><input type="reset" value="Cancelar" onClick="location.href='pmb_cms.php'"</td></tr>
    </table>
</form>


<?php
require_once ('pmb_rodape.php');
?>