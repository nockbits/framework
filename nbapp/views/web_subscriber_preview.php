<h3>Subscriber Management System :: ID (<?php __e($id);?>)</h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=subscriber"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>
      <tr>
        <td width="12%"><label for="substatus">Status</label></td>
        <td><?php __e( (($postdata['substatus'] == 1) ? 'Active':'Inactive') );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Category</label></td>
        <td><?php __e( (isset($subscriber_category[$postdata['subcat']]) ? $subscriber_category[ $postdata['subcat'] ]:"-") );?></td>
      </tr>
      <tr>
        <td><label for="subname">Name</label></td>
        <td><?php __e(html_entity_decode($postdata['subname']) );?></td>
      </tr>
      <tr>
        <td><label for="subemail">Email</label></td>
        <td><?php __e(html_entity_decode($postdata['subemail']) );?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
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