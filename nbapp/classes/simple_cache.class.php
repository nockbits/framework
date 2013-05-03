<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: simple_cache
 * @desc: Simple cache - data/content to files 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 *	$init_param = array("cache_dir" => $cache_dir);
 *	$obj = new simple_cache($init_param);
 *	$val = $obj->getSimpleCache($cache_key);
 *	$obj->setSimpleCache($cache_key,$cache_val);
 */
class simple_cache{

	var $cache_dir = '';
	var $cache_sep = '';
	var	$cache_set_keys = array();
	var	$cache_get_keys = array();
	var	$cache_log_errors = array();
	var $server_ts = '';
	
	function simple_cache($params=array()){
			### DEFAULT VALUES - START ###
			$this->cache_dir = 'cache';
			$this->cache_sep = ':SCSEP:';		
			$this->server_ts = time();
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
		
		if(!$this->cache_dir){
			die("Sorry, cache dir is not set......");
		}

		if(!is_dir($this->cache_dir)){
			mkdir($this->cache_dir);
			chmod($this->cache_dir,0777);
			if(!is_dir($this->cache_dir)){
				$this->cache_log_errors[] = "Dir not writable: ".$this->cache_dir;
			}	
		}
		return;
	}

	function setSimpleCache($key='',$val='',$days=0){
		$key = trim($key);
		if(!$key) return;
		
		if(!is_writable($this->cache_dir)){
			$this->cache_log_errors[] = "Dir not writable: ".$this->cache_dir;
			return -1;
		}
		
		$this->cache_set_keys[] = $key;
		if (!$handle = fopen($this->cache_dir.$key, 'w+')) {
			$this->cache_log_errors[] = "Cannot open file ($key). Please check the permissions/disk space";
			return;
		}

		$days = (int) $days;
		$cont = '';
		$ttly = '';
		$ts = mktime(23,59,59,date("m",$this->server_ts),(date("d",$this->server_ts)+$days),date("Y",$this->server_ts));
		$cont = $ts.$this->cache_sep.$days.$this->cache_sep.$val;
		if (fwrite($handle, $cont) === FALSE) {
			$this->cache_log_errors[] = "Cannot write to file ($key). Please check the permissions/disk space";
		}
		@fclose($handle);
		return;
	}

	function getSimpleCache($key=''){
		$key = trim($key);
		if(!$key) return;
		$this->cache_get_keys[] = $key;
		
		if(is_file($this->cache_dir.$key)){
			$tmp  = '';
			$tmp = @file_get_contents($this->cache_dir.$key);
			if($tmp){
				$tmp = explode($this->cache_sep,$tmp);
				$ts = (isset($tmp[0])) ? $tmp[0]:'';
				$ttly = (isset($tmp[1])) ? $tmp[1]:'';
				$data = (isset($tmp[2])) ? $tmp[2]:'';

				if($ttly != 0){
					if($ts <= $this->server_ts){
						return $data;
					}else{
						@unlink($this->cache_dir.$key);
						return;
					}
				}else{
					return $data;
				}				
			}
			return;
		}
	}

  function setCacheTemplate($key='',$val=''){
		$key = trim($key);
		if(!$key) return;
		
		if(!is_writable($this->cache_dir)){
			$this->cache_log_errors[] = "Dir not writable: ".$this->cache_dir;
			return -1;
		}
		
		if (!$handle = fopen($this->cache_dir.$key, 'w+')) {
			$this->cache_log_errors[] = "Cannot open file ($key). Please check the permissions/disk space";
			return;
		}

		if (fwrite($handle, $val) === FALSE) {
			$this->cache_log_errors[] = "Cannot write to file ($key). Please check the permissions/disk space";
		}
		@fclose($handle);
		return;
	}
  
  function getCacheTemplate($key=''){
		$key = trim($key);
		if(!$key) return 0;
		
		if(!is_writable($this->cache_dir)){
			$this->cache_log_errors[] = "Dir not writable: ".$this->cache_dir;
			return 0;
		}
		
		if (is_file($this->cache_dir.$key)) {
      include_once($this->cache_dir.$key);
		}
    return 0;
	}
  
	function _cnt($a=array()){
		if(is_array($a)){
			return count($a);
		}
	}
}
?>