<?php
session_start();                        
if(file_exists("init.php")){
        require_once "init.php";
} else {
        die("Arquivo de init não encontrado");
}
require_once('pmb_conecta.php');
function limpa($var){
        $var = trim($var);
		//verifica se é número
        if(!is_numeric($var)){		
		$var = 0;		
		}
	   return $var;
}

if(getenv("REQUEST_METHOD") == "POST"){
        $login  = isset($_POST["login"]) ? limpa($_POST["login"]) : "";
        $senha = isset($_POST["senha"]) ? limpa($_POST["senha"]) : "";
		
				 
			$re = $db->query("select * from cms_usuarios where login = '$login' and senha = md5('$senha') and tentativas < '11'");
			$resultado = $db->fetchArray($re);	

                //se o usuário não estiver bloqueado (tentativas maior que 10)
				if($resultado){
                        $dados           = array();
                        $dados["login"]   = $login;
						$_SESSION['login'] = $dados["login"];
                        $dados["senha"] = $senha;                       
                        $_SESSION["dados"] = $dados; 
						
						
						 //zera as tentativas
						 $sql = "update cms_usuarios set tentativas = '0' where login = '$login'";
						 $sql = $db->query($sql);						
						
						
						$data = date("Y-m-d");
						$hora = date("H:i"); 																
									
						//pega o ip
						$ip=getenv("REMOTE_ADDR");
  
						//insere no log de acessos
						$sql = "insert into cms_logacessos (ip, usuario, data, hora) Values ('$ip','$login', '$data', '$hora')";
						$sql = $db->query($sql);			     
					   
                        
                        if(isset($_POST["cookie"])){                    
                                setcookie("dados", serialize($dados), time()+60*60*24*365);                     
                        }
                        header("Location: pmb_cms.php");
                } else {

						 //incrementa as tentativas no caso de erro, para desbloquear basta alterar a coluna para tentativas = '0' no banco
						 $sql = "update cms_usuarios set tentativas = tentativas + 1 where login = '$login'";
						 $sql = $db->query($sql);				
																							
                        header("Location: index.php?erro=1");
                }               
  } 
?>
