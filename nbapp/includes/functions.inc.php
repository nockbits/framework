<?php 
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

# Function: nb_get_all_params START
function nb_get_all_params()
{
	//SEF QUERY STRING
	$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
	if (trim($path, '/') != '' && $path != "/".SELF)
	{
		$tmp = explode("/",$path);
		array_shift($tmp);//pop first blank array
		$set['func'] = (isset($tmp[0])) ? array_shift($tmp):'';//pop the second param having the function name
		$set['params'] = $tmp;//assign the remaining as params
		return $set;
	}
	//NORMAL QUERY STRING
	$path = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
	if (trim($path, '/') != '')
	{
		$tmp = explode("&",$path);
		$k=0;
		while($t = each($tmp))
		{
			list($key,$val) = explode("=",$t["value"]);
			if($k == 0) 
				$set['func'] = $val;
			else 
				$set['params'][] = $val;//assign the remaining as params
			$k++;
		}
		return $set;
	}
	//GLOBAL GET
	if (is_array($_GET) && trim(key($_GET), '/') != '')
	{
		$set['func'] = (isset($_GET["func"])) ? $_GET["func"]:'';
		array_shift($_GET);//pop first function call
		while($t = each($_GET))
		{
			$set['params'][] = $t["value"];//assign the remaining as params
		}
		return $set;
	}
	
	return;
}
# Function: nb_get_all_params END

# Function: nb_get_conf START
function nb_get_conf($key='')
{
	global $NBCONFIG;
	return (isset($NBCONFIG->$key)) ? $NBCONFIG->$key : '';
}
# Function: nb_get_conf END

# Function: nb_is_admin_loggedin START
function nb_is_admin_loggedin()
{
	$admin_key = nb_get_conf("ck_key").nb_get_conf("ck_admin_login_key");
	return (isset($_COOKIE[$admin_key])) ? true : false;
}
# Function: nb_is_admin_loggedin END

# Function: nb_set_cok START
function nb_set_cok($k,$v,$exp=0,$secure=0)
{
	$exp = ($exp) ? $exp:(time()+3600);
	setcookie($k, $v, $exp, "/", CK_DOMAIN, $secure);
	return 1;
}
# Function: nb_set_cok END

# Function: nb_get_cok START
function nb_get_cok($k)
{
	return (isset($_COOKIE[$k])) ? $_COOKIE[$k] : false;
}
# Function: nb_get_cok END


# Function: is_admin_loggedin START
function nb_redirect($page="")
{
	$url = nb_site_url($page);
	header("Location:$url");
	exit;
}
# Function: is_admin_loggedin END

# Function: nb_site_url START
function nb_site_url($page="")
{
	$url = nb_get_conf("admin_url");
  $index = nb_get_conf("index_file");
	if($url){
    $url .= ($index) ? $index:''; 
    $url .= "?";
    $url .= ($page) ? $page:''; 
  }else{
    $url = nb_get_conf("base_url");
    $url .= ($index) ? $index:'';
    $url .= ($page) ? $page:''; 
  }	
	return $url;
}
# Function: nb_site_url END

# Function: nb_base_url START
function nb_base_url()
{
	$url = nb_get_conf("admin_url");
	if(!$url) $url = nb_get_conf("base_url");
	return $url;
}
# Function: nb_base_url END

# Function: __e START
function nb_clean($d=''){
	$set = '';
	if(isset($_GET[$d])){
		$set = $_GET[$d];
	}else if(isset($_POST[$d])){
		$set = $_POST[$d];
	}else if(isset($_REQUEST[$d])){
		$set = $_REQUEST[$d];
	}
	
	$set = trim($set);
	if(get_magic_quotes_gpc()){
		$set = stripslashes($set);
	}
	$set = htmlentities($set);
	
	return $set;
}
# Function: __e END


# Function: nb_admin_display START
function nb_admin_display($view='',$data=array(),$ajax=0){
	$base = nb_get_conf("base_path");
	$viewfile = $base."views/web_$view.php";
	if(is_file($viewfile)){
		$postdata = (isset($data['postdata'])) ? $data['postdata']:array();
		$err = (isset($data['err'])) ? $data['err']:array();
		$msg = (isset($data['msg'])) ? $data['msg']:array();
    if(isset($data['extravars'])){
      extract($data['extravars']);
    }
		if($ajax){
			include_once($viewfile);
		}else{
			include_once($base."views/web_header.php");
			include_once($viewfile);
			include_once($base."views/web_footer.php");
		}
	}
}
# Function: nb_admin_display END

# Function: nb_admin_info START
function nb_admin_info($err='',$msg='',$ajax=0){
	$base = nb_get_conf("base_path");
	$viewfile = $base."views/web_info.php";
	if(is_file($viewfile)){
		include_once($viewfile);
	}
}
# Function: nb_admin_info END

# Function: __e START
function __e($d='',$def=''){
	echo ((!empty ($d)) ? $d:$def);
}
# Function: __e END

# Function: __log START
function __log($d=''){
  $path = nb_get_conf("base_path");
	error_log("[".date("Y-m-d H:i:s")."]"."\t ".$d." \n",3,$path."app.".date("Ymd").".log");
}
# Function: __log END

# Function: __cnt START
function __cnt($a=array()){
  if(is_array($a)){
    return count($a);
  }else{
    return -1;
  }
}
# Function: __cnt END

