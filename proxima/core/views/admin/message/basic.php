<?php foreach ($messages as $message) { ?>
	<div class="alert alert-<?php echo $message->type ?>">
	  <a class="close" data-dismiss="alert" href="#">&times;</a>
		<i class="icon-<?php echo $message->type != 'error' ? 'ok' : 'exclamation-sign';?>"></i>
			<?php echo $message->text ?>
		</div>
	<?php } ?>
