<div class="action-bar clear">
	<div class="action-menu helper-right">
 		<button>Actions</button>
	  <ul>
			<li>
				<a href="<?php echo URL::site('admin/pages/types/delete/'.$page_type->id)?>" id="delete-page_type" class="button delete small helper-right">
					<span>Delete page_type</span>
				</a>
			</li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<?php echo Form::open()?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', Request::current()->post('name') ?: $page_type->name, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Descripton'), NULL, $errors),
				Form::input('description', Request::current()->post('description') ?: $page_type->description, NULL, $errors)
			?>
		</div>
    <div class="field">
      <?php echo 
        Form::label('template', __('Template'), NULL, $errors),
        Form::select('template', $templates, Request::current()->post('template') ?: $page_type->template, NULL, $errors)
      ?>  
    </div>
    <div class="field">
      <?php echo 
        Form::label('controller', __('Controller'), NULL, $errors),
        Form::input('controller', Request::current()->post('controller') ?: $page_type->controller, NULL, $errors)
      ?>  
		</div>
    <div class="field">
      <?php echo 
        Form::label('route_required', __('Route required?'), NULL, $errors),
        Form::select('route_required', array(__('No'), __('Yes')), Request::current()->post('route_required') ?: $page_type->route_required, NULL, $errors)
      ?>  
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
