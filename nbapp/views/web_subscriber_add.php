<script type="text/javascript">
$(function ()
{
	$('#frmGen').iframePostForm
	({
		json : true,
		post : function ()
		{
			var subname = $("#subname");
			var subemail = $("#subemail");
			var err = "";

			if(subname.val().length <= 2){      
				err += "Please enter a valid name (min 3 characters)<br\/>";
			}
			if(subemail.val().length <= 6 || subemail.val().indexOf("@") == -1){
				err += "Please enter a valid email id<br\/>";
			}

			if(err){
				nbapp.functions.scrollTop();
				nbapp.functions.ajxShowModalMsgBox(err, "Error");
				return false;
			}
			$("#srch_btn_sub").attr("disabled","disabled")
			nbapp.functions.ajxShowMsgBox(nbapp.conf.ajxMsg);
			return true;
			

		},
		complete : function (response)
		{
			nbapp.functions.scrollTop();
			var res = response.nbapp || [];
			if(res.status == "Error"){
				nbapp.functions.ajxShowModalMsgBox(res.msg, "Error");
			}else{
				nbapp.functions.ajxShowModalMsgBox(res.msg, "Success");
        setTimeout(function(){
					nbapp.functions.redpage(res.redurl);
				}, 4000);	
			}

			return false;
		}
	});
});
</script>

<h3>Subscriber Management System :: ID <?php if($setmode == 'update'){ ?> (<?php __e($id);?>) <?php } ?></h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);/*atitle 	ashortdesc 	adesc 	aimg 	astatus*/?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=subscriber"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>

      <thead>
        <tr>
          <td colspan="2">* Please enter all details</td>
        </tr>
      </thead>

      <tr>
        <td width="12%"><label for="substatus">Status</label></td>
        <td><input type="checkbox" name="substatus" id="substatus" <?php __e( (($postdata['substatus'] == 1) ? "checked='checked'":'') );?> /></td>
      </tr>
      <tr>
        <td><label for="subcat"><span class="imp">*</span> Category</label></td>
        <td>
          <select name="subcat" id="subcat" class="box">
            <?php foreach($subscriber_category as $sub_cat_id => $sub_cat_name){ ?>
            ` <option value="<?php __e($sub_cat_id);?>" <?php __e( (($postdata['subcat'] == $sub_cat_id) ? "selected='selected'":'') );?>><?php __e($sub_cat_name);?></option>
            <?php } ?>            
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="subname"><span class="imp">*</span> Name</label></td>
        <td><input type="text" name="subname" id="subname" value="<?php __e( $postdata['subname'] );?>" class="box " /></td>
      </tr>
      <tr>
        <td><label for="subemail"><span class="imp">*</span> Email</label></td>
        <td><input type="text" name="subemail" id="subemail" value="<?php __e( $postdata['subemail'] );?>" class="box " /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
           <input type="submit" name="srch_btn_sub" id="srch_btn_sub" value="Submit" class="button-submit" onclick="" />
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="window.location.href='<?php __e(nb_site_url("func=subscriber"));?>'" />
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