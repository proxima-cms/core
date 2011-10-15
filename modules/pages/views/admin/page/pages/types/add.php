<?php echo $breadcrumbs?>

<?php echo Form::open(NULL)?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', Arr::GET($_POST, 'name'), NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors),
				Form::input('description', Arr::GET($_POST, 'description'), NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('template', __('Template'), NULL, $errors),
				Form::select('template', $templates, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
