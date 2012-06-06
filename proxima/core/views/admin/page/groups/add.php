<div class="row-fluid">

  <div class="span3">
    <div class="well sidebar-nav">
      <ul class="nav nav-list">
        <li class="nav-header">Actions</li>
        <li><?php echo HTML::anchor(
            Route::get('admin')
              ->uri(array(
                'controller' => 'groups',
              )), __('Manage groups'));?>
        </li>
      </ul>
    </div><!--/.well -->
  </div>

  <div class="span9">

    <div class="page-header">
      <h1>Add group</h1>
    </div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset class="last">

				<?php echo Form::control_group(array(
					'label' => __('Parent group'),
					'name' => 'parent_id',
					'type' => 'select',
					'options' => $groups,
					'value' => $group->parent_id
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'label' => __('Name'),
					'name' => 'name',
					'type' => 'input',
					'value' => $group->name
				), $errors);?>

				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>
			</fieldset>
		<?php echo Form::close()?>
	</div>
</div>
