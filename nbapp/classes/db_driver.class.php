<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: db_driver
 * @desc: Db connection and actions 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class db_driver{

	var $host = '';
	var $username = '';
	var	$password = '';
  var	$dbname = '';
	var	$port = '';
	var	$con_res = '';
  var	$limit_str = '';
  var	$orderby_str = '';
  var	$log_set = array();
	var	$log_query = array();
	
	function db_driver($params=array()){
			### DEFAULT VALUES - START ###
			$this->con_res = false;
			### DEFAULT VALUES - END ###
			$this->init($params);
	}

	function init($params=array()){
		$cnt = $this->_cnt($params);
		if($cnt > 0){
			foreach($params as $_par=>$_val){
				$this->$_par = $_val;
			}
		}
	}
	
	function connect(){
		$set_port = ($this->port) ? ":".$this->port:"";
 		$this->con_res = @mysql_connect($this->host.$set_port, $this->username, $this->password);
		if (!$this->con_res) {
      $err = 'DB Not connected : ' . mysql_error();
			$this->_log($msg);
      nb_admin_error_page_display(array("err" => $err), "MYSQL Error");
			die();
		}

		$db_selected = @mysql_select_db($this->dbname, $this->con_res);
		if (!$db_selected) {
      $err = 'Can\'t use DB : ' . mysql_error();
			$this->_log($err);
      nb_admin_error_page_display(array("err" => $err), "MYSQL Error");
			die();
		}
		
		return $this->con_res;
	}
	
	function disconnect(){
		if(mysql_close($this->con_res)){
			return true;
		}
		return false; 
	}
	
	function opendb(){
		if(!$this->con_res){
			if(!$this->connect()){
				$this->_log('Sorry mysql connection failed....');
				die();
			}
		}
	}
	
	function closedb(){
		if($this->con_res){
			if(!$this->disconnect()){
				$this->_log('Sorry mysql disconnection failed....');
				die();
			}
		}
	}
	
  function allrecords($table="", $where_cond="1"){    
    $sql = "select * from $table WHERE ".$where_cond;
    return $this->query($sql);
  }
  
  function allrecordscnt($table="", $where_cond="1", $feild = "id"){    
    $sql = "select count($feild) as cnt from $table WHERE ".$where_cond;
    $tmp_data = $this->query($sql);
    return (isset($tmp_data['allrows'][0]['cnt'])) ? $tmp_data['allrows'][0]['cnt']:0;
  }
	
  function query($query="",$update_qry=0){
    
    if($this->orderby_str){
      $query .= $this->orderby_str;
    }
    
    if($this->limit_str){
      $query .= $this->limit_str;
    }
    
    $this->_log($query);
		$this->opendb();		
		$this->log_query[] = $query;
		$dataset = array();
		
		// Perform Query
		$result = mysql_query($query);
			
		// Check result
		// This shows the actual query sent to MySQL, and the error. Useful for debugging.
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= ' Whole query: ' . $query;
			$this->_log($message);
			die();
		}
		
    if($update_qry == 0){
      $num_rows = mysql_num_rows($result);
      $dataset['num_rows'] = $num_rows;
		}
    
		// Use result
		// Attempting to print $result won't allow access to information in the resource
		// One of the mysql result functions must be used
		// See also mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
		if($num_rows > 0){
			while ($row = mysql_fetch_assoc($result)) {
        $allrows[] = $row;
      }
      $dataset['allrows'] = $allrows;
		}

		if($update_qry == 0){
      mysql_free_result($result);
    }
		
		return $dataset;
	}
  
  function insert($query=""){
    $this->_log($query);
		$this->opendb();		
		$this->log_query[] = $query;
		
    // Perform Query
		$result = mysql_query($query);
			
		// Check result
		// This shows the actual query sent to MySQL, and the error. Useful for debugging.
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= ' Whole query: ' . $query;
			$this->_log($message);
			die();
		}
		
    $lastid = mysql_insert_id();
		
		return $lastid;
	}
	
	function _clean($d=''){
		return ($d) ? mysql_real_escape_string($d):'';
	}
	
	function _log($d=''){
		$this->log_set[] = time()." -> ".$d;
		__log("[NB_DB_MYSQL] \t $d");
	}
	
	function _set_val($a=array()){
		if(is_array($a)){
			$cnt = $this->_cnt($a);
			if($cnt > 0){
				$tmp_val = array();
				foreach($a as $k=>$v){
					$tmp_val[] = $k."='".$this->_clean($v)."'";
				}
				return implode(", ",$tmp_val);
			}
		}
		return;
	}
	
	function _bulk_insert($a=array()){
		if(is_array($a)){
			$cnt = $this->_cnt($a);
			if($cnt > 0){
        $tmp_val = array();
				$tmp_flds = array();
				
				$tmp_flds = array_keys($a[0]);
        $tmp_flds_str = '( '. implode(', ',$tmp_flds) .' ) VALUES ';
				$tmp_val_str = "";
				
				foreach($a as $inval){
					$tmp_val_str .= " ( ";
					
					$tmp_val = "";
					foreach($inval as $v){
						$tmp_val .= "'".$this->_clean($v)."' ,";
					}
					$tmp_val = substr($tmp_val,0,-1);
					$tmp_val_str .= $tmp_val;
					
					$tmp_val_str .= " ) ,";
				}
				
				$tmp_val_str = substr($tmp_val_str,0,-1);
        
        return $tmp_flds_str ." ". $tmp_val_str;
			}
		}
		return -1;
	}
	
	function _where_val($a=array()){
		if(is_array($a)){
			$cnt = $this->_cnt($a);
			if($cnt > 0){
				$tmp_val = array();
				foreach($a as $k=>$v){
					$tmp_val[] = $k."='".$this->_clean($v)."'";
				}
				return implode("AND ",$tmp_val);
			}
		}
		return;
	}
	
	function _cnt($a=array()){
		if(is_array($a)){
			return count($a);
		}
	}
}
?>