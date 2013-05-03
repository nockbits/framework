<?php
if(phpversion() < 5) die("Sorry this PHP version is not compatible with this framework...");
set_time_limit(0);
/**
 * @note: 
 *  1. For all file paths and urls add forward slash;
 */
class nbmastercontrol{}
$NBCONFIG = new nbmastercontrol;
$NBCONFIG->web_path = "/www/nockbits/www/";
$NBCONFIG->base_path = $NBCONFIG->web_path."nbapp/";//Current Working dir
$NBCONFIG->base_domain = "localhost";
$NBCONFIG->base_url = "http://".$NBCONFIG->base_domain."/nockbits/www/";//Base URL of the website
$NBCONFIG->admin_url = $NBCONFIG->base_url."nbapp/";//Base URL of the website

define("NBMASTERCHK",1);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('ENVIRONMENT', 'development');
define('APP_FOLDER', 'nbapp');
define('CK_DOMAIN', $NBCONFIG->base_domain);

#Set app path
#you can move the nbapp anywhere but always  rememberto use the config app_folder path in your code
$NBCONFIG->app_folder = $NBCONFIG->base_path;
#Include config file
include_once($NBCONFIG->app_folder."includes/config.inc.php");
#Call the master control
include_once($NBCONFIG->app_folder."includes/master.inc.php");
?>