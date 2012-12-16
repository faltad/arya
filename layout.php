<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/styles.css" />
    <link rel="icon" type="image/png" href="css/favicon.png" />
    <?php foreach ($additional_styles as $style) : ?>
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $style ?>" />
    <?php endforeach ?>
   <?php if (isset($title)):?>
   <title><?php echo $title;?></title>
   <?php endif ?>
   </head>
   <body>
     <div class="header">
       <h1>
	 <a href="index.php">#</a>
       </h1>
       <ul>
	 <?php foreach ($top_bar_title as $key => $url) :?>
	 <li><a href="?m=<?php echo $url?>"><?php echo $key?></a></li>
	 <?php endforeach ?>
       </ul>
     </div>
     <div class="content">
       <?php if (!isset($no_menu) && isset($menu)) : ?>
       <div class="omenu">
	 <div class="menu">
	   <ul>
	     <?php foreach ($menu as $key => $menu_item) :?>
	     <li><a href="<?php echo $menu_item?>"><?php echo $key ?></a></li>
	     <?php endforeach ?>
	   </ul>	
	 </div>
	 <div class="clear"></div>
       </div>
       <?php endif ?>
       <div class="mod-content">
	 <?php echo $content_total_layout ?>
       </div>
     <div class="clear"></div>
     </div>
     <div class="footer">
       <a href="#">Powered by Arya</a>
     </div>
   </body>
</html>
