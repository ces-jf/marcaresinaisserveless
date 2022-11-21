<?php
session_start();
$_SESSION["dados"] = null;
session_destroy();
setcookie("dados", "", time()-60*60*24*365);
header("Location: index.php");
?>
