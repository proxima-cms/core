<ul>
	<?php foreach($tags as $tag){?>
		<li><?php echo HTML::anchor('tag?name='.$tag->name, $tag->name)?></li>
	<?php }?>
</ul>
