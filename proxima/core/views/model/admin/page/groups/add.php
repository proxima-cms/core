<?php echo $breadcrumbs?>

<?php echo Form::open(NULL, array('class' => 'ajax-validate'))?>
	<fieldset class="last">

		<div class="field">
			<?php echo 
				Form::label('parent_id', __('Parent group'), NULL, $errors),
				Form::select('parent_id', $groups, $group->parent_id, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $group->name, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
