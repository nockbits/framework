<h3>Enquiry Management System (<?php __e($num_rows);?>)</h3>
<!-- <div align="right" class="topactionbar"></div> -->
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>
<?php if($num_rows){ ?>
   
  <?php __e($pager);?>
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmlist">
    <thead>
      <tr>
        <!-- <td width="5%">&nbsp;</td> -->
        <td width="5%">ID</td>
        <td width="20%">Name</td>
        <td width="">Email</td>
        <td width="20%">Address</td>
        <td width="10%">Phone</td>
        <td width="5%">Status</td>
        <td width="15%">Action</td>
      </tr>
    </thead>
    <tbody>       
      <?php foreach($postdata as $val){ ?>     
      
      <tr>
        <!-- <td align="left" valign="top"><input type="checkbox" name="chkStatus" id="chkStatus" value="<?php __e($val['id']);?>" /></td> -->
        <td align="left" valign="top"><?php __e($val['id']);?></td>
        <td align="left" valign="top"><?php __e($val['enname']);?></td>
        <td align="left" valign="top"><?php __e($val['enemail']);?> </td>
        <td align="left" valign="top"><?php __e(html_entity_decode($val['enaddress']));?> </td>
        <td align="left" valign="top"><?php __e($val['enphone'], '-');?> </td>
        <td align="left" valign="top"><?php __e( (($val['astatus']) ? "Active":"Inactive") );?></td>
        <td align="left" valign="top">
          <a class="d" href="javascript:;" onclick="confDelete('<?php __e(nb_site_url("func=enquiry&mode=delete&id=".$val['id']) );?>');">Delete</a> | 
          <a class="p" href="<?php __e(nb_site_url("func=enquiry&mode=preview&id=".$val['id']) );?>">Preview</a>
        </td>
      </tr>      
      
      <?php }//foreach-end ?>
    </tbody>
  </table>

  <?php __e($pager);?>

<?php } else { ?>

<div>
  <strong><?php __e(nb_get_lang_msg("list_no_records"));?></strong>
</div>


<?php }//if-end ?>
