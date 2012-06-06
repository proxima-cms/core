
<div class="row-fluid">

	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
					Route::get('admin')
					->uri(array(
						'controller' => 'roles',
						'action' => 'delete',
						'id' => $role->id
					)), __('Delete role'));?>
					</li>
			</ul>
		</div><!--/.well -->
	</div>

	<div class="span9">

		<div class="page-header">
			<h1>Edit role</h1>
		</div>

<div id="addmodule" class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#edit" data-toggle="tab">Edit role</a></li>
    <li><a href="#manage" data-toggle="tab">Manage users in role</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="edit">

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>

		 		<?php echo Form::control_group(array(
						'label' => __('Name'),
						'name' => 'name',
						'type' => 'input',
						'value' => $role->name
					), $errors);?>

		 		<?php echo Form::control_group(array(
						'label' => __('Description'),
						'name' => 'description',
						'type' => 'input',
						'value' => $role->description
					), $errors);?>
	
				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>

			</fieldset>
		<?php echo Form::close()?>
		</div>
<div class="tab-pane" id="manage">

			<?php echo $users; ?>

		<hr />

		<!-- ADD USER TO THIS ROLE -->
		<?php echo Form::open(
			Route::get('admin')
			->uri(array(
				'controller' => 'roles',
				'action' => 'adduser'
			)) . '?return_to=' . Request::current()->uri(), array('class' => 'form-horizontal'));
		?>
		<?php echo Form::hidden('role_id', $role->id);?>
		<fieldset>
		 		<?php echo Form::control_group(array(
						'label' => __('Add user'),
						'name' => 'user_id',
						'type' => 'select',
						'options' => $users_select,
						'value' => 0
					), $errors);?>
			<div class="form-actions">
				<?php echo Form::button('save-newuser', __('Add user'), array('type' => 'submit', 'class' => 'btn btn-primary'))?>
			</div>
		</fieldset>
</div>
</div>
	</div>
</div>
