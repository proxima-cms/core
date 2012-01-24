<?php echo $breadcrumbs?>

<?php echo Form::open()?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $tag->name, NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('slug', __('Slug'), NULL, $errors),
				Form::input('slug', $tag->slug, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
