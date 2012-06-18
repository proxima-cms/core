<div class="row-fluid">

  <div class="span3">
			
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'pages/types', 
							)), __('View page types'));?>
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
	</div>
</div>

