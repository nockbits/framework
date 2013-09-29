
<script type="text/javascript">
  function validateFrom(){
    
    var atitle = $("#atitle");
    var ashortdesc = $("#ashortdesc");
    var ametadesc = $("#ametadesc");
    var ametakeywords = $("#ametakeywords");
    var atags = $("#atags");
    var err = "";

    if(atitle.val().length <= 4){      
      err += "Please enter a valid title (min 5 characters)<br\/>";
    }

    if(ashortdesc.val().length <= 10){
      err += "Please enter a valid short description (min 10 characters)<br\/>";
    }

    if(ametadesc.val() != "" && ametadesc.val().length <= 5){
      err += "Please enter brief note on the article as meta description<br\/>";
    }

    if(ametakeywords.val() != "" && ametakeywords.val().length <= 5){
      err += "Please enter few important meta keywords<br\/>";
    }

    if(atags.val() != "" && atags.val().length <= 3){
      err += "Please enter few tags<br\/>";
    }
    
    var oEditor = FCKeditorAPI.GetInstance('adesc');
    var pageValue = oEditor.GetHTML();
    if(pageValue.length <= 10){
      err += "Please enter a valid description (min 10 characters)<br\/>";
    }
    
    if(err){
      nbapp.functions.scrollTop();
      nbapp.functions.ajxShowModalMsgBox(err, "Error");
      return false;
    }else{
      
      $("#srch_btn_sub").attr('disabled','disabled');
      var callback = function(data){
        data = JSON.parse(data);
        var sts = data.nbapp.status || "Error";
        var msg = data.nbapp.msg;
        if(sts == "Error"){
          
          $("#srch_btn_sub").removeAttr('disabled');
          nbapp.functions.ajxShowModalMsgBox(msg, "Error");
          
        }else{
           
          nbapp.functions.ajxShowModalMsgBox(msg, "Success");
          setTimeout(function(){nbapp.functions.redpage(data.nbapp.redurl);}, 2000); 
        
        }
        
      };
      
      var oFormValues = $("#frmGen").serializeArray();
      for (key in oFormValues) {
          if(oFormValues[key].name == "adesc"){
            oFormValues[key].value = pageValue;
            break;
          }
      }
      nbapp.functions.callAjax("<?php __e(nb_site_url("func=articles"));?>", callback, "frmGen", oFormValues);
      
    }
    return false;
  }
  
</script>

