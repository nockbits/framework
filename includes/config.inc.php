<?php 
class nbmastercontrol{}
$NBCONFIG = new nbmastercontrol;
$NBCONFIG->web_path = "/home/user1/httpd/<project>";
$NBCONFIG->base_path = $NBCONFIG->web_path."nbapp/";//Current Working dir
$NBCONFIG->base_domain = "localhost";
$NBCONFIG->base_url = "http://".$NBCONFIG->base_domain."/nockbits/www/";//Base URL of the website
$NBCONFIG->admin_url = "";//Base URL of the website
$NBCONFIG->sitename  = "ProjectNAme";
$NBCONFIG->sitemail  = "contact@domain.com";   
$NBCONFIG->sitephoneno  = "1800&nbsp;1850&nbsp;0077";

define("NBMASTERCHK",1);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('ENVIRONMENT', 'development');
define('APP_FOLDER', '');
define('CK_DOMAIN', $NBCONFIG->base_domain);

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

$NBCONFIG->index_file = "index.php/";
$NBCONFIG->ck_key = "nbSaAps";
$NBCONFIG->ck_admin_login_key = "nbApd";
$NBCONFIG->css_refresh_key = "201303";
$NBCONFIG->data_sep = ".NfS.";

#Create DB Connection
$init_param = array("host" => "localhost", "username" => "root", "password" => "", "dbname" => "nockbits");
$NBCONFIG->db = new db_driver($init_param);
$NBCONFIG->db->connect();
$NBCONFIG->ignore_logins = array();
#include commomn files
include_once($NBCONFIG->base_path."includes/functions.inc.php");

#initialize the cache
$cache_dir = nb_get_conf("web_path").'cache/';
$init_param = array("cache_dir" => $cache_dir);
$NBCONFIG->simple_cache = new simple_cache($init_param);
?>