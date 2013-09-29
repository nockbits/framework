<script type="text/javascript">
var galleryUpload = {};
$(function ()
{	
	var galleryImgUploads = [];
	var albumId= $("#albums").val();
	$("#albums").change(function() {
		albumId = $(this).val();
	});

	galleryUpload = {
		imgCounter : 1,
		maxUploads : 10,
		tpl : function(imgId,albumId){
			return '<div class="galimgbox" id="galpanel_'+imgId+'">'
							+'<form name="frmGen_'+imgId+'" id="frmGen_'+imgId+'" action="<?php __e(nb_site_url("func=gallery"));?>" method="post" enctype="multipart/form-data" class="frmcomajx">'
							+'<input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> '
							+'<input type="hidden" name="t" id="t" value="<?php __e(time());?>" />'
							+'<input type="hidden" name="panelNo" value="'+imgId+'" />'
							+'<input type="hidden" name="albumId" value="'+albumId+'" />'
							+'<label for="gtitle_'+imgId+'"><span class="imp">*</span> Title</label>&nbsp;&nbsp;'
							+'<input type="text" name="gtitle" id="gtitle_'+imgId+'" value="" class="box" \/><\/br>'
							+'<label for="gurl_'+imgId+'"><span class="imp">&nbsp;</span> URL</label>&nbsp;&nbsp;'
							+'<input type="text" name="gurl" id="gurl_'+imgId+'" value="" class="box" \/><\/br>'
							+'<label for="gal_'+imgId+'"><span class="imp">*</span> File('+imgId+')</label>&nbsp;&nbsp;'
							+'<input type="file" name="galimg" id="gal_'+imgId+'" class="box" />&nbsp;(* jpg,gif,png,tiff)&nbsp;&nbsp;'
							+'<input type="submit" name="btn_sub_'+imgId+'" id="btn_sub_'+imgId+'" value="Upload" class="button-submit" onclick="" />&nbsp;|&nbsp;'
							+'<input type="button" name="btn_cancel_'+imgId+'" id="btn_cancel_'+imgId+'" value="Cancel" class="button-submit" onclick="galleryUpload.remove('+imgId+');" />'
							+'</form>'
							+'</div>'
		},
		remove: function(id){
			if($("#galpanel_"+id).length){
				$("#galpanel_"+id).remove();
				this.imgCounter-=1;
			}
			return;
		},
		add : function(){
						
						var imgId = this.imgCounter;
						if(imgId > this.maxUploads){
							nbapp.functions.ajxShowModalMsgBox("Sorry you can upload only ("+this.maxUploads+") at one time", "Error");
							return;						
						}

						$("#galimgs").append(this.tpl(this.imgCounter, albumId));

						$('#frmGen_'+imgId).iframePostForm
						({
							json : true,
							debuger : false,
							post : function(){
											var err = "";
											
											if($("#gtitle_"+imgId).val().length < 5){
												err += "Please enter a valid title <br\/>";
											}

											//Image validation
											var aimg = $("#gal_"+imgId).val().split(".") || [];
											var imgRegex = /[jpg|png|tff|gif|jpeg]/ig;
											aimg = aimg[aimg.length-1];	
											if(!$("#gal_"+imgId).val() || !imgRegex.test(aimg)){
												err += "Please upload a jpeg, gif, png image";
											}
											else if(galleryImgUploads.indexOf($("#gal_"+imgId).val()) != -1){
												err += "You have already uploaded this file, please select another file";
											}
											if(err){
												nbapp.functions.ajxShowModalMsgBox(err, "Error");
												return false;
											}
											
											galleryImgUploads.push($("#gal_"+imgId).val());
											$("#btn_sub_"+imgId).attr("disabled","disabled");
											$("#btn_cancel_"+imgId).attr("disabled","disabled");
											nbapp.functions.ajxShowMsgBox(nbapp.conf.ajxMsg);
											return true;
								
							},
							complete : function(response){
													var res = response.nbapp || [];
													if(res.status == "Error"){
														nbapp.functions.ajxShowModalMsgBox(res.msg, "Error");
														$("#btn_sub_"+imgId).attr("disabled","");
														$("#btn_cancel_"+imgId).attr("disabled","");
													}else{
														//nbapp.functions.ajxShowModalMsgBox(res.msg, "Success");        	
														nbapp.functions.ajxClearMsgBoxFast();
														var tpl = res.msg + ' :: <a target="_blank" href="'+res.url+'">'+res.img+'<\/a>';
														$("#galpanel_" + res.panelNo).css({"border":"1px solid #1F7503"});
														$("#galpanel_" + res.panelNo).html("").html(tpl);
														setTimeout(function(){
															$("#galpanel_" + res.panelNo).fadeOut(800).fadeIn(800);
														},500);
													}
													return false;
												}
						});			
						
						this.imgCounter+=1;
					}	
	};
	 
});
</script>

<h3>Gallery Management System :: <?php if($setmode == 'update'){ ?> ID (<?php __e($id);?>) <?php }else{ __e("Add");} ?></h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);/*atitle 	ashortdesc 	adesc 	aimg 	astatus*/?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=gallery"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>

      <thead>
        <tr>
          <td colspan="2">* Please select an album and then add images</td>
        </tr>
      </thead>

      <tr>
        <td><label for="albums"><span class="imp">*</span> Album</label></td>
        <td>
					<select name="albums" id="albums" class="box">
            <?php foreach($albums as $album_id => $albums_info){ ?>
            ` <option value="<?php __e($album_id);?>"><?php __e($albums_info);?></option>
            <?php } ?>            
          </select>
        </td>
      </tr>
			
    </tbody>
  </table>
</form>

<input type="button" name="btn_add" id="btn_add" value="Add an Image" class="button-submit" onclick="galleryUpload.add();" />
<div id="galimgs">
	
</div>


<?php if($num_rows && ($mode == 'edit')){ ?>
<div>
  <strong><?php __e(nb_get_lang_msg("list_no_records"));?> with ID(<?php __e($id);?>)</strong>
</div>
<?php }//if-end ?>