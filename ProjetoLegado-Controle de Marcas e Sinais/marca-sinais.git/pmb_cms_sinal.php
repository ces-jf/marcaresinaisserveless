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
            alert("Sinal salvo com sucesso!");
          </script>';
        break;
    case 2: //erro ao salvar
        echo '<script language="Javascript">
            alert("Sinal nao pode ser salvo!");
          </script>';
        break;
    case 3: //excluida com sucesso
        echo '<script language="Javascript">
            alert("Sinal excluido com sucesso!");
          </script>';
        break;
    case 4: //erro ao excluir
        echo '<script language="Javascript">
            alert("Sinal nao pode ser excluido!");
          </script>';
        break;
    case 5: //imagem duplicada
        echo '<script language="Javascript">
            alert("Ja existe um sinal com este nome de arquivo!");
          </script>';
        break;
    case 6: //formato invalido
        echo '<script language="Javascript">
            alert("Formato de arquivo invalido!");
          </script>';
        break;
    case 7: //formato invalido
        echo '<script language="Javascript">
            alert("Imagem excedeu o tamanho maximo! (1MB)");
          </script>';
        break;
}

?>

<script>
    function valida_exc() {
	var retorno = confirm('Confirma exclusao do sinal?');
	
	return (retorno);
    }

    function acao(posicao) {
	formulario.action = 'pmb_cms_sinal.php?posicao=' + posicao;	
	
    }

</script>

