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

$id = anti_injection($_GET['id']);

?>

<table border=0 width=650>
    <tr>
        <td colspan='6' align='center' class='td-titulo1'>Produtor</th>
    <tr><td></td></tr>
    <?php
        $sql = "select l.localidade, p.nome, p.cpf, p.ie, p.endereco, p.telefone, p.data_cadastro 
	from cms_produtores p
	left join cms_localidades l on l.idlocalidade = p.idlocalidade
	where idprodutor = " .$id;
	
       // pg_query($conect, "set datestyle to 'sql, dmy'");
	
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);
    
        //$linha = pg_fetch_array ( $result );
		$linha = $db->fetchArray($sql);		
        $localidade = $linha['localidade'];
        $nome = $linha['nome'];
        $cpf = $linha['cpf'];
        $ie = $linha['ie'];
        $endereco = $linha['endereco'];
        $telefone = $linha['telefone'];
        $data_cadastro = $linha['data_cadastro'];

        echo "
            <tr>
                <td><b>Produtor:</b> " . $nome . "</td></tr>
            <tr>
                <td><b>Localidade:</b> " . $localidade . "</td></tr>
            <tr>
                <td><b>CPF:</b> " . $cpf . "</td></tr>
            <tr>
                <td><b>Insci&ccedil;&atilde;o Estadual:</b> " . $ie . "</td></tr>
            <tr>
                <td><b>Endere&ccedil;o:</b> " . $endereco . "</td></tr>
            <tr>
                <td><b>Telefone:</b> " . $telefone . "</td></tr>
            <tr>
                <td><b>Data de cadastro:</b> ".date("d/m/Y",strtotime($data_cadastro))."</td></tr>
	    <tr><td><br></td></tr>";

        $sql = "select m.idmarca, l.localidade, m.numero, m.caminho 
	from cms_marcas m
	left join cms_localidades l on l.idlocalidade = m.idlocalidade
	where m.idprodutor =".$id." order by m.numero";
	
        //$result = pg_query($conect, $sql)
       // or die("Nao foi possivel conectar no banco de dados!");
	   
	   $sql = $db->query($sql);
    
        echo "<tr>
    		<td colspan='6' align='center' class='td-titulo1'>Marcas do Produtor</th>
	    <tr><td></td></tr>";
	
        while ( $linha = $db->fetchArray($sql) ) {
            $idmarca = $linha['idmarca'];
            $localidade = $linha['localidade'];
            $numero = $linha['numero'];
	    $caminho = $linha['caminho'];
    
    	    if ($coluna > 2)
	    {
		echo "</tr><tr>";
		$coluna = 0;
	    }
	
            echo "<td><table border='0'>
                <tr>
                    <td><a href='pmb_cms_marca_detalhe.php?idmarca=$idmarca'><img src='" . $caminho . "' width='180'></a></td>
		</tr>
		<tr>
                    <td align='center' width='180'>$numero</td>
		</tr>
		<tr>
                    <td width='180'><b>Localidade:</b> $localidade</td>
		</tr>
            </table></td>";
	    
	    $coluna += 1;
	    
        }

	$coluna = 0;
        $sql = "select s.idsinal, l.localidade, s.numero, s.caminho 
	from cms_sinais s
	left join cms_localidades l on l.idlocalidade = s.idlocalidade
	where s.idprodutor =".$id." order by s.numero";
	
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);
    
        echo "<tr>
    		<td colspan='6' align='center' class='td-titulo1'>Sinais do Produtor</th>
	    <tr><td></td></tr>";
	
        while ( $linha = $db->fetchArray($sql) ) {
            $idsinal = $linha['idsinal'];
            $localidade = $linha['localidade'];
            $numero = $linha['numero'];
	    $caminho = $linha['caminho'];
    
    	    if ($coluna > 2)
	    {
		echo "</tr><tr>";
		$coluna = 0;
	    }
	
            echo "<td><table border='0'>
                <tr>
                    <td><a href='pmb_cms_sinal_detalhe.php?idsinal=$idsinal'><img src='" . $caminho . "' width='180'></a></td>
		</tr>
		<tr>
                    <td align='center' width='180'>$numero</td>
		</tr>
		<tr>
                    <td width='180'><b>Localidade:</b> $localidade</td>
		</tr>
            </table></td>";
	    
	    $coluna += 1;
	    
        }
    ?>
    <tr>
        <td align="center">
	    <input type="reset" value="Voltar" onClick="location.href='pmb_cms_produtor.php'">
	</td>
    </tr>
    <tr><td><br></td></tr>
</table>

<?php
    require_once ('pmb_rodape.php');
?>