<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: login
 * @desc: logint to the system 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class login{

	var	$log_err = array();
	var $post_data = array();
	
	function login($params=array()){
		### DEFAULT VALUES - START ###
		$this->post_data['txtUsername'] = nb_clean("txtUsername");
		$this->post_data['txtPassword'] = nb_clean("txtPassword");	
		### DEFAULT VALUES - END ###
	}
	
	function actions(){
    $mode = nb_clean("mode");
		switch($mode){
			case 'check':
				return $this->_check();
			break;
			
      case 'logout':
				return $this->_logout();
			break;
    
      case 'logout':
				return $this->_logout();
			break;
    
			default:
				return 'login';
			break;
		}
	}
	
	function _check(){
		$this->_validate();
		$cnterr = count($this->log_err);
		if($cnterr > 0){
			return 'login';
		}
		
    $db = nb_get_conf("db");
    $sql = "SELECT id FROM tbl_admin where 
            adusername = '".($this->post_data['txtUsername'])."' 
            AND adpassword = '".md5($this->post_data['txtPassword'])."'";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
			$sep = nb_get_conf("data_sep");
			$admin_val = $this->post_data['txtUsername'].$sep.time().$sep.'1';
			$exp = (time()+360000);
			nb_set_cok(__sessionkey("login_more"),$admin_val,$exp);
			nb_set_cok(__sessionkey("login"),$this->post_data['txtUsername'],$exp);      
      __log("Login - ".__sessionkey("login_more"). "\t" .$admin_val);      
      nb_redirect("func=dashboard");	exit;
			return 'success';
		}else{
      $this->log_err[] = "Invalid Login.";
      return 'login';
    }
	}
  
	function _validate(){
		if(strlen($this->post_data['txtUsername']) < 5){
			$this->log_err[] = 'Please enter valid username';
		}
		if(strlen($this->post_data['txtPassword']) < 5){
			$this->log_err[] = 'Please enter valid password';
		}	
    return 1;
	}
  
  function _logout(){
    $exp = (time()-3600);
    __log("Logout - ".nb_get_cok(__sessionkey("login_more")));
    
    nb_set_cok(__sessionkey("login_more"),"",$exp);
		nb_set_cok(__sessionkey("login"),"",$exp);
    nb_redirect("func=login");	exit;
		return 'success';		
	}
}
?>