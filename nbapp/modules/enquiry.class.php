<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: enquiry
 * @desc: enquiry's to the system 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class enquiry{

  var	$view_prefix = "enquiry";
	var	$log_err = array();
  var	$log_msg = array();
	var $post_data = array();
	
	# Function: Constructor START #
	function enquiry($params=array()){
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
      case 'preview':
			{	
				$this->_preview();	
				return 'preview';
				break;
			}
			case 'list':
			default:
			{
        $data = $this->_list();        
        return 'list';
				break;
			}
		}
	}	
	# Function: actions END #
	
	# Function: _list START #
	function _list(){
    $db = nb_get_conf("db");
    $tmp_where = " enstatus IN (1,0) ";
        
    $tmp_total_pages = $db->allrecordscnt("tbl_enquiry",$tmp_where,"id");
    $tmp_pager = nb_pager($tmp_total_pages,"index.php?func=enquiry&mode=list");
    
     $page = nb_clean("page");
    /* Setup vars for query. */
    $limit = nb_get_conf("records_limit");                           //how many items to show per page
    if($page) 
      $start = ($page - 1) * $limit; 			//first item to display on this page
    else
      $start = 0;                         //if no page var is given, set start to 0
    
    $db->limit_str = " LIMIT $start , $limit ";
    $db->orderby_str = " order by id desc ";
    $tmp_data = $db->allrecords("tbl_enquiry",$tmp_where);
    $data['postdata'] = $tmp_data["allrows"];
    $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    $data['extravars']["total_pages"] = $tmp_total_pages;
    $data['extravars']["pager"] = $tmp_pager;
		$this->_display($this->view_prefix."_list",$data);
	}
	# Function: list END #
	
	# Function: _add START #
	function _add(){
    $data['extravars']['setmode'] = "insert";
    
    $update_arr = array();
    $update_arr['enstatus']    = nb_clean("enstatus");
    $update_arr['atitle']     = nb_clean("atitle");
    $update_arr['ashortdesc'] = nb_clean("ashortdesc");
    $update_arr['adesc']      = nb_clean("adesc");   
    $update_arr['ametadesc']      = nb_clean("ametadesc");   
    $update_arr['ametakeywords']  = nb_clean("ametakeywords");   
    $sefurl = $this->_sef_url($update_arr['atitle']);
    $update_arr['asefurl']      = $sefurl;   
    $data['postdata'] = $update_arr;
    
    $this->_display($this->view_prefix."_add",$data);
	}
	# Function: _add END #
	
	# Function: _edit START #
	function _edit(){    
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_enquiry where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $data['postdata'] = $tmp_data["allrows"][0];
    }
    $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    $data['extravars']["id"] = $id;
    $data['extravars']['setmode'] = "update";
		$this->_display($this->view_prefix."_add",$data);
	}
	# Function: _edit END #

	# Function: _insert START #
	function _insert(){
    
    $chk  = $this->_validate();    
    if($chk == 0){
      $this->_add();
    }else{
      $this->log_err = array();
      if($_FILES["amedia"]['tmp_name'] != ''){
        $upl_status_media = nb_upload_media($_FILES["amedia"]);
        if($upl_status_media === 0){
          $this->log_err[] = 'Please upload a valid media file (pdf, doc, excel) and max 5MB size';
          $this->_add();
          return "add";
        }
      }

      if($_FILES["aimg"]['tmp_name'] != ''){
        $upl_status_img = nb_upload_media($_FILES["aimg"]);
        if($upl_status_img === 0){
          $this->log_err[] = 'Please upload a valid image file (jpeg, png, gif) and max 5MB size';
          $this->_add();
          return "add";
        }
      }
      
      $db         = nb_get_conf("db");   
      $update_arr = array();
      $update_arr['enstatus']    = (nb_clean("enstatus")) ? 1:0;
      $update_arr['atitle']     = nb_clean("atitle");
      $update_arr['ashortdesc'] = nb_clean("ashortdesc");
      $update_arr['adesc']      = nb_clean("adesc");   
      $update_arr['ametadesc']      = nb_clean("ametadesc");   
      $update_arr['ametakeywords']  = nb_clean("ametakeywords");
    
      $sefurl = $this->_sef_url($update_arr['atitle']);
      $update_arr['asefurl']      = $sefurl;   
      
      if($upl_status_media)
        $update_arr['amedia']     = $upl_status_media;
      
      if($upl_status_img)
        $update_arr['aimg']       = $upl_status_img;
      
      $sql_ins_val = $db->_bulk_insert(array($update_arr));
      $qry = "INSERT INTO tbl_enquiry $sql_ins_val";
      $id = $db->insert($qry,1);
      nb_redirect("func=enquiry");    
    }
	}
	# Function: _insert END #

	# Function: _update START #
	function _update(){
    
    $chk  = $this->_validate();    
    if($chk == 0){
      $this->_edit();
    }else{
      $id = (int) nb_clean("id");
      $this->log_err = array();
      if($_FILES["amedia"]['tmp_name'] != ''){
        $upl_status_media = nb_upload_media($_FILES["amedia"]);
        if($upl_status_media === 0){
          $this->log_err[] = 'Please upload a valid media file (pdf, doc, excel)';
          $this->_edit();
        }
      }
      
      if($_FILES["aimg"]['tmp_name'] != ''){
        $upl_status_img = nb_upload_media($_FILES["aimg"]);
        if($upl_status_img === 0){
          $this->log_err[] = 'Please upload a valid image file (jpeg, png, gif)';
          $this->_edit();
        }
      }

      $db         = nb_get_conf("db");   
      $update_arr = array();
      $update_arr['enstatus']    = (nb_clean("enstatus")) ? 1:0;
      $update_arr['atitle']     = nb_clean("atitle");
      $update_arr['ashortdesc'] = nb_clean("ashortdesc");
      $update_arr['adesc']      = nb_clean("adesc");    
      $update_arr['ametadesc']      = nb_clean("ametadesc");   
      $update_arr['ametakeywords']  = nb_clean("ametakeywords");
      $sefurl = $this->_sef_url($update_arr['atitle']);
      $update_arr['asefurl']    = $sefurl;
      if($upl_status_media)
        $update_arr['amedia']     = $upl_status_media;
      
      if($upl_status_img)
        $update_arr['aimg']       = $upl_status_img;

      $sql_upd_val = $db->_set_val($update_arr);
      $qry = "UPDATE tbl_enquiry SET $sql_upd_val WHERE id = $id";
      $db->query($qry,1);

      $this->log_msg[] = 'Record updated successfully';
      $this->_edit();
    }
	}
	# Function: _update END #
	
	# Function: _delete START #
	function _delete(){
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_enquiry where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      
      $sql = "UPDATE tbl_enquiry SET enstatus=-1 WHERE id = $id";
      $tmp_data= $db->query($sql,1);
      
      $this->log_msg[] = 'Record deleted successfully';
    }
    else{
      $this->log_err[] = 'Sorry the record does not exists, please try again';
    }
		$this->_list();    
	}
	# Function: _delete END #
	
  # Function: _edit START #
	function _preview(){    
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_enquiry where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $data['postdata'] = $tmp_data["allrows"][0];
      $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    }else{
      $this->log_err[] = 'Sorry the record does not exists, please try again';
    }
    $data['extravars']["id"] = $id;
    $data['extravars']['setmode'] = "preview";
		$this->_display($this->view_prefix."_preview",$data);
	}
	# Function: _edit END #
  //
	# Function: _validate START #
	function _validate(){
		$atitle     = nb_clean("atitle");
    $ashortdesc = nb_clean("ashortdesc");
    $adesc      = nb_clean("adesc"); 
    
    if(strlen($atitle) < 3){
      $this->log_err[] = 'Please enter a valid title';
    }
    if(strlen($ashortdesc) < 6){
      $this->log_err[] = 'Please enter a valid short description';
    }
    if(strlen($adesc) < 10){
      $this->log_err[] = 'Please enter a valid description';
    }
    
    if(count($this->log_err) > 0){
      return 0;
    }else{
      return 1;
    }
	}
	# Function: _validate END #
	
  # Function: _display START #
	function _display($view,$data=array(),$ajax=0){
    $data['err'] = $this->log_err;
    $data['msg'] = $this->log_msg;
    $data['mode'] = nb_clean("mode");
		nb_admin_display($view,$data,$ajax);		
	}
	# Function: _display END #
}
?>