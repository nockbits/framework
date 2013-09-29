<?php #web_header.php ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
  <head>
	<title>NB Admin :: <?php __e(date("jS, M Y"));?></title>
   
	<meta http-equiv="Content-Script-Type" content="type" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="robots" content="noodp, noindex, nofollow" />
  <meta name="description" content="NockBits Admin" />
  <meta name="keywords" content="CRM, Solution, Online System, NockBits Admin" />
  <meta name="robots" content="no-cache" />
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  
  <!-- CSS -->
  <link  href="<?php __e(nb_base_url());?>/css/reset.css?<?php __e(nb_get_conf("css_refresh_key"))?>" rel="stylesheet" type="text/css" media="screen"/>
  <link  href="<?php __e(nb_base_url());?>/css/main.css?<?php __e(nb_get_conf("css_refresh_key"))?>" rel="stylesheet" type="text/css" media="screen" />
  <link  href="favicon.ico" rel="shortcut icon" type="image/ico" />
  <!-- /CSS -->

  <script type="text/javascript" lang="javascript" src="<?php __e(nb_base_url());?>js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" lang="javascript" src="<?php __e(nb_base_url());?>js/json2.js"></script>
  <script type="text/javascript" lang="javascript" src="<?php __e(nb_base_url());?>js/app.js"></script>
  <script type="text/javascript" lang="javascript" src="<?php __e(nb_base_url());?>js/jquery.iframe-post-form.js"></script>
  <script type="text/javascript" lang="javascript">
    nbapp.conf.baseurl = "<?php __e(nb_base_url());?>";
  </script>
	</head>
<body>
	
	<!--<div class="modal-backdrop">
		<div class="modal">
			<div class="modal-header">Title</div>
			<div class="modal-body screenboxcont">Body</div>
			<div class="modal-footer">Footer</div>
		</div>
	</div>
	-->
  <div id="lightbox">
    <p><a onclick="nbapp.functions.ajxClearMsgBox();" href="#">Click to close</a></p>
    <div id="content">
      <div class="screenboxcont"></div>
    </div>
  </div>
  
  <!-- bodywrap start -->
  <div id="bodywrap">
    
    <!-- header start -->
    <h1><a href="#"><span class="c1">Nock</span><span class="c2">Bits</span><span class="c3">&nbsp;&nbsp;beta</span></a></h1>
    <ul id="mainnav">	
      <li><a title="DASHBOARD" class="active" href="#dashboard">DASHBOARD</a></li> <!-- Use the "active" class for the active menu item  -->
      <li><a target="_blank" title="WEBSITE" href="<?php __e(nb_get_conf("base_url"));?>">WEBSITE</a></li>
      <?php if($usrname=nb_get_cok(__sessionkey("login"))){ ?>
      <li class="logout"><a title="LOGOUT" href="<?php __e(nb_site_url('func=logout&mode=logout'));?>">LOGOUT</a></li>
      <li class="logout"><a title="Welcome user, <?php __e($usrname); ?>" href="#logout"><?php __e($usrname); ?></a></li>	
      <?php }else{ ?>
      <li class="logout"><a title="Welcome Guest" href="<?php __e(nb_site_url('func=login'));?>"><?php __e("Guest"); ?></a></li>	  
      <?php } ?>
    </ul>
    <!-- header end -->
  
    <!-- maincont start -->
    <div id="maincont">
      
      <?php if($usrname){ ?>
      <div id="sidebar">
        <ul class="sidenav">
           <li><a href="<?php __e(nb_site_url('func=articles&mode=list'));?>"><span class="icon-chevron-right"></span>Articles</a></li>
           <li><a href="<?php __e(nb_site_url('func=enquiry&mode=list'));?>"><span class="icon-chevron-right"></span>Enquiries</a></li>
           <li>
						<a href="javascript:void(0);" onclick="nbapp.sideNav.open(this);"><span class="icon-plus-sign"></span>Subscribers</a>
						<ul class="sidenavsub">
							<li><a href="<?php __e(nb_site_url('func=subscriber&mode=list'));?>"><span class="icon-chevron-right"></span>List</a><li>
							<li><a href="<?php __e(nb_site_url('func=subscriber&mode=bulkimport'));?>"><span class="icon-chevron-right"></span>Bulk Import</a><li>
						</ul>
					 </li>

					 <li>
						<a href="javascript:void(0);" onclick="nbapp.sideNav.open(this);"><span class="icon-plus-sign"></span>Gallery</a>
						<ul class="sidenavsub">
							<li><a href="<?php __e(nb_site_url('func=gallery&mode=list'));?>"><span class="icon-chevron-right"></span>List</a><li>
							<li><a href="<?php __e(nb_site_url('func=gallery&mode=add'));?>"><span class="icon-chevron-right"></span>Add</a><li>
						</ul>
					 </li>
        </ul>  
      </div>
      <?php } ?>
      
      <!-- subcont start -->
      <div id="subcont">
		
	
	