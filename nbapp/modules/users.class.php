<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: users
 * @desc: users to the system 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class users{

	var	$log_err = array();
	var $post_data = array();
	
	# Function: Constructor START #
	function users($params=array()){
		### DEFAULT VALUES - START 	###
		
		### DEFAULT VALUES - END 	###
	}
	# Function: Constructor END #
	
	# Function: actions START #
	function actions(){
		$mode = nb_clean("mode");
		switch($mode){
			case 'add':
			{	
				$this->_add();	
				return 'add';
				break;
			}
			case 'edit':
			{	
				$this->_edit();	
				return 'edit';
				break;
			}
			case 'insert':
			{	
				$this->_insert();	
				return 'insert';
				break;
			}
			case 'update':
			{	
				$this->_update();	
				return 'update';
				break;
			}
			case 'delete':
			{	
				$this->_delete();	
				return 'delete';
				break;
			}
			case 'list':
			default:
			{	
				return 'list';
				break;
			}
		}
	}	
	# Function: actions END #
	
	# Function: _list START #
	function _list(){
		
	}
	# Function: list END #
	
	# Function: _add START #
	function _add(){
	
	}
	# Function: _add END #
	
	# Function: _edit START #
	function _edit(){
	
	}
	# Function: _edit END #

	# Function: _insert START #
	function _insert(){
	
	}
	# Function: _insert END #

	# Function: _update START #
	function _update(){
	
	}
	# Function: _update END #
	
	# Function: _delete START #
	function _delete(){
	
	}
	# Function: _delete END #
	
	# Function: _validate START #
	function _validate(){
				
	}
	# Function: _validate END #
	
}
?>