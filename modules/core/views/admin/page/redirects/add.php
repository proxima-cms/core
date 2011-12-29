<?php echo $breadcrumbs?>

<?php echo Form::open()?>
	<fieldset>
		<legend>Redirect</legend>
		<div class="field">
			<?php echo 
				Form::label('uri', __('URI'), NULL, $errors),
				Form::input('uri', Arr::get($_POST, 'uri'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('target', __('Target'), NULL, $errors),
				Form::select('target',	array('page' => 'Page'), NULL, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('target_id', __('Target Page'), NULL, $errors),
				Form::select('target_id', $pages, Arr::get($_POST, 'target_id'), NULL, $errors)
			?>
		</div>
	</fieldset>
	<?php echo Form::button('save', 'Save', array('class' => 'ui-button save'))?>			
<?php echo Form::close()?>