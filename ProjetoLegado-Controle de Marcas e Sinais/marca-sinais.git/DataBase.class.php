<?php
###########################################################################################################
#DataBase.class.php
#Extensão da Classe PDO.
#Com médotos para auxilio de execução de queries.
#Página Orientada a Objetos
#Desenvolvido pela Head Trust
#Criado em: 09/05/2008
#Modificado em: (26/08/2008) - (13/10/2008) - (19/10/2008) - (20/10/2008) - (30/10/2008)- (14/12/2008)
# - (25/12/2008) - (27/02/2009) - (16/03/2009) - (18/03/2009) - (06/05/2009) - (03/07/2009) - (13/05/2010)
# - (07/02/2011)
###########################################################################################################

class DataBase extends PDO {

	private $debug, $debugCode; //Atributos de Debug
	private $showQuery = 0;//Status do ShowQuery
	private $affected = array(), $countedRows = array(), $fetchedResult = array(), $fetchList = array(), $numberResult = 0; //Atributos de resultados de operações
	static $_SHOW_OFF = 0, $_SHOW_ON = 1;
	
	/*
	* Métodos get e set dos atributos para acesso externo
	*/
	
	public function getDbServer(){
		return $this->dbServer;
	}
	
	public function setDbServer($server){
		$this->dbServer = $server;
	}
	
	public function getDbLog(){
		return $this->dbLog;
	}
	
	public function setDbLog($log){
		$this->dbLog = $log;
	}
	
	public function getDbPass(){
		return $this->dbPass;
	}
	
	public function setDbPass($pass){
		$this->dbPass = $pass;
	}
	
	public function getDebug(){
		return $this->debug;
	}
	
	public function setDebug($debug){
		$this->debug = $debug;
	}
	
	/*
	* Fim dos métodos get e set
	*/
	
	//Construtor da classe DataBase :: DataBase()
	public function __construct($dbServer, $dbLog, $dbPass){
		try{
			parent::__construct($dbServer, $dbLog, $dbPass);
		} catch(Exception $e){}
	}
	
	//Retorna um array com os resultados de uma query
	//Parametros: Resultado do método query()
	//mixed fetchArray ([int])
	public function fetchArray($result = ''){
		$numberResult = ($result == '') ? $this->numberResult : $result;
		$key = $this->fetchList[$numberResult];
		$this->fetchList[$numberResult]++;
		if(array_key_exists($key,$this->fetchedResult[$numberResult])){
			return $this->fetchedResult[$numberResult][$key];
		} else {
			$this->fetchList[$numberResult] = 0;
			return false;
		}
	}
	
	//Retorna um array com os resultados de uma query
	//Parametros: Resultado do método query()
	//mixed fetchAll ([int])
	public function fetchAll($result = ''){
		$numberResult = ($result == '') ? $this->numberResult : $result;
		if(array_key_exists($key,$this->fetchedResult[$numberResult])){
			return $this->fetchedResult[$numberResult];
		} else {
			$this->fetchList[$numberResult] = 0;
			return false;
		}
	}
	
	//Retorna a quantidade de linhas afetadas por uma query
	//Parametros: Resultado do método query()
	//mixedaffectedRows ([int])
	public function affectedRows($result = ''){
		$key = ($result == '') ? $this->numberResult : $result;
		if(array_key_exists($key,$this->affected)){
			return $this->affected[$key];
		} else {
			return false;
		}
	}
	
	//Retorna a quantidade de linhas selecionadas por uma query
	//Parametros: Resultado do método query()
	//mixed numRows ([int])
	public function numRows($result=''){
		$key = ($result == '') ? $this->numberResult : $result;
		if(array_key_exists($key,$this->countedRows)){
			return $this->countedRows[$key];
		} else {
			return false;
		}
	}
	
