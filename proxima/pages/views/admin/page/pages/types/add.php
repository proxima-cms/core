<?php echo $breadcrumbs?>

<?php echo Form::open(NULL)?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $page_type->name, NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors),
				Form::input('description', $page_type->description, NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('template', __('Template'), NULL, $errors),
				Form::select('template', $templates, $page_type->template, NULL, $errors)
			?>
		</div>

		<div class="field">
			<?php echo 

				Form::label('controller', __('Controller'), array('style' => 'display:inline'), $errors),
		
				'&nbsp;&nbsp;&nbsp;',
				HTML::anchor('admin/pages/types/generate_controller?name=default', '[Default]', array('id' => 'generate-controller')).'<br/>',

				Form::input('controller', $page_type->controller, NULL, $errors)
			?>	
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>

	</fieldset>
<?php echo Form::close()?>