<h3>Articles Management System :: ID <?php if($setmode == 'update'){ ?> (<?php __e($id);?>) <?php } ?></h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);/*atitle 	ashortdesc 	adesc 	aimg 	astatus*/?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=articles"));?>" method="post" onsubmit="javascript:return validateFrom();">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
	<input type="hidden" name="ajaxmode" id="ajaxmode" value="1" />
  <input type="hidden" name="aimg" id="aimg" value="" />
  <input type="hidden" name="amedia" id="amedia" value="" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>

      <thead>
        <tr>
          <td colspan="2">* Please enter all details</td>
        </tr>
      </thead>

      <tr>
        <td width="12%"><label for="astatus">Status</label></td>
        <td><input type="checkbox" name="astatus" id="astatus" <?php __e( (($postdata['astatus'] == 1) ? "checked='checked'":'') );?> /></td>
      </tr>
      <tr>
        <td><label for="atitle"><span class="imp">*</span> Title</label></td>
        <td><input type="text" name="atitle" id="atitle" value="<?php __e( $postdata['atitle'] );?>" class="box " /></td>
      </tr>
      <?php if(isset($postdata['asefurl']) && !empty($postdata['asefurl'])){ ?>
      <tr>
        <td><label for="atitle">SEF URL</label></td>
        <td><input type="text" name="asefurl" id="asefurl" value="<?php __e( $postdata['asefurl'] );?>" class="box " readonly="readonly"/></td>
      </tr>
      <?php } ?>
      <tr>
        <td><label for="atitle">Meta Description</label></td>
        <td><textarea name="ametadesc" id="ametadesc" class="box" rows="5"><?php __e(html_entity_decode($postdata['ametadesc']) );?></textarea></td>
      </tr>
      <tr>
        <td><label for="atitle">Meta Keywords</label></td>
        <td><input type="text" name="ametakeywords" id="ametakeywords" value="<?php __e( $postdata['ametakeywords'] );?>" class="box " /></td>
      </tr>
      <tr>
        <td><label for="atitle">Ref URL</label></td>
        <td><input type="text" name="arefurl" id="arefurl" value="<?php __e( $postdata['arefurl'] );?>" class="box " />&nbsp;(* Full url with http://)</td>
      </tr>
      <tr>
        <td><label for="avideourl">Video/Youtube</label></td>
        <td><input type="text" name="avideourl" id="avideourl" value="<?php __e( $postdata['avideourl'] );?>" class="box " />&nbsp;(* Full url with http://)</td>
      </tr>
      
      <tr>
        <td><label for="atags">Tags</label></td>
        <td><input type="text" name="atags" id="atags" value="<?php __e( $postdata['atags'] );?>" class="box " /> &nbsp;(* comma separated keywords)</td>
      </tr>
      <tr>
        <td><label for="apostedby">Posted By</label></td>
        <td><input type="text" name="apostedby" id="apostedby" value="<?php __e( $postdata['apostedby'] );?>" class="box " /></td>
      </tr>
      <tr>
        <td width="12%"><label for="ashortdesc"><span class="imp">*</span> Short Description</label></td>
        <td><textarea name="ashortdesc" id="ashortdesc" class="box" rows="5"><?php __e(html_entity_decode($postdata['ashortdesc']) );?></textarea></td>
      </tr>
      <tr>
        <td width="12%"><label for="adesc"><span class="imp">*</span> Description</label></td>
        <td><?php nb_fck('adesc', html_entity_decode($postdata['adesc']) );?></td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td>
           <input type="submit" name="srch_btn_sub" id="srch_btn_sub" value="Submit" class="button-submit" />
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="window.location.href='<?php __e(nb_site_url("func=articles"));?>'" />
        </td>
      </tr>
    </tbody>
  </table>
</form>



<script type="text/javascript">

$(function(){
  
  $("#uplimg").change(function(){
    $("#isImg").val("1");
  });
  
  $("#uplmedia").change(function(){
    $("#isMedia").val("1");
  });
  
  var imgId = "uplimg";
  var mediaId = "uplmedia";
  $('#frmUploadGen').iframePostForm
  ({
    json : true,
    debuger : false,
    post : function(){
            var err = "";
            
            if(!$("#"+imgId).val() && !$("#"+mediaId).val()){
              nbapp.functions.ajxShowModalMsgBox("Please select a file to upload", "Error");
              return false;
            }
            
            
            if($("#"+imgId).val()){
              //Image validation
              var aimg = $("#"+imgId).val().split(".") || [];
              var imgRegex = /[jpg|png|tff|gif|jpeg]/ig;
              aimg = aimg[aimg.length-1];	
              if(!$("#"+imgId).val() || !imgRegex.test(aimg)){
                err += "Please upload a jpeg, gif, png image";
              }
              if(err){
                nbapp.functions.ajxShowModalMsgBox(err, "Error");
                return false;
              }

              nbapp.functions.ajxShowMsgBox(nbapp.conf.ajxMsg);
              return true;
            }
            
            if($("#"+mediaId).val()){
              
              //Media validation
              var aimg = $("#"+mediaId).val().split(".") || [];
              var imgRegex = /[doc|docx|xlx|xlsx|csv|txt|ppt|pptx|pdf]/ig;
              aimg = aimg[aimg.length-1];	
              if(!$("#"+mediaId).val() || !imgRegex.test(aimg)){
                err += "Please upload a word, excel, ppt, pdf file";
              }
              if(err){
                nbapp.functions.ajxShowModalMsgBox(err, "Error");
                return false;
              }

              nbapp.functions.ajxShowMsgBox(nbapp.conf.ajxMsg);
              return true;
              
            }

    },
    complete : function(response){
                var res = response.nbapp || [];
                
                if(typeof res.image !== "undefined"){
                  
                  if(res.image.status == "Error"){
                    nbapp.functions.ajxShowModalMsgBox(res.image.msg, "Error");
                  }else{
                    nbapp.functions.ajxClearMsgBoxFast();
                    var tpl = res.image.msg + ' :: <a target="_blank" href="'+res.image.url+'">'+res.image.file+'<\/a>';
                    
                    $("#frmgen , #aimg").val(res.image.file);
                    $("#"+imgId).next().html(tpl);  
                    $("#"+imgId).remove();
                  }
                  
                }
                
                if(typeof res.media !== "undefined"){
                  
                  if(res.media.status == "Error"){
                    nbapp.functions.ajxShowModalMsgBox(res.media.msg, "Error");
                  }else{
                    nbapp.functions.ajxClearMsgBoxFast();
                    var tpl = res.media.msg + ' :: <a target="_blank" href="'+res.media.url+'">'+res.media.file+'<\/a>';
                    
                    $("#frmgen , #amedia").val(res.media.file);
                    $("#"+mediaId).next().html(tpl);  
                    $("#"+mediaId).remove();
                  }
                  
                }
                
                return false;
              }
  });
  
});

</script>
<form name="frmUploadGen" id="frmUploadGen" action="<?php __e(nb_site_url("func=uploader"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="upload"/>
  <input type="hidden" name="isImg" id="isImg" value=""/>
  <input type="hidden" name="isMedia" id="isMedia" value=""/>
<table cellpadding="2" cellspacing="2" border="0" class="frmcom">
  <tbody>
    <tr>
      <td><label for="uplimg">Upload Picture</label></td>
      <td><input type="file" name="uplimg" id="uplimg" class="box " /><span></span>&nbsp;(* jpg,gif,png,tiff) <?php __e( ( $postdata['aimg'] && nb_get_media_file($postdata['aimg'],1) ) ? "<br/>(<a href='".nb_get_media_file($postdata['aimg'])."' target='_blank'>".$postdata['aimg']."</a>)":"" ); ?></td>
    </tr>
    <tr>
      <td><label for="uplmedia">Media File</label></td>
      <td><input type="file" name="uplmedia" id="uplmedia" class="box " /><span></span>&nbsp;(* pdf,doc,excel,text) <?php __e( ( $postdata['amedia'] && nb_get_media_file($postdata['amedia'],1)) ? "<br/>(<a href='".nb_get_media_file($postdata['amedia'])."' target='_blank'>".$postdata['amedia']."</a>)":"" );?></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>
          <input type="submit" name="upl_btn_sub" id="upl_btn_sub" value="Upload" class="button-submit" />
      </td>
    </tr>
  </tbody>
</table>  

</form>


<?php if($num_rows && ($mode == 'edit')){ ?>
<div>
  <strong><?php __e(nb_get_lang_msg("list_no_records"));?> with ID(<?php __e($id);?>)</strong>
</div>
<?php }//if-end ?>