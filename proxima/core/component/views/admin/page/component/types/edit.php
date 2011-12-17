<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/components/delete/'.$component->id, __('Delete component'))?></li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>
	

<?php echo Form::open()?>

	<fieldset>
		<legend>Metadata</legend>
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors).
				Form::input('name', $component->name, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors).
				Form::textarea('description', $component->description, NULL, TRUE, $errors)
			?>
		</div>
	</fieldset>
	
	<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	
<?php echo Form::close()?>
