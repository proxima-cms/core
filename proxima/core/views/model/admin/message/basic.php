<ul>
	<?php foreach ($messages as $message) { ?>
		<li class="<?php echo $message->type ?>">
			<p>
				<span></span>
				<?php echo $message->text ?></p>
		</li>
	<?php } ?>
</ul>
