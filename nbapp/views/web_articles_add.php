<?php #web_login.php ?>

<h3>Articles Management System :: ID <?php if($setmode == 'update'){ ?> (<?php __e($id);?>) <?php } ?></h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);/*atitle 	ashortdesc 	adesc 	aimg 	astatus*/?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=articles"));?>" method="post" enctype="multipart/form-data">
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
        <td><label for="atitle">Upload Picture</label></td>
        <td><input type="file" name="aimg" id="aimg" class="box " /> <?php __e( ( $postdata['aimg'] && nb_get_media_file($postdata['aimg'],1) ) ? "<br/>(<a href='".nb_get_media_file($postdata['aimg'])."' target='_blank'>".$postdata['aimg']."</a>)":"" ); ?></td>
      </tr>
      <tr>
        <td><label for="atitle">Media File</label></td>
        <td><input type="file" name="amedia" id="atitle" class="box " /> <?php __e( ( $postdata['amedia'] && nb_get_media_file($postdata['amedia'],1)) ? "<br/>(<a href='".nb_get_media_file($postdata['amedia'])."' target='_blank'>".$postdata['amedia']."</a>)":"" );?></td>
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
           <input type="submit" name="srch_btn" id="srch_btn" value="Submit" class="button-submit" onclick="" />
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="window.location.href='<?php __e(nb_site_url("func=articles"));?>'" />
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