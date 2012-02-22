<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li>
				<a href="<?php echo URL::site(Route::get('admin/pages-types')->uri(array('action' => 'delete', 'id' => $page_type->id))); ?>" id="delete-page_type" class="button delete small helper-right">
					<span>Delete page_type</span>
				</a>
			</li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<?php echo Form::open()?>
	<fieldset>

		<legend>Page type</legend>

		<div class="field">
			<?php echo
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name', $page_type->name, NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo
				Form::label('description', __('Descripton'), NULL, $errors),
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
				HTML::anchor('admin/pages/types/generate_controller?name=default&page_type_id'.$page_type->id, '[Default]', array('id' => 'generate-controller')).'<br/>',

				Form::input('controller', $page_type->controller, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save-type', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>

	</fieldset>

<?php echo Form::close()?>


<?php echo Form::open()?>
	<fieldset class="last">
		<legend>Components</legend>
		<?if (count($components)){?>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($components as $component){?>
				<tr>
					<td><?php echo $component->id;?></td>
					<td>
						<?php echo HTML::anchor('admin/components/edit/'.$component->id, $component->name)?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<br />
		<?php } else {?>
		<?php }?>

		<fieldset>
			<legend>Add a new component</legend>
				<div class="field">
					<?php echo
						Form::label('component_type', __('Component'), NULL, $errors),
						Form::select('component_type', $component_types, $component->type_id, NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php echo
						Form::label('component_name', __('Identifier (eg. page/nav)'), NULL, $errors),
						Form::input('component_name', $component->name, NULL, $errors)
					?>
				</div>
				<?php echo Form::button('save-component', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
		</fieldset>
	</fieldset>

<?php echo Form::close()?>
