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

if ($_GET['id'] == "")
    $id = null;
else
    $id = anti_injection($_GET['id']);


$sql = "select caminho from cms_sinais where idsinal = $id";

//$result = pg_query($conect, $sql)
//or header("Location: pmb_cms_sinal.php?erro=4");

$sql = $db->query($sql);

if($sql){
//$dados = pg_fetch_array($result);

$dados = $db->fetchArray($sql);

$caminho = $dados['caminho'];

unlink($caminho);

$sql = "delete from cms_sinais where idsinal = $id";

if ($sql = $db->query($sql))
    header("Location: pmb_cms_sinal.php?erro=3");
else
    header("Location: pmb_cms_sinal.php?erro=4");
}
else{
header("Location: pmb_cms_sinal.php?erro=4");
}



?>