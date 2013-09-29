<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: gallery
 * @desc: gallery images in the system 
 * @copyrihght: NB App 2013
 * @version: 1.0
 * @example:
 */
class gallery{

  var	$view_prefix = "gallery";
	var	$log_err = array();
  var	$log_msg = array();
	var $post_data = array();
  var $gallery_category = array();
  var $post_img_resize = array();
  var $ajax_mode = "";
	
	# Function: Constructor START #
	function gallery($params=array()){
		### DEFAULT VALUES - START 	###
    $this->post_img_resize = array();
    $this->ajax_mode = nb_clean("ajaxmode");
		$this->post_img_resize = array("large" => 640, "medium" => 150, "small" => 100, "tiny" => 50);

		$db = nb_get_conf("db");    
    $sql = "SELECT id, albtitle FROM tbl_gallery_album where albstatus = 1";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      foreach($tmp_data["allrows"] as $v){
				$this->gallery_category[$v["id"]]	= $v["albtitle"];	
			}
    }
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
			case 'insert':
			{	
				$this->_insert();	
				return 'insert';
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
    $tmp_where = " gstatus IN (1,0) ";
        
    $tmp_total_pages = $db->allrecordscnt("tbl_gallery",$tmp_where,"id");
    $tmp_pager = nb_pager($tmp_total_pages,"index.php?func=gallery&mode=list");
    
     $page = nb_clean("page");
    /* Setup vars for query. */
    $limit = nb_get_conf("records_limit");                           //how many items to show per page
    if($page) 
      $start = ($page - 1) * $limit; 			//first item to display on this page
    else
      $start = 0;                         //if no page var is given, set start to 0
    
    $db->limit_str = " LIMIT $start , $limit ";
    $tmp_data = $db->allrecords("tbl_gallery",$tmp_where);
		
    $data['postdata'] = $tmp_data["allrows"];
    $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    $data['extravars']["total_pages"] = $tmp_total_pages;
    $data['extravars']["pager"] = $tmp_pager;
    $data['extravars']['albums'] = $this->gallery_category;
    
		$this->_display($this->view_prefix."_list",$data);
	}
	# Function: list END #
	
	# Function: _add START #
	function _add(){
		$id = (int) nb_clean("id");
    
		$data['extravars']['albums'] = $this->gallery_category;
    $data['extravars']['setmode'] = "insert";
    
    $update_arr = array();
    $update_arr['albums'] =  nb_clean("subemail");   
    $data['postdata'] = $update_arr;
    
    $this->_display($this->view_prefix."_add",$data);
	}
	# Function: _add END #
	
	# Function: _delete START #
	function _delete(){
    $id = (int) nb_clean("id");
    $db = nb_get_conf("db");    
    $sql = "SELECT * FROM tbl_gallery where id = $id";
    $tmp_data= $db->query($sql);
		if($tmp_data['num_rows'] > 0){
      $tmp_postdata = $tmp_data["allrows"][0];
			
			//delete old images
			$tmp_img_info = pathinfo($tmp_postdata["gimg"]);
			
			foreach($this->post_img_resize as $key => $v){
				$tmp_gimg = $tmp_img_info["filename"] . "_" . $key . "." . $tmp_img_info["extension"];
				$tmp_file = nb_get_media_file( $tmp_gimg, 1, 1 );
				if(is_file($tmp_file)){
					@unlink($tmp_file);
				}
			}

			//maintain the old file
			$tmp_file = nb_get_media_file( $tmp_img_info, 1, 1 );
			//@unlink($tmp_file);

      $sql = "UPDATE tbl_gallery SET gstatus=-1 WHERE id = $id";
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
    $sql = "SELECT * FROM tbl_gallery where id = $id";
    $tmp_data= $db->query($sql);
    if($tmp_data['num_rows'] > 0){
      $data['postdata'] = $tmp_data["allrows"][0];
      $data['extravars']["num_rows"] = $tmp_data["num_rows"];
    }else{
      $this->log_err[] = 'Sorry the record does not exists, please try again';
    }
    $data['extravars']["id"] = $id;
    $data['extravars']['setmode'] = "preview";
    $data['extravars']["albums"] = $this->gallery_category;
		$this->_display($this->view_prefix."_preview",$data);
	}
	# Function: _preview END #

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