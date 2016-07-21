<?php
/*
 * PDO::query() 主要针对查询，返回PDOStatement，然后通过返回的PDOStatement对象进行如下操作：
 * 				PDOStatement::fetchColumn()、PDOStatement::fetch()、PDOStatement::fetchALL()。PDOStatement::rowCount
 * PDO::prepare()主要是预处理操作，返回PDOStatement，需要通过PDOStatement::execute()来执行预处理里面的SQL语句，这个方法可以绑定参数，功能比较强大
 * PDO::exec() 主要是针对没有结果集合返回的操作，比如INSERT、UPDATE、DELETE等
 */
class DBUtil{
	private $errorInfo;
	private $errorCode;
    //pdo对象  
    private $_pdo = null;  
    //用于存放实例化的对象  
    static private $_instance = null;  
      
    //公共静态方法获取实例化的对象  
    static public function getInstance() {  
        if (!(self::$_instance instanceof self)) {  
            self::$_instance = new self();  
        }  
        return self::$_instance;  
    }  
    /**
     * (non-PHPdoc)
     * @see IPdoBase::getErrorInfo()
     */
    public function getErrorInfo(){
    	return $this->errorInfo;
    }
    public function getErrorCode(){
    	return $this->errorCode;
    }    
    //私有克隆  
    private function __clone() {}  
      
    //私有构造  
    private function __construct() {  
        try {  
            $this->_pdo = new PDO(DB_DNS, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.DB_CHARSET));  
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        } catch (PDOException $e) {  
            exit($e->getMessage());  
        }  
    } 
    
    
    //新增
    public function add($_tables, Array $_addData) {
    	$_addFields = array();
    	$_addValues = array();
    	foreach ($_addData as $_key=>$_value) {
    		$_addFields[] = $_key;
    		$_addValues[] = $_value;
    	}
    	$_addFields = implode(',', $_addFields);
    	$_addValues = implode("','", $_addValues);
    	$_sql = "INSERT INTO $_tables[0] ($_addFields) VALUES ('$_addValues')";
    	$_stmt = $this->_pdo->prepare($_sql);
    	$_stmt->execute();
    	return  $_stmt->rowCount();
    	//return $this->execute($_sql)->rowCount();
    }
    
    //修改
    public function update($_tables, Array $_param, Array $_updateData) {
	    $_where = $_setData = '';
	    foreach ($_param as $_key=>$_value) {
	    $_where .= $_value.' AND ';
	    }
	    $_where = 'WHERE '.substr($_where, 0, -4);
	    foreach ($_updateData as $_key=>$_value) {
	    if (Validate::isArray($_value)) {
	    $_setData .= "$_key=$_value[0],";
	    } else {
	    $_setData .= "$_key='$_value',";
	    }
	    }
	    $_setData = substr($_setData, 0, -1);
	    $_sql = "UPDATE $_tables[0] SET $_setData $_where";
	    $_stmt = $this->_pdo->prepare($_sql);
	    $_stmt->execute();
	    return  $_stmt->rowCount();
	    //return $this->execute($_sql)->rowCount();
	 }
	    

	    
	    	//删除
	 public function delete($_tables, Array $_param) {
    	$_where = '';
    	foreach ($_param as $_key=>$_value) {
    	$_where .= $_value.' AND ';
    	}
    	$_where = 'WHERE '.substr($_where, 0, -4);
    	$_sql = "DELETE FROM $_tables[0] $_where LIMIT 1";
    	
    	$_stmt = $this->_pdo->prepare($_sql);
    	$_stmt->execute();
    	return  $_stmt->rowCount();
    }
    
    //查询
	public function select($_tables, Array $_fileld, Array $_param = array()) {
	    $_limit = $_order = $_where = $_like = '';
	    if (is_array($_param) && !empty($_param)) {
	    $_limit = isset($_param['limit']) ? 'LIMIT '.$_param['limit'] : '';
	    $_order = isset($_param['order']) ? 'ORDER BY '.$_param['order'] : '';
	    if (isset($_param['where'])) {
	    foreach ($_param['where'] as $_key=>$_value) {
	    $_where .= $_value.' AND ';
	    }
	    $_where = 'WHERE '.substr($_where, 0, -4);
	    }
	    if (isset($_param['like'])) {
	    foreach ($_param['like'] as $_key=>$_value) {
	    $_like = "WHERE $_key LIKE '%$_value%'";
	    }
	    }
	    }
	    $_selectFields = implode(',', $_fileld);
	    $_table = isset($_tables[1]) ? $_tables[0].','.$_tables[1] : $_tables[0];
	    $_sql = "SELECT $_selectFields FROM $_table $_where $_like $_order $_limit";
	    $_stmt = $this->_pdo->query($_sql);
	    return $_stmt->fetchAll();
    }
    /**
     *
     * @return last insert into id
     * @param string $sql
     * @param array $data
     */
    public function insert($sql,$data){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return 0;
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->execute();
    	$id=$this->_pdo->lastInsertId();
    	if($id==0){
    		$this->errorInfo=$sth->errorInfo();
    		$this->errorCode=$sth->errorCode();
    	}
    	return $id;
    }
    /**
     * 返回一行:array(field1=>val1,field2=>val2,...)
     * 结果为空，返回空数组
     * @return array;
     * @param string $sql
     * @param array $data
     */
    public function fetch($sql,$data,$fetch_mode=PDO::FETCH_ASSOC){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return array();
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->setFetchMode($fetch_mode);
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	$ret=$sth->fetch();
    	if(!is_array($ret))return array();
    	return $ret;
    }
    
    /**
     *
     * @return array;
     * @param string $sql
     * @param array $data
     */
    public function fetchAll($sql,$data,$fetch_mode=PDO::FETCH_ASSOC){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return array();
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->setFetchMode($fetch_mode);
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	$r=$sth->fetchAll();
    	return $r;
    }
    /**
     *  插入 或者 更新 使用
     * @return affected rows
     * @param string $sql
     * @param array $data
     */
    public function exec($sql,$data){
    	$sth=$this->_pdo->prepare($sql);
    	if(!$sth){
    		$this->errorInfo=$this->_pdo->errorInfo();
    		$this->errorCode=$this->_pdo->errorCode();
    		return 0;
    	}
    	foreach ($data as $k=>$v){
    		$sth->bindValue($k, $v,self::convert($v));
    	}
    	$sth->execute();
    	$this->errorInfo=$sth->errorInfo();
    	$this->errorCode=$sth->errorCode();
    	return $sth->rowCount();
    }
    private static function convert($var){
    	if(is_null($var))return PDO::PARAM_NULL;
    	if(is_numeric($var))return PDO::PARAM_INT;
    	return PDO::PARAM_STR;
    }
}
?>