<?php #web_preview.php ?>

<i>Articles Management System - Preview :: ID(<?php __e($id);?>)</i>

<?php nb_admin_info($err,$msg);/*atitle 	ashortdesc 	adesc 	aimg 	astatus*/?>
<?php if($postdata['atitle']){ ?>
<div style="font-size: 17px; font-weight: bold; margin: 10px 0;"><?php __e( $postdata['atitle'] );?></div>
<div style="padding: 15px 10px; border: 1px solid #ccc;">
  <?php __e( html_entity_decode($postdata['adesc']) );?>
</div>

<?php }//if-end ?>