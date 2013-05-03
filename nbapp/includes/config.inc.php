<?php 
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL ^ E_NOTICE);
		break;
	
		case 'testing':
		case 'production':
			error_reporting(0);
		break;

		default:
			exit('The application environment is not set correctly.');
	}
}
#Autoload the classes
function nb_autoloader($class) {
	global $NBCONFIG;
	#if the class exists ddont load it
	if (class_exists($class)) return;
	try{
		$cls = $NBCONFIG->base_path.'classes/' . $class . '.class.php';
		$mod = $NBCONFIG->base_path.'modules/' . $class . '.class.php';
		if(is_file($cls))
			include $cls;
		else if(is_file($mod))
			include $mod;
			
	}catch(Exception $e){
		__log( 'Autoloader Message: Class: '.$class .' ::: ' .$e->getMessage() );
    return -1;
	}
}

spl_autoload_register('nb_autoloader');

$NBCONFIG->index_file = "index.php";
$NBCONFIG->ck_key = "nBs";
$NBCONFIG->ck_admin_login_key = "nbAd";
$NBCONFIG->css_refresh_key = "2012081512";
$NBCONFIG->data_sep = ".NbS.";

#Create DB Connection
$init_param = array("host" => "localhost", "username" => "root", "password" => "", "dbname" => "nockbits");
$NBCONFIG->db = new db_driver($init_param);
$NBCONFIG->db->connect();
$NBCONFIG->records_limit = 20;

$NBCONFIG->ignore_logins = array("","login");
#include commomn files
include_once($NBCONFIG->app_folder."includes/functions.inc.php");

#initialize the cache
$cache_dir = nb_get_conf("base_path").'cache/';
$init_param = array("cache_dir" => $cache_dir);
$NBCONFIG->simple_cache = new simple_cache($init_param);
?>