<form method="post" action="pmb_cms_sinal.php" name="formulario" onSubmit="return valida()">
<table border=0 width=650>
    <tr>
        <td colspan='3' align='center' class='td-titulo1'>Sinais</th>
    <tr><td></td></tr>
    <tr>
        <td colspan="3" align="center">
	    <input type="button" value="Incluir Sinal" onClick="location.href='pmb_cms_sinal_editar.php'">
	    <input type="button" value="Voltar" onClick="location.href='pmb_cms.php'">
	</td>
    </tr>
    <tr>
        <td><br></td></tr>
    <tr>
        <td colspan='3' align='center' class='td-titulo2'>Filtro</th>
    <tr><td></td></tr>
    <tr>
        <td colspan='3'><label>Localidade </label>
	    <select name="localidade">
		<?php
		    require_once('pmb_conecta.php');
		
		    $sql = "select idlocalidade, localidade from cms_localidades order by localidade";
		
		    //$result = pg_query($conect, $sql)
		    //or die ("Não foi possível conectar ao banco de dados!");
			
			$sql = $db->query($sql);
		
		    echo "<option value='' selected>Todas</option>";
		    while ( $linha = $db->fetchArray($sql)) {
			if (isset($_POST['localidade']))
			    if ($linha['idlocalidade'] == $_POST['localidade'])
				echo "<option value=" . $linha['idlocalidade'] . " selected>" . $linha['localidade'] . "</option>";
			    else
				echo "<option value=" . $linha['idlocalidade'] . ">" . $linha['localidade'] . "</option>";
			else
			    echo "<option value=" . $linha['idlocalidade'] . ">" . $linha['localidade'] . "</option>";
		    }
		?>
	    </select>
	</td>
    </tr>
    <tr>
        <td colspan='3'><label>Produtor </label>
	    <select name="produtor">
		<?php
		    require_once('pmb_conecta.php');
		
		    $sql = "select idprodutor, nome from cms_produtores order by nome";
		
		    //$result = pg_query($conect, $sql)
		    //or die ("Não foi possível conectar ao banco de dados!");
			
			$sql = $db->query($sql);
		
		    echo "<option value='' selected>Todos</option>";
		    while ( $linha = $db->fetchArray($sql) ) {
			if (isset($_POST['produtor']))
			    if ($linha['idprodutor'] == $_POST['produtor'])
				echo "<option value=" . $linha['idprodutor'] . " selected>" . $linha['nome'] . "</option>";
			    else
				echo "<option value=" . $linha['idprodutor'] . ">" . $linha['nome'] . "</option>";
			else
			    echo "<option value=" . $linha['idprodutor'] . ">" . $linha['nome'] . "</option>";
		    }
		?>
	    </select>
	</td>
    </tr>
    <tr>
        <td colspan='3'>
	    <input type="submit" value="Buscar">
	</td>
    </tr>
    <tr>
        <td colspan='3' align='center' class='td-titulo2'></th>
    <tr><td></td></tr>
    <tr><td><br></td></tr>

    <?php
        $where = "where";
	
	if (isset($_POST['localidade']))
	    if ($_POST['localidade'] != "")
		$where .= " s.idlocalidade = " . $_POST['localidade'];
	
	if (isset($_POST['produtor'])){
	    if ($_POST['produtor'] != ""){
		if ($where != "where")
		    $where .= " and";
		$where .= " s.idprodutor = " . $_POST['produtor'];
	    }
	}
	
	if ($where == "where")
	    $where = "";
	
        if (!isset($_GET['posicao']))
	    $posicao = 0;
	else
	    $posicao = anti_injection($_GET['posicao']);
	
        require_once ('pmb_conecta.php');
    
        $sql = "select count(s.idsinal) 
	from cms_sinais s
	left join cms_localidades l on l.idlocalidade = s.idlocalidade
	left join cms_produtores p on p.idprodutor = s.idprodutor $where";

	//$result = pg_query($conect, $sql);
	
	$sql = $db->query($sql);
	
	//$linha = pg_fetch_array($result);
	$linha = $db->fetchArray($sql);	
	
	$qtd = $linha['count'];
	
	$anterior = 1;
	$proximo = 1;
	
	if ($posicao == 0) {
	    $anterior = 0;
	}
	
	if ((($posicao+21) >= $qtd) || ($qtd <= 21)) {
	    $proximo = 0;
	}

        $sql = "select s.idsinal, l.localidade, p.nome, s.numero, s.caminho 
	from cms_sinais s
	left join cms_localidades l on l.idlocalidade = s.idlocalidade
	left join cms_produtores p on p.idprodutor = s.idprodutor
	$where order by p.nome, s.numero limit $posicao , 21";
	
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
		
		$sql = $db->query($sql);
    
        while ($linha = $db->fetchArray($sql) ) {
            $idsinal = $linha['idsinal'];
            $localidade = $linha['localidade'];
            $produtor = $linha['nome'];
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
                    <td align='center' width='180'>Produtor: $produtor</td>
		</tr>
		<tr>
                    <td align='center' width='180'>Localidade: $localidade</td>
		</tr>
		<tr>
                    <td colspan='3' align='center'><a href='pmb_cms_sinal_editar.php?id=$idsinal' title='Editar'><img src='imagens/editar.jpg' width='18' height='18' border='0'></a>
                    <a href='pmb_cms_sinal_excluir.php?id=$idsinal' title='Excluir' onClick='return valida_exc()'><img src='imagens/excluir.jpg' width='18' height='18' border='0'></a>
		    <a href='pmb_cms_certificado.php?t=s&id=$idsinal' title='Certificado'><img src='imagens/certificado.jpg' width='18' height='18' border='0'></a></td>
                </tr>
            </table></td>";
	    
	    $coluna += 1;
	    
        }
	
    ?>
    <tr>
        <td><br></td></tr>
    <tr>
        <td><br></td></tr>
    <tr>
	<td colspan="3" align="center">
	    <table>
		<tr>
	            <td align="right">
		        <?php
			    if ($anterior == 1)
			        echo "<input type='submit' value='<<< Anterior' onclick='acao(" . ($posicao-21) . ");'>";
			?>
		    </td>
		    <td>
		    </td>
		    <td align="left">
			<?php
			    if ($proximo == 1)
				echo "<input type='submit' value='Pr&oacute;xima >>>' onclick='acao(" . ($posicao+21) . ");'>";
		        ?>
		    </td>
		</tr>
	    </table>
	</td>
    </tr>
    <tr>
        <td><br></td></tr>
    <tr>
        <td><br></td></tr>
</table>

<?php
    require_once ('pmb_rodape.php');
?>