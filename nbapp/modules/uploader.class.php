<?php
if(!NBMASTERCHK) die("Sorry, you don't have access to this page");

/**
 * @class: uploader
 * @desc: uploader to the system 
 * @copyrihght: NB App 2012
 * @version: 1.0
 * @example:
 */
class uploader{

  var	$view_prefix = "uploader";
	var	$log_err = array();
  var	$log_msg = array();
	var $post_data = array();
  var $post_img_resize = array();
  var $ajax_mode = "";
	
	# Function: Constructor START #
	function uploader($params=array()){
		### DEFAULT VALUES - START 	###
    $this->post_img_resize = array("large" => 640, "medium" => 150, "small" => 100, "tiny" => 50);
    $this->ajax_mode = nb_clean("ajaxmode");
		### DEFAULT VALUES - END 	###
	}
	# Function: Constructor END #
	
	# Function: actions START #
	function actions(){
    $mode = nb_clean("mode");
		switch($mode){
      case 'upload':{	
				$this->_upload();	
				return 'upload';
				break;
			}
      
			default:{
        $data = $this->_default();        
        return 'default';
				break;
			}
		}
	}	
	# Function: actions END #
	
  # Function: _default START #
	function _default(){
    $tmp_ar = array();
    $tmp_ar[nb_get_conf("ajax_id")]["status"] = "Error";
    $tmp_ar[nb_get_conf("ajax_id")]["msg"] = "Sorry upload was unsuccessful, please check the upload parameters.";
    nb_json_output($tmp_ar);
    exit;
  }
  # Function: _default END #
  
  # Function: _upload START #
	function _upload(){
    $tmp_file_param = ("uplimg");
    $tmp_isimg = nb_clean("isImg");
    if($tmp_isimg == 1)
    {
      $err = "";
      $msg = "";
      if(!isset($_FILES[$tmp_file_param]['tmp_name']) || $_FILES[$tmp_file_param]['tmp_name'] == ""){
        $err = "Please upload a valid image file (jpeg, png, gif) and max 5MB size";
      } else{

        $upl_status_img = nb_upload_media($_FILES[$tmp_file_param],$this->post_img_resize);
          if($upl_status_img === 0){
            $err = "Some problem in uploading the file, please try again later";
          } else{
            $msg = "File uploaded successfully";
          }
      }

      $tmp_ar = array();
      $tmp_ar[nb_get_conf("ajax_id")]["image"]["status"] = ($err) ? "Error" : "Success";
      if($err){
        $tmp_ar[nb_get_conf("ajax_id")]["image"]["msg"] = $err;
      }else{
        $tmp_ar[nb_get_conf("ajax_id")]["image"]["msg"] = $msg;
        $tmp_ar[nb_get_conf("ajax_id")]["image"]["file"] = $upl_status_img;
        $tmp_ar[nb_get_conf("ajax_id")]["image"]["url"] = nb_get_media_file($upl_status_img, 0, 1);
      }
    }
    
    $tmp_file_param = ("uplmedia");
    $tmp_ismedia = nb_clean("isMedia");
    $err = "";
    $msg = "";
    if($tmp_ismedia == 1){
      
      if(!isset($_FILES[$tmp_file_param]['tmp_name']) || $_FILES[$tmp_file_param]['tmp_name'] == ""){
        $err = "Please upload a valid file (word, excel, pdf) and max 5MB size";
      } else{

        $upl_status_img = nb_upload_media($_FILES[$tmp_file_param]);
          if($upl_status_img === 0){
            $err = "Some problem in uploading the file, please try again later";
          } else{
            $msg = "File uploaded successfully";
          }
      }

      $tmp_ar[nb_get_conf("ajax_id")]["media"]["status"] = ($err) ? "Error" : "Success";
      if($err){
        $tmp_ar[nb_get_conf("ajax_id")]["media"]["msg"] = $err;
      }else{
        $tmp_ar[nb_get_conf("ajax_id")]["media"]["msg"] = $msg;
        $tmp_ar[nb_get_conf("ajax_id")]["media"]["file"] = $upl_status_img;
        $tmp_ar[nb_get_conf("ajax_id")]["media"]["url"] = nb_get_media_file($upl_status_img, 0, 1);
      }
      
    }
    
    nb_json_output($tmp_ar);
    exit;
  }
  # Function: _upload END #
  
	# Function: _delete START #
	function _delete(){
    $tmp_type = nb_clean("type");
    $tmp_filename = nb_clean("filename");
    
    $err = "";
    $msg = "";
    
    if(empty($tmp_type) || empty($tmp_filename)){
      $err = "The type and filename cannot be blank";
    }else{
      if($tmp_type == "image"){
        $tmp_img = nb_get_media_file($tmp_filename,1,1);
        $tmp_aimg = pathinfo($tmp_img);     
        if(nb_get_media_file($tmp_filename,1)){
          @unlink($tmp_img);
          __log(__LINE__. " \t [uploader] \t [UNLINK_IMG] \t $tmp_img");

          foreach($this->post_img_resize as $tmp_rez_key => $tmpval){
            $tmp_other_img_path = $tmp_aimg["dirname"]."/".$tmp_aimg["filename"]."_".$tmp_rez_key.".".$tmp_aimg["extension"];
            @unlink($tmp_other_img_path);
            __log(__LINE__. " \t [uploader] \t [UNLINK_IMG] \t $tmp_other_img_path");
          }
          
          $msg = "File deleted successfully";
        }else{
          $err = "No such file exits, please check the details";
        }
    
      }else if($tmp_type == "media"){
        $tmp_amedia = nb_get_media_file($tmp_filename,1,1);
        if(nb_get_media_file($tmp_filename,1)){
          @unlink($tmp_amedia);
          __log(__LINE__. " \t [uploader] \t [UNLINK_MEDIA] \t $tmp_amedia");
          $msg = "File deleted successfully";
        }else{
          $err = "No such file exits, please check the details";
        }
      }
      
    }
      
    $tmp_ar = array();
    $tmp_ar[nb_get_conf("ajax_id")]["status"] = ($err) ? "Error" : "Success";    
    $tmp_ar[nb_get_conf("ajax_id")]["file"] = $tmp_filename;
    if($err){
      $tmp_ar[nb_get_conf("ajax_id")]["msg"] = $err;
    }else{
      $tmp_ar[nb_get_conf("ajax_id")]["msg"] = $msg;
    }
    nb_json_output($tmp_ar);
    exit;
	}
	# Function: _delete END #
	
}
?>