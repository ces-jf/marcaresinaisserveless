<?php
require_once ('pmb_conecta.php');
require_once ('pmb_cabecalho_ver.php');
?>
<script>
    function acao(posicao) {
	formulario.action = 'pmb_cms_ver_marca.php?posicao=' + posicao;	
	
    }

</script>

<form method="post" action="pmb_cms_ver_marca.php" name="formulario">
<table border=0 width=650>
    <tr>
        <td colspan='3' align='center' class='td-titulo1' width='650'>Marcas</td>
    </tr>
    <tr><td></td></tr>
    <tr>
        <td align='center' colspan='3' class='td-titulo2'>Filtro</th>
    <tr><td></td></tr>
    <tr>
        <td colspan='3'><label>Localidade </label>
	    <select name="localidade">
		<?php 
		    //require_once('pmb_conecta.php');
		
		    $sql = "select idlocalidade, localidade from cms_localidades order by localidade";
		
		    //$result = pg_query($conect, $sql)
		    //or die ("Nao foi possivel conectar ao banco de dados!");
			
			$sql = $db->query($sql);
		
		    echo "<option value='' selected>Todas</option>";
		    while ( $linha = $db->fetchArray($sql) ) {
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
		    //require_once('pmb_conecta.php');
		
		    $sql = "select idprodutor, nome from cms_produtores order by nome";
		
		    //$result = pg_query($conect, $sql)
		    //or die ("Nao foi possivel conectar ao banco de dados!");
			
			$sql = $db->query($sql);
		
		    echo "<option value='' selected>Todos</option>";
		    while ($linha = $db->fetchArray($sql)) {
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
	<td colspan='3'><table width='100%'><tr>
        <td><input type="checkbox" name="ch_numero" <?php 
	    if (isset($_POST['ch_numero'])){
		if ($_POST['ch_numero'] == "on") 
		    echo "checked";
		else
		    echo "";
	    }
	    else
		echo "";
	    ?> >N&uacute;mero</td>
        <td><input type="checkbox" name="ch_letra" <?php 
	    if (isset($_POST['ch_letra'])){
		if ($_POST['ch_letra'] == "on") 
		    echo "checked";
		else
		    echo "";
	    }
	    else
		echo "";
	    ?> >Letra</td>
        <td><input type="checkbox" name="ch_figura" <?php 
	    if (isset($_POST['ch_figura'])){
		if ($_POST['ch_figura'] == "on") 
		    echo "checked";
		else
		    echo "";
	    }
	    else
		echo "";
	    ?> >Figura	</td></tr></table>
    </tr>
    <tr>
        <td>
	    <input type="submit" value="Buscar">
	</td>
    </tr>
    <tr>
        <td align='center' colspan='3' class='td-titulo2'></td>
    <tr>
    <tr><td></td></tr>
    <tr><td><br></td></tr>

    <?php
        $where = "where";
	
	if (isset($_POST['localidade']))
	    if ($_POST['localidade'] != "")
		$where .= " m.idlocalidade = " . $_POST['localidade'];
	
	if (isset($_POST['produtor'])){
	    if ($_POST['produtor'] != ""){
		if ($where != "where")
		    $where .= " and";
		$where .= " m.idprodutor = " . $_POST['produtor'];
	    }
	}
	
	if (isset($_POST['ch_numero'])){
	    if ($_POST['ch_numero'] == "on")
		$ch_numero = "s";
	    else
		$ch_numero = "n";
	    $wherech .= " m.ch_numero = '$ch_numero'";
	}
	if (isset($_POST['ch_letra'])){
	    if ($_POST['ch_letra'] == "on")
		$ch_letra = "s";
	    else
		$ch_letra = "n";
    	    if ($wherech != "")
		$wherech .= " or m.ch_letra = '$ch_letra'";
	    else
		$wherech .= " m.ch_letra = '$ch_letra'";
	}
	if (isset($_POST['ch_figura'])){
	    if ($_POST['ch_figura'] == "on")
		$ch_figura = "s";
	    else
		$ch_figura = "n";
	    if ($wherech != "")
		$wherech .= " or m.ch_figura = '$ch_figura'";
	    else
		$wherech .= " m.ch_figura = '$ch_figura'";
	}
	
        if ($wherech != ""){
	    if ($where != "where")
        	$where .= " and (" . $wherech . ")";
    	    else 
		$where .= $wherech;
	}
	
	if ($where == "where")
	    $where = "";
	
        if (!isset($_GET['posicao']))
	    $posicao = 0;
	else
	    $posicao = anti_injection($_GET['posicao']);
	
	//require_once ('pmb_conecta.php');
    
        $sql = "select count(m.idmarca) 
	from cms_marcas m
	left join cms_localidades l on l.idlocalidade = m.idlocalidade
	left join cms_produtores p on p.idprodutor = m.idprodutor $where";

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

	$sql = "select m.idmarca, l.localidade, p.nome, m.numero, m.caminho 
	from cms_marcas m
	left join cms_localidades l on l.idlocalidade = m.idlocalidade
	left join cms_produtores p on p.idprodutor = m.idprodutor
	$where order by p.nome, m.numero limit 21 offset $posicao";
	
        //$result = pg_query($conect, $sql)
        //or die("Nao foi possivel conectar no banco de dados!");
	
		$sql = $db->query($sql);
	
    
        while ( $linha = $db->fetchArray($sql) ) {
            $idmarca = $linha['idmarca'];
            $localidade = $linha['localidade'];
            $produtor = $linha['nome'];
            $numero = $linha['numero'];
	    $caminho = $linha['caminho'];
    
    	    if ($coluna > 2)
	    {
		echo "</tr><tr>";
		$coluna = 0;
	    }
	
            echo "<td align='center' valign='bottom' width='33,33%'><table width='100%' border='0'>
                <tr>
                    <td align='center'>
			<a href='pmb_cms_ver_marca_detalhe.php?idmarca=$idmarca'><img src='" . $caminho . "' width='200'></a>
		    </td>
		</tr>
		<tr>
                    <td align='center'>$numero</td>
		</tr>
		<tr>
                    <td align='center'>Produtor: $produtor</td>
		</tr>
		<tr>
                    <td align='center'>Localidade: $localidade</td>
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
</form>

<?php
    require_once ('pmb_rodape.php');
?>
