<div class="action-bar clear">
	<a href="<?php echo URL::site(
		Route::get('admin')
			->uri(array(
				'controller' => 'roles',
				'action' => 'delete',
				'id' => $role->id
			))); ?>" id="delete-role" class="ui-button delete small helper-right">
		<span><?php echo __('Delete role'); ?></span>
	</a>
	<script type="text/javascript">
	(function($){
		$('#delete-role').click(function(){
			return confirm('<?php echo __('Are you sure you want to delete this role?')?>');
		});
	})(this.jQuery);
	</script>

	<?php echo $breadcrumbs?>
</div>

<?php echo Form::open()?>
	<fieldset>

		<div class="field">
			<?php echo
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $role->name, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('description', __('Descripton'), NULL, $errors),
				Form::input('description', $role->description, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>

<!-- USERS IN THIS ROLE -->
<fieldset>
	<legend>Users in this role</legend>
	<?php echo $users; ?>
</fieldset>

<!-- ADD USER TO THIS ROLE -->
<?php echo Form::open(
	Route::get('admin')
	->uri(array(
		'controller' => 'roles',
		'action' => 'adduser'
	)) . '?return_to=' . Request::current()->uri() );
?>
<?php echo Form::hidden('role_id', $role->id);?>
<fieldset>
	<legend><?php echo __('Add new user to this role'); ?></legend>
	<div class="field">
		<?php echo
			Form::label('user_id', __('User'), NULL, $errors),
			Form::select('user_id', $users_select, 0, NULL, $errors)
		?>
	</div>
	<?php echo Form::button('save-newuser', __('Add user'), array('type' => 'submit', 'class' => 'ui-button save'))?>
</fieldset>
