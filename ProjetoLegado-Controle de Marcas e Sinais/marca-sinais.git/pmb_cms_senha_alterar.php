<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);

if (!isset($_POST['senha']))
    header("Location: index.php?erro=1");
$login = $_POST['login'];
$senha = $_POST['senhaatual'];
$novasenha = $_POST['novasenha'];


if(ereg('[^0-9]',$novasenha)){
        header("Location: pmb_cms_senha.php?erro=5");
		exit;
}

$sql = "select login from cms_usuarios where login = '$login' and senha = md5('$senha') limit 1";

//$result = pg_query($conect, $sql);

$sql = $db->query($sql);

//$linha = pg_fetch_array($result);

$linha = $db->fetchArray($sql);

if ($linha){

    $sql = "update cms_usuarios set senha = md5('$novasenha') where login = '$login'";


    if ($sql = $db->query($sql))
	header("Location: pmb_cms_senha.php?erro=1");
    else
	header("Location: pmb_cms_senha.php?erro=6");
}
else
    header("Location: pmb_cms_senha.php?erro=6");


?>
