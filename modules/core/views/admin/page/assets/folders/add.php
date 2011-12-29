<?php echo $breadcrumbs?>

<?php echo Form::open()?>

	<fieldset>
		<legend>New folder</legend>
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors).
				Form::input('name', $folder->name, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('parent_id', __('Parent folder'), NULL, $errors).
				Form::select('parent_id', $folders, $folder->parent_id, NULL, $errors);
			?>
		</div>
	</fieldset>
	
	<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	
<?php echo Form::close()?>
