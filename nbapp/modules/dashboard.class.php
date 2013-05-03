<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: dashboard
 * @desc: dashboard of the system 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class dashboard{

	var	$log_err = array();
	var $post_data = array();
	
	function dashboard($params=array()){
	}
	
	function actions(){
    $mode = nb_clean("mode");
		switch($mode){    
			default:
				return 'dashboard';
			break;
		}
	}
}
?>