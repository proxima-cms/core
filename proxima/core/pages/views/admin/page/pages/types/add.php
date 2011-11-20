<?php echo $breadcrumbs?>

<?php echo Form::open(NULL)?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', Request::current()->post('name'), NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors),
				Form::input('description', Request::current()->post('description'), NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('template', __('Template'), NULL, $errors),
				Form::select('template', $templates, Request::current()->post('template'), NULL, $errors)
			?>
		</div>

		<div class="field">
			<?php echo 

				Form::label('controller', __('Controller'), array('style' => 'display:inline'), $errors),
		
				'&nbsp;&nbsp;&nbsp;',
				HTML::anchor('admin/pages/types/generate_controller?name=default', '[Default]', array('id' => 'generate-controller')).'<br/>',

				Form::input('controller', Request::current()->post('controller'), NULL, $errors)
			?>	
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>

	</fieldset>
<?php echo Form::close()?>
