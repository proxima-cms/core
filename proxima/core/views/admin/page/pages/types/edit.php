
<div class="row-fluid">

  <div class="span3">
			
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li>
					<a href="<?php echo URL::site(Route::get('admin/pages-types')
						->uri(array('action' => 'delete', 'id' => $page_type->id))); ?>" id="delete-page_type" class="button delete small helper-right">
						<span>Delete page type</span>
					</a>
				</li>
			</ul>
	  </div><!--/.well -->
  </div>

  <div class="span9">
	
		<div class="page-header">
			<h1>Add page type</h1>
		</div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>

				<?php echo Form::control_group(array(
					'name' => 'name',
					'label' => __('Name'),
					'value' => $page_type->name
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'name' => 'description',
					'label' => __('Description'),
					'value' => $page_type->description
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'name' => 'template',
					'label' => __('Template'),
					'value' => $page_type->template,
					'type' => 'select',
					'options' => $templates
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'name' => 'controller',
					'label' => __('Controller'),
					'value' => $page_type->controller,
					'help-block' => HTML::anchor('admin/pages/types/generate_controller?name=default', '[Default]', array('id' => 'generate-controller')).'<br/>',
				), $errors);?>
				
				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>

			</fieldset>
		<?php echo Form::close()?>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>
				<?if (count($components)){?>
				<h2>Components</h2>
				<table class="table table-bordered table-striped">
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
				<?php }?>

				<fieldset>
					<legend>Add a new component</legend>
						<?php echo Form::control_group(array(
							'name' => 'component_type',
							'label' => __('Component'),
							'value' => $component->type_id,
							'type' => 'select',
							'options' => $component_types
						), $errors);?>
						<?php echo Form::control_group(array(
							'name' => 'component_name',
							'label' => __('Identifier (eg. page/nav)'),
							'value' => $component->name
						), $errors);?>
				</fieldset>
			</fieldset>
			
			<div class="form-actions">
				<?php echo Form::button('save-component', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
			</div>

		<?php echo Form::close()?>
	</div>
</div>
