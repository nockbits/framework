<?php
#Include config file
session_start();
include_once("includes/config.inc.php");
//$NBCONFIG->simple_cache->setCacheTemplate("austintpl","sdkjsdhjkshkjshd");

$tmp_params = nb_get_all_params();
$do_action = (isset($tmp_params['func']) && $tmp_params['func']) ? $tmp_params['func']:"home";
$web_path = nb_get_conf("web_path");
$viewfile_content = '';
$ADD_INCL_FILE = '';

$DEF_META_DESC = nb_get_conf("sitename")." - Learn, Earn and Settle in Canada. Guidance and step-by-step process for selecting the best university, college or other schools in Canada for a perfect career option and for a greater future.";
$DEF_META_KEYWORDS = "Study in Canada, Study Abroad, Career Guidance, Guidance and Counseling, Counselor, Canadian schools, Canadian College, Postgraduate in Canada, Immigrate to Canada, Study Permits, IELTS";

switch($do_action){
  
  case "sitemap":
  { 
    $ADD_KEYWORDS = "Sitemap";
    $ADD_INCL_FILE = $web_path."includes/sitemap.form.inc.php";
    $id = "sitemap";
    $db = nb_get_conf("db");    
    $sql = "SELECT atitle,ashortdesc,adesc,aimg,amedia, ametadesc, ametakeywords FROM tbl_articles where asefurl = '$id' and  astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $viewfile_content = html_entity_decode($tmp_postdata["adesc"]);
      $DEF_META_DESC = html_entity_decode($tmp_postdata["ametadesc"]);
      $DEF_META_KEYWORDS = html_entity_decode($tmp_postdata["ametakeywords"]);
    }
    
    $tmp_sitemap_postdata = array();
    $sql = "SELECT atitle,ashortdesc,asefurl FROM tbl_articles where asefurl != '$id' and asefurl != 'welcome-to-vizionline' and asefurl != 'thank-you' and astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_sitemap_postdata = $tmp_data["allrows"];
    }
    break;
  }
  
  case "contact-vizionline":
  { 
    $ADD_KEYWORDS = "Contact VizionLine";
    $ADD_INCL_FILE = $web_path."includes/contact.form.inc.php";
    
    #---------------------------------------------------------------------
    $err_msg = '';
    $contact_us_flag = 0;
    if($_POST['btnSub']){
      $ses_ts = $_SESSION['st'];

      $txtFName     = nb_clean('txtFName'); 
      $txtEmail     = nb_clean('txtEmail'); 
      $txtTel       = nb_clean('txtTel'); 
      $txtCity      = nb_clean('txtCity'); 
      $txtState     = nb_clean('txtState'); 
      $txtLName     = nb_clean('txtLName'); 
      $txtMobile    = nb_clean('txtMobile'); 
      $txtAddr      = nb_clean('txtAddr'); 
      $txtPostcode  = nb_clean('txtPostcode'); 
      $txtCountry   = nb_clean('txtCountry'); 
      $txtEduSsc    = nb_clean('txtEduSsc'); 
      $txtEduSscYrt = nb_clean('txtEduSscYr'); 
      $txtEduGradFld  = nb_clean('txtEduGradFld'); 
      $txtEduOtherFld = nb_clean('txtEduOtherFld'); 
      $txtEduHsc      = nb_clean('txtEduHsc'); 
      $txtEduHscYr    = nb_clean('txtEduHscYr'); 
      $txtEduGrad     = nb_clean('txtEduGrad'); 
      $txtEduGradYr   = nb_clean('txtEduGradYr'); 
      $txtEduOther    = nb_clean('txtEduOther'); 
      $txtEduOtherYr  = nb_clean('txtEduOtherYr'); 
      $selCategory    = nb_clean('selCategory'); 
      $selGenExamt    = nb_clean('selGenExam'); 
      $txtExperience  = nb_clean('txtExperience'); 
      $selHeardAbt    = nb_clean('selHeardAbt'); 
      $txtComment     = nb_clean('txtComment'); 
      $txtCrInt       = nb_clean('txtCrInt');
      $sub_post_dt = $_POST;
      unset($sub_post_dt['ct']);
      unset($sub_post_dt['cm']);
      unset($sub_post_dt['mode']);
      unset($sub_post_dt['btnSub']);
      $ct = nb_clean('ct');
      if($ct != $ses_ts){
        $err_msg = "&raquo; Please re-enter your details.";
      }else{
        if(empty ($txtFName) || strlen($txtFName) < 2){
          $err_msg .= "&raquo; Please enter valid first name.<br/>";
        }
        if(empty ($txtEmail) || strlen($txtEmail) < 5){
          $err_msg .= "&raquo; Please enter valid email id.<br/>";
        }
        if(empty ($txtMobile) || strlen($txtMobile) < 7){
          $err_msg .= "&raquo; Please enter valid mobile no.<br/>";
        }

        if($err_msg){
          $err_msg = substr($err_msg, 0, -5);      
        }else{
                    
          $message = "Hello Candidate,<br/><br/>
                      Welcome to ".nb_get_conf("sitename").", one of our representatives will get back to you shortly.<br/><br/>
                      In the mean while please visit our website for new updates: <a href='".  nb_site_url()."'>".nb_site_url()."</a>";
          send_email($txtEmail,"Welcome to ".nb_get_conf("sitename"), $message);
          
          $message = "Hello Admin,<br/><br/>
                      A new candidate has submitted a request, Please check:<br/><br/>
                      ";

          $message .= "<ol>";
          foreach ($sub_post_dt as $key => $value) {
            $message .= "<li>".strtoupper($key) . " => ". nb_clean($key) . "</li>" ;
          }
          $message .= "</ol>";
          
          #insert in DB
          $db = nb_get_conf("db");   
          $update_arr = array();
          $update_arr['cto']        = $txtEmail;
          $update_arr['csubject']   = "Contact Us - Admin ".nb_get_conf("sitename");   
          $update_arr['cmailbody']  = htmlentities($message);
          $update_arr['created']    = date("Y-m-d H:i:s");
          $update_arr['cstatus ']   = 1;
          $sql_ins_val = $db->_bulk_insert(array($update_arr));
          $qry = "INSERT INTO tbl_contacts $sql_ins_val";
          $last_id = $db->insert($qry,1);
          
          
          send_email(nb_get_conf("sitemail"),"Contact Us - Admin ".nb_get_conf("sitename"). " - ".$last_id, $message);
                    
          $contact_us_flag = 1;
          $url = "thank-you";
          header("Location:".$url);die(0);
        }
      }
    }

    $ts = (rand() * time());
    $_SESSION['st'] = $ts;
    #---------------------------------------------------------------------
    $id = "contact-vizionline";
    $db = nb_get_conf("db");    
    $sql = "SELECT atitle,ashortdesc,adesc,aimg,amedia, ametadesc, ametakeywords FROM tbl_articles where asefurl = '$id' and  astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $viewfile_content = html_entity_decode($tmp_postdata["adesc"]);
      $DEF_META_DESC = html_entity_decode($tmp_postdata["ametadesc"]);
      $DEF_META_KEYWORDS = html_entity_decode($tmp_postdata["ametakeywords"]);
    }
    break;
  }
  
  case "thank-you":
  { 
    $ADD_KEYWORDS = "Contact VizionLine";
    $id = "thank-you";
    $db = nb_get_conf("db");    
    $sql = "SELECT atitle,ashortdesc,adesc,aimg,amedia, ametadesc, ametakeywords FROM tbl_articles where asefurl = '$id' and  astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $viewfile_content = html_entity_decode($tmp_postdata["adesc"]);
      $DEF_META_DESC = html_entity_decode($tmp_postdata["ametadesc"]);
      $DEF_META_KEYWORDS = html_entity_decode($tmp_postdata["ametakeywords"]);
    }
    break;
  }
  
  case "about-vizionline":
  { 
    $ADD_KEYWORDS = "About VizionLine";
    $id = "about-vizionline";
    $db = nb_get_conf("db");    
    $sql = "SELECT atitle,ashortdesc,adesc,aimg,amedia, ametadesc, ametakeywords FROM tbl_articles where asefurl = '$id' and  astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $viewfile_content = html_entity_decode($tmp_postdata["adesc"]);
      $DEF_META_DESC = html_entity_decode($tmp_postdata["ametadesc"]);
      $DEF_META_KEYWORDS = html_entity_decode($tmp_postdata["ametakeywords"]);
    }
    break;
  }
  
  case "home":
  default:
  { 
    $ADD_KEYWORDS = "International Education";
    $id = "welcome-to-vizionline";
    $db = nb_get_conf("db");    
    $sql = "SELECT atitle,ashortdesc,adesc,aimg,amedia, ametadesc, ametakeywords FROM tbl_articles where asefurl = '$id' and  astatus  = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $viewfile_content = html_entity_decode($tmp_postdata["adesc"]);
      $DEF_META_DESC = html_entity_decode($tmp_postdata["ametadesc"]);
      $DEF_META_KEYWORDS = html_entity_decode($tmp_postdata["ametakeywords"]);
    }
    break;
  }
}

include_once($web_path."views/web_header.php");
include_once($web_path."includes/content.inc.php");
include_once($web_path."views/web_footer.php");
?>
