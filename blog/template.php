<?php if (count($cur_files) == 0) : ?>
No article in this category
<?php else: ?>
<?php foreach ($cur_files as $file) :?>
<div class="art">
  <?php echo $file['content']; ?>
  <span class="italic">Written on the <?php echo $file['created_at'];?></span>
</div>
<?php endforeach ?>
<div class="art-next">
  <?php if (isset($prec)) :?>
  <a href="<?php echo $prec?>">< Previous articles</a>
   <?php endif?>
   <?php if (isset($prec) && isset($next_offset)) echo '-'; ?>
   <?php if (isset($next_offset)) : ?>
   <a href="<?php echo $next_offset?>">Next articles ></a>
  <?php endif?>
</div>
<?php endif ?>

