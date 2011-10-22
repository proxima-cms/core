<div class="box post">

	<h2 class="title"><?php echo HTML::anchor($page->uri, $page->title)?></h2>

	<div class="copy clear">
		<?php echo $page->body?>
	</div>

	<div class="footer clear">
		<div class="date">
			Posted: <?php echo $page->date?>
		</div>
	</div>

</div>
