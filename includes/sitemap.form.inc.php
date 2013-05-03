<?php if(count($tmp_sitemap_postdata) > 0){?>
  <ul>
    <li><a href="<?php __e(nb_site_url());?>" title="Home">Home</a></li>
    <?php foreach($tmp_sitemap_postdata as $val){ ?>
    <li>
      <a href="<?php __e(nb_site_url( $val['asefurl'] ));?>" title="<?php __e(html_entity_decode( $val['atitle'] ));?>"><?php __e(html_entity_decode( $val['atitle'] ));?></a>
      <br/>
      <?php __e(html_entity_decode( $val['ashortdesc'] ));?>
    </li>
    <?php } ?>
    
  </ul>
<?}else{?>
<ul>
  <li><a href="<?php __e(nb_site_url());?>" title="Home">Home</a></li>
</ul>
<?php } ?>