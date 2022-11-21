<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);

if (!isset ($_SESSION["login"]))
    header("Location: index.php?erro=1");

$localidade = $_POST['localidade'];
$produtor = $_POST['produtor']	;
$numero = $_POST['numero'];

$ch_numero = $_POST['ch_numero'];

if ($ch_numero == "on")
    $ch_numero = "s";
else
    $ch_numero = "n";

$ch_letra = $_POST['ch_letra'];

if ($ch_letra == "on")
    $ch_letra = "s";
else
    $ch_letra = "n";

$ch_figura = $_POST['ch_figura'];

if ($ch_figura == "on")
    $ch_figura = "s";
else
    $ch_figura = "n";



if ((!isset($_POST['id'])) || ($_POST['id'] == ''))
{
    $id = null;

    //NOME TEMPORÁRIO NO SERVIDOR
    $foto_temp = $_FILES['arquivo']['tmp_name'];
    //NOME DO ARQUIVO NA MÁQUINA DO USUÁRIO
    $foto_nome = $_FILES['arquivo']['name'];
    //TAMANHO DO ARQUIVO
    $foto_size = $_FILES['arquivo']['size'];
    //TIPO MIME DO ARQUIVO
    $foto_type = $_FILES['arquivo']['type'];

    $ext = explode(".", $foto_nome);
    $ext[1] = strtolower($ext[1]);

    $foto_nome = date("YmdHis").".".$ext[1];

//    if (($ext[1] != 'jpg') && ($ext[1] != 'png') && ($ext[1] != 'gif') && ($ext[1] != 'bmp'))
    if (($ext[1] != 'jpg') && ($ext[1] != 'JPG'))
	header("Location: pmb_cms_sinal.php?erro=6");
    else
    {
	$arq = "sinal/" . $foto_nome;
        if (file_exists($arq))
            header("Location: pmb_cms_sinal.php?erro=5");
        else
        {
	    if ($foto_size > 1048576)
		header("Location: pmb_cms_sinal.php?erro=7");
	    else {
		if ((!isset($_POST['id'])) || ($_POST['id'] == ''))
            	    if (!copy($foto_temp, "sinal/" . $foto_nome))
                	header("Location: pmb_cms_sinal.php?erro=3");
            	    else
			$caminho = "sinal/" . $foto_nome;
    
		//pg_query($conect, "set datestyle to 'sql, dmy'");
	    
		$hoje = date("d/m/Y");
	    
		$sql = "select max(numero) from cms_sinais";
		//$result = pg_query($conect, $sql);
		$sql = $db->query($sql);
		//$numero = pg_fetch_array($result);
		$numero = $db->fetchArray($sql);		
		$numero = $numero['max'] + 1;
	    
		$sql = "insert into cms_sinais (idlocalidade, idprodutor, numero, caminho, data_cadastro) 
        	values ($localidade, $produtor, $numero, '$caminho', NOW())";
	    
		if ($sql = $db->query($sql))
    		    header("Location: pmb_cms_sinal.php?erro=1");
		else
    		    header("Location: pmb_cms_sinal.php?erro=2");
    	    }
	}
    }    
}
else
{
    $id = $_POST['id'];
    $sql = "update cms_sinais set idlocalidade = '$localidade', idprodutor = '$produtor', numero = '$numero' where idsinal = $id";
    
    if ($sql = $db->query($sql))
    	header("Location: pmb_cms_sinal.php?erro=1");
    else
        header("Location: pmb_cms_sinal.php?erro=2");
}

ob_flush();

?>