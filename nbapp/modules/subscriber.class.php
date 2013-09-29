<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: subscriber
 * @desc: subscriber users in the system 
 * @copyrihght: NB App 2013
 * @version: 1.0
 * @example:
 */
class subscriber{

  var	$view_prefix = "subscriber";
	var	$log_err = array();
  var	$log_msg = array();
	var $post_data = array();
  var $subscriber_category = array();
  var $post_img_resize = array();
  var $ajax_mode = "";
	
	# Function: Constructor START #
	function subscriber($params=array()){
		### DEFAULT VALUES - START 	###
    $this->post_img_resize = array();
    $this->ajax_mode = nb_clean("ajaxmode");
    $this->subscriber_category = array(1=>"Default",2=>"Newsletter");
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
			case 'bulkimport':
			{
				$this->_bulk_import();
				return 'bulkimport';
				break;
			}
			case 'bulkimportinsert':
			{
				$this->_bulk_import_insert();
				return 'bulkimportinsert';
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
    $tmp_where = " substatus IN (1,0) ";
        
    $tmp_total_pages = $db->allrecordscnt("tbl_subscriber",$tmp_where,"id");
    $tmp_pager = nb_pager($tmp_total_pages,"index.php?func=subscriber&mode=list");
    
     $page = nb_clean("page");
    /* Setup vars for query. */
    $limit = nb_get_conf("records_limit");                           //how many items to show per page
    if($page) 
      $start = ($page - 1) * $limit; 			//first item to display on this page
    else
      $start = 0;                         //if no page var is given, set start to 0
    
    $db->limit_str = " LIMIT $start , $limit ";
    $tmp_data = $db->allrecords("tbl_subscriber",$tmp_where);
    $data['postdata'] = $tmp_data["allrows"];
    $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    $data['extravars']["total_pages"] = $tmp_total_pages;
    $data['extravars']["pager"] = $tmp_pager;
    $data['extravars']["subscriber_category"] = $this->subscriber_category;
    
		$this->_display($this->view_prefix."_list",$data);
	}
	# Function: list END #
	
	# Function: _add START #
	function _add(){
    $data['extravars']['setmode'] = "insert";
    $data['extravars']["subscriber_category"] = $this->subscriber_category;
    
    $update_arr = array();
    $update_arr['substatus']    = (nb_clean("substatus")) ? 1:0;
    $update_arr['subcat']     = nb_clean("subcat");
    $update_arr['subname'] = nb_clean("subname");
    $update_arr['subemail']      = nb_clean("subemail");   
    $data['postdata'] = $update_arr;
    
    $this->_display($this->view_prefix."_add",$data);
	}
	# Function: _add END #
	
	# Function: _edit START #
	function _edit(){    
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_subscriber where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $data['postdata'] = $tmp_data["allrows"][0];
    }
    $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    $data['extravars']["id"] = $id;
    $data['extravars']['setmode'] = "update";
    $data['extravars']["subscriber_category"] = $this->subscriber_category;
    
		$this->_display($this->view_prefix."_add",$data);
	}
	# Function: _edit END #

	# Function: _insert START #
	function _insert(){
    $tmp_ar = array();
    $chk  = $this->_validate();    
    if($chk == 0){
      $tmp_ar = array();
			$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Error";
			$tmp_ar[nb_get_conf("ajax_id")]["msg"] = implode("<br>",$this->log_err);
			nb_json_output($tmp_ar);
			exit;
    }else{
      $db         = nb_get_conf("db");   
      $update_arr = array();
      $update_arr['substatus']    = (nb_clean("substatus")) ? 1:0;
      $update_arr['subcat']     = nb_clean("subcat");
      $update_arr['subname'] = nb_clean("subname");
      $update_arr['subemail']      = nb_clean("subemail");  
      
      $sql_ins_val = $db->_bulk_insert(array($update_arr));
      $qry = "INSERT INTO tbl_subscriber $sql_ins_val";
      $id = $db->insert($qry,1);
      //nb_redirect("func=subscriber");    
			$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Success";
			$tmp_ar[nb_get_conf("ajax_id")]["msg"] = 'Contratulations, the subscriber has been added successfully.';
			$tmp_ar[nb_get_conf("ajax_id")]["redurl"] = nb_site_url("func=subscriber");
			nb_json_output($tmp_ar);
			exit;
    }
	}
	# Function: _insert END #

	# Function: _update START #
	function _update(){
    
		$tmp_ar = array();
    $chk  = $this->_validate();    
    if($chk == 0){
      $tmp_ar = array();
			$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Error";
			$tmp_ar[nb_get_conf("ajax_id")]["msg"] = implode("<br>",$this->log_err);
			nb_json_output($tmp_ar);
			exit;
    }else{
      $id = (int) nb_clean("id");
      $db         = nb_get_conf("db");   
      $update_arr = array();
      $update_arr['substatus']    = (nb_clean("substatus")) ? 1:0;
      $update_arr['subcat']     = nb_clean("subcat");
      $update_arr['subname'] = nb_clean("subname");
      $update_arr['subemail']      = nb_clean("subemail");  

      $sql_upd_val = $db->_set_val($update_arr);
      $qry = "UPDATE tbl_subscriber SET $sql_upd_val WHERE id = $id";
      $db->query($qry,1);

			$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Success";
			$tmp_ar[nb_get_conf("ajax_id")]["msg"] = 'Record updated successfully';
			$tmp_ar[nb_get_conf("ajax_id")]["redurl"] = nb_site_url("func=subscriber");
			nb_json_output($tmp_ar);
			exit;
    }
	}
	# Function: _update END #
	