# Function: __sessionkey START
function __sessionkey($key=''){
  $session = array();
  $session['login_more'] = nb_get_conf("ck_key").nb_get_conf("ck_admin_login_key");
  $session['login'] = nb_get_conf("ck_key").nb_get_conf("ck_admin_login_key")."lo";
  return (isset($session[$key])) ? $session[$key]:false;
}
# Function: __sessionkey END

# Function: nb_get_lang_msg START
function nb_get_lang_msg($key='',$lang='en'){
  $lang = array();
  $lang["en"]["list_no_records"] = "Ohhh! Sorry, no records found in the system.";
  return (isset($lang["en"][$key])) ? $lang["en"][$key]:false;
}
# Function: nb_get_lang_msg END

# Function: nb_fck START
function nb_fck($k='', $v='',$w='750',$h='500'){
  $base=nb_base_url();
  include("./fckeditor/fckeditor.php");	
  $oFCKeditor = new FCKeditor($k) ;
  $oFCKeditor->BasePath = $base.'fckeditor/' ;
  $oFCKeditor->Height = $h;
  $oFCKeditor->Width = $w;
  $oFCKeditor->ToolbarSet = "Basic";
  $oFCKeditor->Value	= $v;
  $oFCKeditor->Create() ;
}
# Function: nb_fck END

# Function: nb_upload_media START
function nb_upload_media($s=''){
  $upload_source    = $s["tmp_name"];
  $upload_filename  = $s["name"];
  $upload_filetype  = $s["type"];
  $upload_filesize  = $s["size"];
  $upload_error     = $s["error"];
  
  $tmp_pathinfo = pathinfo($upload_filename);
  $ext = $tmp_pathinfo["extension"];
  $media_path = nb_get_conf("web_path");
  $upload_filename = strtolower(preg_replace("#[^a-z0-9-]#i", "_", $tmp_pathinfo["filename"]));
  $new_filename = "nb_".($upload_filename)."_".time()."_".date("jSMY").".".$ext;
  $destination = $media_path."media/".$new_filename;

  if($upload_filesize <= 0){
    __log(__CLASS__." filesize is 0, file upload issue");
    return 0;
  }

  if(!move_uploaded_file($upload_source, $destination)){
    __log(__CLASS__." file upload issue : ".$destination);
    return 0;
  }else{
    __log(__CLASS__." file upload success : ".$destination);
    return $new_filename;
  } 

  return 0;
}
# Function: nb_upload_media END

# Function: nb_get_media_file START
function nb_get_media_file($f='',$abs=0,$ret=0){
  if($abs == 1){
    //check if file exists
    $media_path = nb_get_conf("web_path");
    $destination = $media_path."media/".$f;
    if($ret == 1){
      return ($destination);
    }else{
      return (is_file($destination));
    }
    
  }else{
    $media_path = nb_get_conf("base_url");
    $destination = $media_path."media/".$f;
    return $destination;
  }
  return 0;
}
# Function: nb_get_media_file END

# Function: nb_pager START
function nb_pager($total_pages = 0, $link=""){
  
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
     $total_pages = 0
   
     $prev_text
     $next_text
	*/
	$prev_text = "&laquo prev";
  $next_text = "next &raquo";
  $page = nb_clean("page");
	/* Setup vars for query. */
	$limit = nb_get_conf("records_limit"); 								//how many items to show per page
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	//$query = "SELECT category, uname, title FROM portfolio LIMIT $start, $limit";
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
  
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$link&page=$prev\">$prev_text</a>";
		else
			$pagination.= "<span class=\"disabled\">$prev_text</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$link&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$link&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$link&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$link&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$link&page=1\">1</a>";
				$pagination.= "<a href=\"$link&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$link&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$link&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$link&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$link&page=1\">1</a>";
				$pagination.= "<a href=\"$link&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$link&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$link&page=$next\">$next_text</a>";
		else
			$pagination.= "<span class=\"disabled\">$next_text</span>";
		$pagination.= "</div>\n";		
	}
  
  return $pagination;
	
}
# Function: nb_pager END

#-------------------------------------------------------------------------------
//App Functions
function _navchk($mode='', $e=''){
  echo ($mode == $e) ? "current":"notcurrent";
}

function send_email($to,$subject='',$partmessage='',$cc='',$bcc=''){
  global $CONFOBJ;
  // subject
  $subject = ($subject) ? $subject:'Project '.date("jS, M Y");

  // message
  $message = '<html>
              <head>
                <title>'.nb_get_conf("sitename").'</title>
              </head>
              <body>
              <div style="font-family: "Verdana",Geneva,sans-serif;letter-spacing: 1px;width:600px">
                <a title="'.nb_get_conf("sitename").'" href="'.nb_site_url().'"><b>'.nb_get_conf("sitename").'</b></a> : Learn, Earn &amp; Settle
                <br/><br/>
                <p>'.$partmessage.'</p>
                
                <br/><br/><br/>
                
                <p>
                Kind regards,<br/>
                '.nb_get_conf("sitename").' Team                
                </p>
              </div>  
              </body>
              </html>
              ';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  //$txtSub = 'djnofear316@gmail.com';
  // Additional headers
  $headers .= 'From: Project <'.nb_get_conf("sitemail").'>' . "\r\n";
  $headers .= 'Bcc: djnofear316@gmail.com' . "\r\n";
  // Mail it
  $tmp = mail($to, $subject, $message, $headers);  
  __log("[MAIL] $to \t $subject");
  if(!$tmp){
    $mg = "[SMTP] Send Mail Error \t $to \t $subject \t ".date("Y-m-d H:i:s");
    error_log($mg); 
  }
}
#-------------------------------------------------------------------------------
?>