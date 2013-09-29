<h3>Gallery Management System :: ID (<?php __e($id);?>)</h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=gallery"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>
      <tr>
        <td width="12%"><label for="gstatus">Status</label></td>
        <td><?php __e( (($postdata['gstatus'] == 1) ? 'Active':'Inactive') );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Album</label></td>
        <td><?php __e( (isset($albums[$postdata['albid']]) ? $albums[$postdata['albid']]:"-") );?></td>
      </tr>
      <tr>
        <td><label for="subname">Title</label></td>
        <td><?php __e(html_entity_decode($postdata['gtitle']) );?></td>
      </tr>
      <tr>
        <td><label for="subemail">Description</label></td>
        <td><?php __e(html_entity_decode($postdata['gdesc']) );?></td>
      </tr>
			<tr>
        <td><label for="subemail">URL</label></td>
        <td><?php __e(html_entity_decode($postdata['gurl']) );?></td>
      </tr>
			<tr>
        <td><label for="subemail">Image</label></td>
        <td><?php $tmp_img = nb_get_image_file($postdata['gimg'], "medium"); if($tmp_img){ __e('<img src="'.$tmp_img.'" border="1" />'); } ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="window.location.href='<?php __e(nb_site_url("func=gallery"));?>'" />
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