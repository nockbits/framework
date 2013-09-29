<script type="text/javascript">
$(function ()
{
	$('#frmGen').iframePostForm
	({
		json : true,
		debuger : true,
		post : function ()
		{
			var err = "";

			//Media validation
			var amedia = $("#subimport").val().split(".") || [];
			console.log("[ amedia ] -> ",amedia);
			var mediaRegex = /[csv]/ig;
			amedia = amedia[amedia.length-1];	
			if(!$("#subimport").val()){
				err += "Please upload a csv file";
			}
			else if(!mediaRegex.test(amedia)){
				err += "Please upload a valid csv file";
			}

			console.log("[err ] -> ",err);
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

<h3>Subscriber Management System :: Bulk Import</h3>
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
        <td><label for="subimport"><span class="imp">*</span> Import File</label></td>
        <td><input type="file" name="subimport" id="subimport" class="box" />&nbsp;(* <a href="./includes/sample.subscriber.bulk.import.csv" target="blank">CSV</a>)</td>
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