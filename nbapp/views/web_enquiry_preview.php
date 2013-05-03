<?php #web_login.php ?>

<h3>Enquiry Management System :: ID (<?php __e($id);?>)</h3>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>

<form name="frmGen" id="frmGen" action="<?php __e(nb_site_url("func=enquiry"));?>" method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" id="mode" value="<?php __e($setmode);?>" /> 
  <input type="hidden" name="id" id="id" value="<?php __e( $id );?>" /> 
  <input type="hidden" name="t" id="t" value="<?php __e(time());?>" />
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmcom">
    <tbody>
      <tr>
        <td width="12%"><label for="astatus">Status</label></td>
        <td><?php __e( (($postdata['enstatus'] == 1) ? 'Active':'Inactive') );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Email</label></td>
        <td><?php __e(html_entity_decode($postdata['enemail']) );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Phone</label></td>
        <td><?php __e(html_entity_decode($postdata['enphone']), '-' );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Address</label></td>
        <td><?php __e(html_entity_decode($postdata['enaddress']), '-' );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Postcode</label></td>
        <td><?php __e(html_entity_decode($postdata['enpostcode']), '-' );?></td>
      </tr>
      <tr>
        <td><label for="atitle">State</label></td>
        <td><?php __e(html_entity_decode($postdata['enstate']), '-' );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Country</label></td>
        <td><?php __e(html_entity_decode($postdata['encountry']) , '-');?></td>
      </tr>
      <tr>
        <td><label for="atitle">Comment</label></td>
        <td><?php __e(html_entity_decode($postdata['encomment']), '-' );?></td>
      </tr>
      <tr>
        <td><label for="atitle">IP</label></td>
        <td><?php __e(html_entity_decode($postdata['enip']) );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Referrer</label></td>
        <td><?php __e(html_entity_decode($postdata['enref']) );?></td>
      </tr>
      <tr>
        <td><label for="atitle">Created</label></td>
        <td><?php __e(html_entity_decode($postdata['created']) );?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>
           <input type="reset" name="srch_btn" id="srch_btn" value="Cancel" class="button-submit" onclick="window.location.href='<?php __e(nb_site_url("func=enquiry"));?>'" />
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