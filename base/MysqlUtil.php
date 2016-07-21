<?php  
class MysqlUtil {  
    protected $mysqli;                          //mysqli实例对象  
    public $sql;                                //sql语句  
    protected $rs;                              //结果集  
    protected $query_num    = 0;                //执行次数  
    protected $fetch_mode   = MYSQLI_ASSOC;     //获取模式  
    protected $cache;                           //缓存类对象  
    protected $reload     = false;              //是否重新载入  
    protected $cache_mark = true;               //缓存标记  


    protected $dbhost = "127.0.0.1";
    protected $dbuser = "root";
    protected $dbpass = "soso";
    protected $dbname = "goov";
    protected $dbport = 3306;

     /** 
     * Description:（1）静态变量，保存全局实例，跟类绑定，跟对象无关 
     *             （2）私有属性，为了避免类外直接调用 类名::$instance，防止为空 
     */  
    private static $instance;  
      
  
    //构造函数：主要用来返回一个mysqli对象  
    private  function  __construct() {  
        $this->mysqli = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname, $this->dbport);  
        if(mysqli_connect_errno()) {  
            $this->mysqli = false;  
            echo '<h2>'.mysqli_connect_error().'</h2>';  
            die();  
        } else {  
            $this->mysqli->set_charset("utf8");  
        }  
    }  

    /** 
     * Description:私有化克隆函数，防止外界克隆对象 
     */  
    private function __clone()  
    {  
    } 

     /** 
     * Description:静态方法，单例访问统一入口 
     * @return Singleton：返回应用中的唯一对象实例 
     */  
    public static function GetInstance()  
    {  
        if (!(self::$instance instanceof self))  
        {  
            self::$instance = new self();  
        }  
        return self::$instance;  
    }  
       
  
    //缓存类对象：文件缓存、memcache键值对缓存  
    public function cache_obj($cache) {  
        $this->cache = $cache;  
    }  
  
    //析构函数：主要用来释放结果集和关闭数据库连接  
    public function  __destruct() {  
        $this->free();  
        $this->close();  
    }  
  
    //释放结果集所占资源  
    protected function free() {  
        @$this->rs->free();  
    }  
  
    //关闭数据库连接  
    protected function close() {  
        $this->mysqli->close();  
    }  
  
    //获取结果集  
    protected function fetch() {  
        return $this->rs->fetch_array($this->fetch_mode);  
    }  
  
    //获取查询的sql语句  
    protected function get_query_sql($sql, $limit = null) {  
        if (@preg_match("/[0-9]+(,[ ]?[0-9]+)?/is", $limit) && !preg_match("/ LIMIT [0-9]+(,[ ]?[0-9]+)?$/is", $sql)) {  
            $sql .= " LIMIT " . $limit;  
        }  
        return $sql;  
    }  
  
    //从缓存中获取数据  
    protected function get_cache($sql,$method) {  
        $cache_file    = md5($sql.$method);  
        $res    = $this->cache->get($cache_file);  
        if(!$res) {                         //如果缓存文件过期或不存在的话，返回false；如果缓存文件存在且未过期的话，则返回缓存数据  
            $res    = $this->$method($sql);  //先从缓存中取数据，如果缓存中没数据，则从数据库中取数据  
            if($res && $this->cache_mark && !$this->reload) {  
                $this->cache->set($cache_file, $res);//如果缓存文件过期或不存在的话，将重新将从数据库中查询的数据放入缓存文件  
            }  
        }  
        return $res;  
    }  
  
    //获取查询次数  
    public function query_num() {  
        return $this->query_num;  
    }  

      //执行sql语句查询  
    public function exec($sql, $limit = null) {  
        $sql    = $this->get_query_sql($sql, $limit);  
        $this->sql[]    = $sql;  
        $this->rs    = $this->mysqli->query($sql);  
        if (!$this->rs) {   
            $result = array('rs' => $this->rs, 'errorcode'=>0,'errorinfo'=>$this->mysqli->error.'[--sql:'.$sql.'--]');
            return $result;
        } else {  
            $this->query_num++;   
            $result = array('rs' => $this->rs, 'errorcode'=>0,'errorinfo'=>'');
            return $result;
        }  
    }  
  
    //执行sql语句查询  
    public function query($sql, $limit = null) {  
        $sql    = $this->get_query_sql($sql, $limit);  
        $this->sql[]    = $sql;  
        $this->rs    = $this->mysqli->query($sql);  
        if (!$this->rs) {  
            echo "<p>error: ".$this->mysqli->error."</p>";  
            echo "<p>sql: ".$sql."</p>";  
            die();  
        } else {  
            $this->query_num++;  
            return $this->rs;  
        }  
    }  
  
    //返回单条记录的单个字段值  
    public function get_one($sql) {  
        $this->query($sql, 1);  
        $this->fetch_mode    = MYSQLI_NUM;  
        $row = $this->fetch();  
        $this->free();  
        return $row[0];  
    }  
  
    //缓存单个字段  
    public function cache_one($sql, $reload = false) {  
        $this->reload    = $reload;  
        $sql    = $this->get_query_sql($sql, 1);  
        return $this->get_cache($sql, 'get_one');  
    }  
  
    //获取单条记录  
    public function get_row($sql, $fetch_mode = MYSQLI_ASSOC) {  
        $this->query($sql, 1);  
        $this->fetch_mode    = $fetch_mode;  
        $row = $this->fetch();  
        $this->free();  
        return $row;  
    }  
  
    //缓存行  
    public function cache_row($sql, $reload = false) {  
        $this->reload    = $reload;  
        $sql    = $this->get_query_sql($sql, 1);  
        return $this->get_cache($sql, 'get_row');  
    }  
  
    //返回所有的结果集  
    public function get_all($sql, $limit = null, $fetch_mode = MYSQLI_ASSOC) {  
        $this->query($sql, $limit);  
        $all_rows = array();  
        $this->fetch_mode    = $fetch_mode;  
        while($rows = $this->fetch()) {  
            $all_rows[] = $rows;  
        }  
        $this->free();  
        return $all_rows;  
    }  
  
    //缓存all  
    public function cache_all($sql, $reload = false, $limit = null) {  
        $this->reload    = $reload;  
        $sql    = $this->get_query_sql($sql, $limit);  
        return $this->get_cache($sql, 'get_all');  
    }  
  
    //返回前一次mysql操作所影响的记录行数  
    public function affected_rows() {  
        return $this->mysqli->affected_rows;  
    }  
      
     /**  
     * 获取插入语句  
     *  
     * @param    string     $tbl_name   表名  
     * @param    array      $info       数据  
     */  
    public function get_insert_db_sql($tbl_name,$info)  
    {     
        //首先判断是否为数组，再判断数组是否为空  
        if(is_array($info)&&!empty($info))  
        {  
            $i = 0;  
            foreach($info as $key=>$val)  
            {  
                $fields[$i] = $key; //将所有的键名放到一个$fields[]数组中  
                $values[$i] = $val; //将所有的值放到一个$values[]数组中  
                $i++;  
            }  
            $s_fields = "(".implode(",",$fields).")";  
            $s_values  = "('".implode("','",$values)."')";  
            $sql = "INSERT INTO  
                        $tbl_name  
                        $s_fields  
                    VALUES  
                        $s_values";  
            Return $sql;  
        }  
        else  
        {  
            Return false;  
        }  
    }  
          
    /**  
     * 获取替换语句:replace into是insert into的增强版  
     * 区别：replace into跟insert功能类似，不同点在于：replace into 首先尝试插入数据到表中，如果发现表中  
     *        已经有此行数据(根据主键或唯一索引判断)，则先删除此行数据，然后插入新的数据，否则直接插入新数据  
     * @param    string     $tbl_name   表名  
     * @param    array      $info       数据  
     */  
    public function get_replace_db_sql($tbl_name,$info)  
    {  
        if(is_array($info)&&!empty($info))  
        {  
            $i = 0;  
            foreach($info as $key=>$val)  
            {  
                $fields[$i] = $key;  
                $values[$i] = $val;  
                $i++;  
            }  
            $s_fields = "(".implode(",",$fields).")";  
            $s_values  = "('".implode("','",$values)."')";  
            $sql = "REPLACE INTO  
                        $tbl_name  
                        $s_fields  
                    VALUES  
                        $s_values";  
            Return $sql;  
        }  
        else  
        {  
            Return false;  
        }  
    }  
      
  /**  
     * 获取更新SQL语句  
     *  
     * @param    string     $tbl_name   表名  
     * @param    array      $info       数据  
     * @param    array      $condition  条件  
     */  
    public function get_update_db_sql($tbl_name,$info,$condition)  
    {  
        $i = 0;  
        $data = '';  
        if(is_array($info)&&!empty($info))  
        {  
            foreach( $info as $key=>$val )  
            {  
                if(isset($val))  
                {  
                    $val = $val;  
                    if($i==0&&$val!==null)  
                    {  
                        $data = $key."='".$val."'"; //第一次：如，update 表名 set username='admin'  
                    }  
                    else  
                    {  
                        $data .= ",".$key." = '".$val."'";//非第一次：如， ，password='123'  
                    }  
                    $i++;  
                }  
            }     
            $sql = "UPDATE ".$tbl_name." SET ".$data." WHERE ".$condition;  
            return $sql;  
        }  
        else  
        {  
            Return false;  
        }  
    }  
      
    /**  
     * 取得数据库最后一个插入ID  
     *  
     * @return int  
     */  
    public function last_id() {  
        return mysqli_insert_id($this->mysqli);  
    }  
      
  
    public function real_get($sql, $fetch_mode = MYSQLI_ASSOC) {  
        $this->query($sql);  
        $this->fetch_mode    = $fetch_mode;  
        $row = $this->fetch();  
        $this->free();  
        return $row;  
    }  
} 




