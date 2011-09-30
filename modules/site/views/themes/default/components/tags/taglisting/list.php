<ul>
<?php foreach($pages as $page){?>
	<li>
		<h3><?php echo HTML::anchor($page->uri, $page->title)?></h3>
		<div>
			<?php echo $page->body?>
		</div>
	</li>
<?php }?>
</ul>
