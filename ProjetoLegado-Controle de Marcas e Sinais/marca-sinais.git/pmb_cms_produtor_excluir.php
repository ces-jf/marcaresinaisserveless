<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);


if ($_GET['id'] == "")
    $id = null;
else
    $id = anti_injection($_GET['id']);


$sql = "select nome from cms_produtores where idprodutor = $id";

//$result = pg_query($conect, $sql)
//or header("Location: pmb_cms_produtor.php?erro=4");

$sql = $db->query($sql);

if($sql){
$sql = "delete from cms_produtores where idprodutor = $id";

if ($sql = $db->query($sql))
    header("Location: pmb_cms_produtor.php?erro=3");
else
    header("Location: pmb_cms_produtor.php?erro=4");
}
else
{
header("Location: pmb_cms_produtor.php?erro=4");
}



?>