	//Retorna um único resultado de uma requisição query
	//Parametros: Resultado do método query(), Posição do array, Posição do array ou chave do array associativo
	//mixed fetchResult (int, int, mixed)
	public function result($result, $position, $column){
		if(array_key_exists($result,$this->fetchedResult)){
			if(array_key_exists($position,$this->fetchedResult[$result])){
				if(array_key_exists($column,$this->fetchedResult[$result][$position])){
					return $this->fetchedResult[$result][$position][$column];
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function showQuery($status = 1){
		$this->showQuery = $status;
	}	
		//Executa uma query, o parametro bind se for passado irá fazer um bind automático conforme o array
		//Parametros: (Query a ser executada, Array de binds)
		//mixed query (string $query , [ array $bind ] )
	public function query($query, array $bind = array()){	
		if($this->showQuery == self::$_SHOW_ON){
			echo $query . '<br />';
	}
	
	//Escolhe um número aleatóriamente para o sistema descançar.
	$state = parent::prepare($query);
	
	//É feito um descanço ao sistema
	// System::noExhaust();
	
	if($state->execute($bind)){
			$this->analysis($state,$query);
			return $this->numberResult;
		} else {
			$this->debug($state->errorInfo(),$query);
			return false;
		}
	}
	
	//Analisa a query e verifica quais valores devem ser atribuido a quais atributos.
	//Parametros (Objeto PDO, Query executada)
	//void analysis (Object, String)
	private function analysis(PDOStatement $state, $query){
		$numResult = ++$this->numberResult;
		$words = explode(' ', $query);
		$haystack = array('select', 'show', 'describe', 'explain', 'load', 'flush', 'reset', 'status', 'privileges', 'slave', 'user_resources', 'hosts', 'des_key_files');
		if(!in_array(strtolower($words[0]), $haystack)){
			$this->affected[$numResult] = $state->rowCount();
		} else {
			$results = $state->fetchAll();
			$count = count($results);
			$this->fetchList[$numResult] = 0;
			$this->fetchedResult[$numResult] = $results;
			$this->countedRows[$numResult] = $count;
		}
	}
	
	//Pega um array de Queries e executa todas dentro de uma trasação
	//Parametros (Array de queries a serem executadas, Array de valores para bind)
	//bool transaction (Array, [Array])
	public function transaction(array $queries, array $bind = array()){
		parent::beginTransaction();
		$count = count($queries);
		for($i = 0; $i < $count; $i++){
			$binding = (isset($bind[$i])) ? $bind[$i] : array();
			$result = $this->query($queries[$i], $binding);
			$results[] = ($result != false) ? $this->affectedRows($result) : false;
		}
		
		if(array_search(false, $results, 1) === false){
			parent::commit();
			return true;
		} else {
			parent::rollBack();
			return false;
		}
	}
	
	//Gera uma string contendo todos os erros que foram gerados
	//Parametros: (Texto com o erro gerado, A query executada)
	//void debug (String, String)
	private function debug($errors, $query){
		$this->debug .= "\n[" . ++$this->debugCode . "] Problemas com a execução da query\n";
		$this->debug .= "Erro gerado (" . end($errors) . ")\n";
		$this->debug .= "Query executada (" . $query . ")\n";
	}
	
	//Limpa todos os grupos atributos de resultados desta classe.
	//Parametros: void
	//void cleanResults (void)
	public function cleanResults(){
		$this->affected = array();
		$this->countedRows = array();
		$this->fetchedResult = array();
		$this->fetchList = array();
		$this->numberResult = null;
	}
	
	//Limpa um único grupo de atributos de resultados desta classe.
	//Parametros (Valor retornado pelo método query)
	//void cleanSingleResult (int)
	public function cleanSingleResult($result){
		if(array_key_exists($result, $this->affected)){
			$this->affected[$result] = array();
		}
	
		if(array_key_exists($result, $this->countedRows)){
			$this->countedRows[$result] = array();
		}
	
		if(array_key_exists($result, $this->$this->fetchedResult)){
			$this->$this->fetchedResult[$result] = array();
		}
	
		if(array_key_exists($result, $this->$this->fetchList)){
			$this->$this->fetchList[$result] = array();
		}
	}
	
	public function __destruct(){}
}
?>