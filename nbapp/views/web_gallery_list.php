<h3>Gallery Management System (<?php __e($total_pages,0);?>)</h3>
<div align="right" class="topactionbar">
  <input type="submit" name="add_btn" id="add_btn" value="Add" class="button-submit" 
         onclick="nbapp.functions.redpage('<?php __e(nb_site_url("func=gallery&mode=add"));?>');" />
</div>
<br class="clearall"/>
<?php nb_admin_info($err,$msg);?>
<?php if($num_rows){ ?>
   
  <?php __e($pager);?>
  
  <table cellpadding="2" cellspacing="2" border="0" class="frmlist">
    <thead>
      <tr>
        <!-- <td width="5%">&nbsp;</td> -->
        <td width="8%">ID</td>
        <td width="20%">Album</td>
				<td width="30%">Name</td>
        <td width="">URL</td>
        <td width="5%">Image</td>
        <td width="5%">Status</td>        
        <td width="15%">Action</td>
      </tr>
    </thead>
    <tbody>       
      <?php foreach($postdata as $val){ ?>     
      
      <tr>
        <!-- <td align="left" valign="top"><input type="checkbox" name="chkStatus" id="chkStatus" value="<?php __e($val['id']);?>" /></td> -->
        <td align="left" valign="top"><?php __e($val['id']);?></td>
				<td align="left" valign="top"><?php __e( $albums[$val['albid']] );?></td>
        <td align="left" valign="top"><?php __e($val['gtitle']);?></td>
        <td align="left" valign="top"><?php __e($val['gurl']);?> </td>
        <td align="left" valign="top"><?php $tmp_img = nb_get_image_file($val['gimg'], "tiny"); if($tmp_img){ __e('<img src="'.$tmp_img.'" border="1" />'); } ?> </td>
        
        <td align="left" valign="top"><?php __e( (($val['gstatus']) ? "Active":"Inactive") );?></td>
        <td align="left" valign="top">
          <a class="d" href="javascript:;" onclick="nbapp.functions.confDelete('<?php __e(nb_site_url("func=gallery&mode=delete&id=".$val['id']) );?>');">Delete</a> | 
          <a class="p" href="<?php __e(nb_site_url("func=gallery&mode=preview&id=".$val['id']) );?>">Preview</a>
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
