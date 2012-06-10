<div class="control-group<?php echo Form::error_css($options['name'], $errors, 'error');?>">
	<?php echo Form::label($options['name'], $options['label'], array('class' => 'control-label'), $errors); ?>
	<div class="controls">
		<?php echo $field . Form::error_msg($options['name'], $errors); ?>
		<?php if ($options['help-block'] !== NULL) {?>
			<p class="help-block">
				<?php echo $options['help-block'];?>
			</p>
		<?php }?>
	</div>
</div>

