<ul class="rss">
	<?php foreach($tweets as $k => $tweet){?>
		<li>
			<?php echo HTML::anchor('http://twitter.com/'.$username.'/status/'.$tweet->id, strip_tags($tweet->text))?>
			<?php if ($k == $max_amount - 1) break; ?>
		</li>
	<?php }?>
</ul>
