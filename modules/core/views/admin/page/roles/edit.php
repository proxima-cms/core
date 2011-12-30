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
	<fieldset class="last">
		
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
