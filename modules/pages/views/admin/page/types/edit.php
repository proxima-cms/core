<div class="action-bar clear">
	<div class="action-menu helper-right">
 		<button>Actions</button>
	  <ul>
			<li>
				<a href="<?php echo URL::site('admin/page_types/delete/'.$page_type->id)?>" id="delete-page_type" class="button delete small helper-right">
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
				Form::input('name', Arr::get($_POST, 'name'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Descripton'), NULL, $errors),
				Form::input('description', Arr::get($_POST, 'description'), NULL, $errors)
			?>
		</div>
    <div class="field">
      <?php echo 
        Form::label('template', __('Template'), NULL, $errors),
        Form::select('template', $templates, Arr::get($_POST, 'template', NULL), NULL, $errors)
      ?>  
    </div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
