<div class="art">
   <?php
   if (isset($content)):
     echo $content;
   elseif (isset($cur_files)): ?>
     <h1><?php echo $filter . '/' ?></h1>
     <ul>
	<?php foreach ($cur_files as $key => $file):?>
	   <li><a href="<?php echo $file?>"><?php echo $key?></a></li>
	<?php endforeach ?>
     </ul>
   <?php endif ?>
</div>