	# Function: _delete START #
	function _delete(){
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_subscriber where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
      $sql = "UPDATE tbl_subscriber SET substatus=-1 WHERE id = $id";
      $tmp_data= $db->query($sql,1);
      
      $this->log_msg[] = 'Record deleted successfully';
    }
    else{
      $this->log_err[] = 'Sorry the record does not exists, please try again';
    }
		$this->_list();    
	}
	# Function: _delete END #
	
  # Function: _preview START #
	function _preview(){    
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_subscriber where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $data['postdata'] = $tmp_data["allrows"][0];
      $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    }else{
      $this->log_err[] = 'Sorry the record does not exists, please try again';
    }
    $data['extravars']["id"] = $id;
    $data['extravars']['setmode'] = "preview";
    $data['extravars']["subscriber_category"] = $this->subscriber_category;
		$this->_display($this->view_prefix."_preview",$data);
	}
	# Function: _preview END #

	# Function: _bulk_import START #
	function _bulk_import(){
    $data['extravars']['setmode'] = "bulkimportinsert";
    $data['extravars']["subscriber_category"] = $this->subscriber_category;
    
    $update_arr = array();
    $data['postdata'] = $update_arr;
    
    $this->_display($this->view_prefix."_bulk_import",$data);
	}
	# Function: _bulk_import END #


	# Function: _bulk_import_insert START #
	function _bulk_import_insert(){
    
		$subcat = (int) nb_clean("subcat");
		
		if($_FILES["subimport"]['tmp_name'] != ''){
			$upl_status_media = nb_upload_media($_FILES["subimport"]);
			if($upl_status_media === 0){
				$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Error";
				$tmp_ar[nb_get_conf("ajax_id")]["msg"] = 'Please upload a valid media file CSV file and max 5MB size';
				nb_json_output($tmp_ar);
				exit;
			}else{
				$tmp_upload = nb_get_media_file($upl_status_media,1,1);
				$err = 0;
				$row = 1;
				$succ_add = array();
				$db = nb_get_conf("db");   

				if (($handle = fopen($tmp_upload, "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
								
								//check in first row no.of fields
								$num = count($data);
								if($row == 1 && $num < 3){
									$err = 1;
									break;
								}

								//skip first row
								if($row > 1){
									$name = (isset($data[0])) ? $data[0]:'';
									$email = (isset($data[1])) ? $data[1]:'';
									
									//add if email and name is present
									if($name && $email){
										$update_arr = array();
										$update_arr['substatus']    = 1;
										$update_arr['subcat']				= nb_clean("subcat");
										$update_arr['subname']			= $name;
										$update_arr['subemail']     = $email;  
										
										$sql_ins_val = $db->_bulk_insert(array($update_arr));
										$qry = "INSERT INTO tbl_subscriber $sql_ins_val";
										$id = $db->insert($qry,1);
										$succ_add[] = $id;	
									}
								}

								$row++;
						}
						fclose($handle);
				}

				$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Success";
				$tmp_ar[nb_get_conf("ajax_id")]["msg"] = count($succ_add).' subscribers imported successfully';
				$tmp_ar[nb_get_conf("ajax_id")]["upload"] = $upl_status_media;
				$tmp_ar[nb_get_conf("ajax_id")]["subadded"] = count($succ_add);
				$tmp_ar[nb_get_conf("ajax_id")]["redurl"] = nb_site_url("func=subscriber");
				nb_json_output($tmp_ar);
				exit;
			}
		}else{
			$tmp_ar[nb_get_conf("ajax_id")]["status"] = "Error";
			$tmp_ar[nb_get_conf("ajax_id")]["msg"] = 'Please upload a valid csv file';
			$tmp_ar[nb_get_conf("ajax_id")]["redurl"] = nb_site_url("func=subscriber");
			nb_json_output($tmp_ar);
			exit;
		}

    
	}
	# Function: _bulk_import_insert END #

  //
	# Function: _validate START #
	function _validate(){
		$subname     = nb_clean("subname");
    $subemail = nb_clean("subemail");
    
    if(strlen($subname) < 3){
      $this->log_err[] = 'Please enter a valid name';
    }
    if(strlen($subemail) < 6){
      $this->log_err[] = 'Please enter a valid email id';
    }
    
    if(count($this->log_err) > 0){
      return 0;
    }else{
      return 1;
    }
	}
	# Function: _validate END #
	
  //
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