/* 使用

$tbl_product = TBL_PRE . "products";  
        $tbl_goods = TBL_PRE . "goods";  
        $tbl_brand = TBL_PRE . "goods_brand";  
        $tbl_category = TBL_PRE . "goods_category";  
        $tbl_type = TBL_PRE . "goods_type";  
        $tbl_spec = TBL_PRE ."goods_specification";  
          
        $sql = " SELECT a.*, b.brand_name, b.brand_name_second,b.brand_logo,b.brand_simple_intro,  
                 b.url_path,c.category_name,c.url_path AS cate_url_path, sp.spec_name, sp.spec_memo   
                 FROM   
                  (SELECT g.*,p.product_id, p.bn, p.bar_code, p.color_id, p.color_text,p.small_list_page_product_pic_default,  
                  p.small_list_page_product_pic_replace,p.is_new, p.is_promotion,p.is_newstyle,p.is_limit,p.is_classic,p.is_new_spring,p.act_id,  
                   p.product_name, p.price as product_price, p.market_price as product_market_price, p.intro,  
                   p.editor_intro,p.size_image_path, p.size_intro, p.video_path, p.size_image_name,   
                   p.status as pstatus, p.is_stop as pisstop   
                    FROM $tbl_product p   
                    LEFT JOIN $tbl_goods g ON p.goods_id = g.goods_id   
                    WHERE p.product_id = $id $_filter) a   
                 LEFT JOIN $tbl_brand b ON a.brand_id = b.brand_id  
                 LEFT JOIN $tbl_category c ON a.category_id = c.category_id  
                 LEFT JOIN $tbl_spec sp ON a.spec_id = sp.spec_id";  
          
        $result['base'] = $this->db->cache_row($sql); 

*/