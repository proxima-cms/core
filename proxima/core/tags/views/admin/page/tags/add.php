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
				Form::label('slug', __('Slug'), NULL, $errors),
				Form::input('slug', Arr::GET($_POST, 'slug'), NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>