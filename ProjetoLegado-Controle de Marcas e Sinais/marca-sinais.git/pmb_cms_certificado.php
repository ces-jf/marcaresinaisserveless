<?php
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
require_once "seguranca.php";

$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);
if (!isset($_GET['id']))
    header("Location: index.php");

$id = anti_injection($_GET['id']);
$tipo = anti_injection_s($_GET['t']);

ob_start();

if ($tipo == "m")
    $sql = "select l.localidade, p.nome, p.cpf, m.numero, m.caminho
	from cms_marcas m
        left join cms_localidades l on l.idlocalidade = m.idlocalidade
        left join cms_produtores p on p.idprodutor = m.idprodutor
	where m.idmarca = ".$id;
else
    $sql = "select l.localidade, p.nome, p.cpf, s.numero, s.caminho
	from cms_sinais s
        left join cms_localidades l on l.idlocalidade = s.idlocalidade
        left join cms_produtores p on p.idprodutor = s.idprodutor
	where s.idsinal = ".$id;


//$result = pg_query($conect, $sql);
//$dados = pg_fetch_array($result);

$sql = $db->query($sql);
$dados = $db->fetchArray($sql);

$localidade = $dados['localidade'];
$nome = $dados['nome'];
$cpf = $dados['cpf'];
$numero = $dados['numero'];
$caminho = $dados['caminho'];
$dia = date("d");
$mes = date("m");
$ano = date("Y");
$hora = date("H");
$minuto = date("i");
$segundo = date("s");

$mesext['01'] = "janeiro";
$mesext['02'] = "fevereiro";
$mesext['03'] = "março";
$mesext['04'] = "abril";
$mesext['05'] = "maio";
$mesext['06'] = "junho";
$mesext['07'] = "julho";
$mesext['08'] = "agosto";
$mesext['09'] = "setembro";
$mesext['10'] = "outubro";
$mesext['11'] = "novembro";
$mesext['12'] = "dezembro";

$percent = 0.95;

//header('Content-type: image/jpeg');

list($width, $height) = getimagesize($caminho);

if ( ($width > 400) || ($height > 400)) {
	$true = 1;
	while ($true == 1) {
	        if ( (($width * $percent) <= 400) && (($height * $percent) <= 400)) {
	                $newwidth = $width * $percent;
	                $newheight = $height * $percent;
			$true = 2;

	        }
	        
	        $percent -= 0.05;
	}
}
else {
    $newwidth = $width;
    $newheight = $height;
}

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefromjpeg($caminho);


// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
if ($tipo == "m")
    imagejpeg($thumb, 'marca/vinculo.jpg');
else
    imagejpeg($thumb, 'sinal/vinculo.jpg');


$sql = "select max(sequencia) from cms_certificados where data_certificado = '$ano-$mes-$dia'";

//$result = pg_query($conect, $sql);
//$linha = pg_fetch_array($result);

$sql = $db->query($sql);
$linha = $db->fetchArray($sql);

$sequencia = $linha['sequencia'] + 1;

$local = str_replace("'", "\'", $localidade);
$produtor = str_replace("'", "\'", $nome);

$sql = "insert into cms_certificados (localidade, produtor, cpf, tipo, data_certificado, hora_certificado, sequencia, numero, caminho)
    values ('$local', '$produtor', '$cpf', '$tipo', '$ano-$mes-$dia', '$hora:$minuto:$segundo', $sequencia, $numero, '$caminho')";

//pg_query($conect, $sql);

$sql = $db->query($sql);


//gera o pdf

ob_start();  //inicia o buffer

$certificado = $ano.$mes.$dia.$hora.$minuto.$segundo.$sequencia;

echo"

<style type='text/css'>
	.certificado{
    border: 2px solid #000000;
	width: 100%;
	padding: 0px;
	marging: 0px;
	font-family: arial;
	font-size: 20pt;
	color: #000;
	text-align:left;
	}
	.certificado img{
    border: 2px solid #000000;
    }	
	.descricao{
	font-weight: bold;
	}
</style>


<table class='certificado' >
<tr> 
 <td><img src='imagens/brasao.png' border='0' /></td>
 <td>PREFEITURA MUNICIPAL DE XXXXXX <br />
Secretaria Municipal de XXXXXX <br />
Coordenadoria de XXXXXX</td>
</tr>
<tr >
<td style='border-bottom: 2px solid #000000;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style='border-bottom: 2px solid #000000;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr> 
 <td style='border-right: 2px solid #000000;'><img src='$caminho' width='300' height='300' /></td>
 <td style='font-size: 17pt;'>Registro: <small class='descricao'> $numero </small><br />
	 Registrado para: <small class='descricao'>$nome</small><br />
     Localidade: <small class='descricao'> $localidade</small> <br />
	 Cpf: <small class='descricao'> $cpf </small> <br />
	 Certificado nº: <small class='descricao'> $certificado </small> <br /><br />
	 Bagé, $dia de $mesext[$mes] de $ano. <br /><br />
	 ____________________________________ <br />
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 Responsável
 </td>
</tr>
</table>
"; 



$html = ob_get_clean();
// pega o conteudo do buffer, insere na variavel e limpa a memória

$html = utf8_encode($html);
// converte o conteudo para uft-8

include("MPDF53/mpdf.php");
// inclui a classe

$mpdf = new mPDF();
// cria o objeto

$mpdf->allow_charset_conversion=true;
// permite a conversao (opcional)
$mpdf->charset_in='UTF-8';
// converte todo o PDF para utf-8

$mpdf->setHeader();	// Clear headers before adding page
$mpdf->AddPage('L','','','','',15,15,25,25,8,2);

$mpdf->WriteHTML($html);
// escreve definitivamente o conteudo no PDF

// define um nome para o arquivo PDF
$arquivo = 'certificado_'.$certificado.'.pdf';
 
// gera o relat&oacute;rio
$mpdf->Output($arquivo,'D');

exit();
// finaliza o codigo

?>


