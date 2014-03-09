<?php
/**
 * 数据库单表操作类，本类提供单表标准的增删改查操作，以及搜索、排序和分页。
 * @author zhoumengkang
 * @version 1.0
 * @date 2013-7-13
 */
class D{
	protected $link    = null; //数据库连接资源
	protected $queryId = null;
	public    $lastSql = null;//刚执行的sql语句,方便排错
	/**
	 *构造方法：实现数据库连接，表字段信息的获取。
	 *@param string $tablename 被操作的表名
	 *
	 */
	public function __construct(){
		if ( !extension_loaded('mysql') ) {
            throw_exception(L('_NOT_SUPPERT_').':mysql');
        }
		$this->link = mysql_connect(DB_HOST,DB_USER,DB_PASSWD)or die("数据库连接失败！");
		mysql_set_charset('utf8');
		mysql_select_db(DB_NAME,$this->link);

	}
	public function q($sql){
		if(!empty($sql)) {
			//释放结果集
			if ( $this->queryId ) {
				$this->free();    
			}
        }else{
            return false;
        }
		//执行sql语句，获取新的queryId
		$this->queryId = mysql_query($sql);
		$this->lastSql = $sql;
		if(is_resource($this->queryId)){
		//如果是查询语句
			if(mysql_num_rows($this->queryId)>0) {
				while($row = mysql_fetch_assoc($this->queryId)){
					$result[] = $row;
				}
				mysql_data_seek($this->queryId,0);
			}
			return $result;
        }elseif(is_bool($this->queryId)){
		//如果是其他执行语句
			//如果是插入语句，则返回插入的主键值
			if(mysql_insert_id($this->link)){
				return mysql_insert_id($this->link);
			}
			return mysql_affected_rows($this->link);
		}
		//mysql_free_result($this->queryId);
	}
	//释放结果集
	public function free(){
		mysql_free_result($this->queryId);
        $this->queryId = 0;
	}
	//获取最近一次执行的sql语句
	public function lastsql(){
		return $this->lastSql;
	}
}