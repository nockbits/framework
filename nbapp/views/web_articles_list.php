<h3>Articles Management System (<?php __e($num_rows);?>)</h3>
<div align="right" class="topactionbar"><input type="submit" name="add_btn" id="add_btn" value="Add" class="button-submit" onclick="redpage('<?php __e(nb_site_url("func=articles&mode=add"));?>');" /></div>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>
<?php if($num_rows){ ?>
   
  <?php __e($pager);?>
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmlist">
    <thead>
      <tr>
        <!-- <td width="5%">&nbsp;</td> -->
        <td width="8%">ID</td>
        <td width="20%">Name</td>
        <td width="">Info</td>
        <td width="5%">Status</td>
        <td width="15%">Action</td>
      </tr>
    </thead>
    <tbody>       
      <?php foreach($postdata as $val){ ?>     
      
      <tr>
        <!-- <td align="left" valign="top"><input type="checkbox" name="chkStatus" id="chkStatus" value="<?php __e($val['id']);?>" /></td> -->
        <td align="left" valign="top"><?php __e($val['id']);?></td>
        <td align="left" valign="top"><?php __e($val['atitle']);?></td>
        <td align="left" valign="top"><?php __e($val['ashortdesc']);?> </td>
        <td align="left" valign="top"><?php __e( (($val['astatus']) ? "Active":"Inactive") );?></td>
        <td align="left" valign="top">
          <a class="e" href="<?php __e(nb_site_url("func=articles&mode=edit&id=".$val['id']) );?>">Edit</a> | 
          <a class="d" href="javascript:;" onclick="confDelete('<?php __e(nb_site_url("func=articles&mode=delete&id=".$val['id']) );?>');">Delete</a> | 
          <a class="p" href="<?php __e(nb_site_url("func=articles&mode=preview&id=".$val['id']) );?>" target="_blank">Preview</a>
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
