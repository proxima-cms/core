<div class="control-group<?php if ($has_error){?> error<?}?>">
	<?php echo Form::label($attributes['name'], $attributes['label'], array('class' => 'control-label'), $errors); ?>
		<div class="controls">
			<?php echo $field . Form::error_msg($attributes['name'], $errors); ?>
	</div>
</div>

