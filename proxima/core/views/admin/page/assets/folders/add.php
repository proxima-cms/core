<div class="row-fluid">

  <div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'assets/folders', 
							)), __('Manage folders'));?>
				</li>
			</ul>
	  </div><!--/.well -->
  </div>

  <div class="span9">

		<div class="page-header">
			<h1>Add user</h1>
		</div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>

			<?php echo Form::hidden('return_to', $return_to); ?>

			<fieldset>
				<legend>New folder</legend>
				<?php echo Form::control_group(array(
					'label' => __('Name'),
					'name' => 'name',
					'type' => 'input',
					'value' => $folder->name
				), $errors);?>
				<?php echo Form::control_group(array(
					'label' => __('Parent folder'),
					'name' => 'parent_id',
					'type' => 'select',
					'value' => $folder->parent_id,
					'options' => $folders
				), $errors);?>
			</fieldset>
			
			<div class="form-actions">
				<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
			</div>
			
		<?php echo Form::close()?>
	</div>
</div>
