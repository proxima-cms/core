<?php echo $breadcrumbs?>

<?php echo Form::open()?>

	<fieldset>
		<legend>Metadata</legend>
		<div class="field">
			<?php echo 
				Form::label('title', __('Title'), NULL, $errors).
				Form::input('title', Arr::get($_POST, 'title'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors).
				Form::input('description', Arr::get($_POST, 'description'), NULL, $errors)
			?>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Categorize</legend>
		<div class="field">
			<?php echo 
				Form::label('parent_id', __('Parent page'), NULL, $errors).
				Form::select('parent_id', $pages, Arr::get($_POST, 'parent_id'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('pagetype_id', __('Page type'), NULL, $errors).
				Form::select('pagetype_id', $page_types, Arr::get($_POST, 'pagetype_id'), NULL, $errors)
			?>
		</div>
	</fieldset>

	<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	
<?php echo Form::close()?>
