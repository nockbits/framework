<?php 
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

$func = nb_clean("func");
$ignore_page_logins = nb_get_conf("ignore_logins");

if(!nb_is_admin_loggedin() && !in_array($func,$ignore_page_logins)) nb_redirect();

//display data
$data = array();
switch($func)
{
	case 'home':
	break;
	
	case 'users':
  {
		$obj = new users;
		$res = $obj->actions();
  	break;
	}
  case 'articles':
  {
		$obj = new articles;
		$res = $obj->actions();
  	break;
	}
  case 'enquiry':
  {
		$obj = new enquiry;
		$res = $obj->actions();
  	break;
	}
  case 'dashboard':
  {
		$obj = new dashboard;
		$res = $obj->actions();
    nb_admin_display("dashboard",$data);
  	break;
	}
	case 'login':
	default:
	{
    $obj = new login;
		$res = $obj->actions();
		if($res == '' || $res == 'login'){
			$base = nb_get_conf("base_path");
			$data['err'] = $obj->log_err;
			$data['postdata'] = $obj->post_data;			
		}
    nb_admin_display("login",$data);
  	break;
  }
}
?>