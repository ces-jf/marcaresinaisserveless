<?php
session_start();
//bloqueia o acesso direto via navegador
if (basename($_SERVER["PHP_SELF"]) == "pmb_conecta.php") {
        header("Location: pmb_logoff.php");
		exit();
} 
require_once('DataBase.class.php');

$dbServer = 'mysql:dbname=cms_v2;host=127.0.0.1;charset=utf8';//Acesso ao servidor
$dbLog = 'root';//Nome de usuário para o banco de dados
$dbPass = '';//Senha para acesso ao banco de dados.
$db = new DataBase($dbServer, $dbLog, $dbPass);

date_default_timezone_set('America/Sao_Paulo');

//oculta os erros php
//error_reporting(0);
//ini_set("display_errors", 0 );

//mostra os erros php
error_reporting(E_ALL^ E_NOTICE);
ini_set("display_errors", 1 );

//função anti-sql injection
function anti_injection($sql)
{

// remove palavras que contenham sintaxe sql
$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
$sql = (int) $sql; //convertendo o parâmetro para um tipo numérico (coloquei porque os campos de consulta do site utiliza consulta somente pelo id)
$sql = trim($sql);//limpa espaços vazio
$sql = strip_tags($sql);//tira tags html e php
#$sql = pg_escape_string($sql); //Adiciona apsas simples a uma string
//$sql = addslashes($sql);//Adiciona barras invertidas a uma string (não funciona no postgres)

return $sql;

}

//função anti-sql injection para campos string (textos)
function anti_injection_s($sql)
{

// remove palavras que contenham sintaxe sql
$sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
//$sql = (int) $sql; //convertendo o parâmetro para um tipo numérico (coloquei porque os campos de consulta do site utiliza consulta somente pelo id)
$sql = trim($sql);//limpa espaços vazio
$sql = strip_tags($sql);//tira tags html e php
$sql = addslashes($sql); //Adiciona apsas simples a uma string
//$sql = addslashes($sql);//Adiciona barras invertidas a uma string (não funciona no postgres)

return $sql;

}

//oculta os erros php
error_reporting(0);
ini_set("display_errors", 0 );

//mostra os erros php
//error_reporting(E_ALL^ E_NOTICE);
//ini_set("display_errors", 1 );


?>
