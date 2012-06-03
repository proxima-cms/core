<?php foreach ($messages as $message) { ?>
	<div class="alert alert-<?php echo $message->type ?>">
	  <a class="close" data-dismiss="alert" href="#">&times;</a>
			<?php echo $message->text ?>
		</div>
	<?php } ?>
