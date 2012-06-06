<div class="row-fluid">

  <div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'modules', 
							)), __('View modules'));?>
				</li>
			</ul>
	  </div><!--/.well -->
  </div>

  <div class="span9">

  <div class="page-header">
  <h1>Add module</h1>
  </div>

<div id="addmodule" class="tabbable tabs-left"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Upload archive</a></li>
    <li><a href="#tab2" data-toggle="tab">Import from github</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<fieldset>
	<legend>Upload archive</legend>


	<div class="control-group">
		<?php echo Form::label('module_file', 'Select file', array('class' => 'control-label'), $errors);?>
		<div class="controls">
				<?php echo Form::file('module_file', NULL, $errors) ?>
				<p class="help-block">Allowed types: <?php echo $allowed_upload_type?></p>
		</div>
	</div>

	<div class="form-actions">
		<?php echo Form::button('save', 'Upload', array(
			'type'  => 'submit',
			'class' => 'btn btn-primary',
			'id'    => 'upload-asset'
		))?>
	</div>

</fieldset>
<?php echo Form::close(); ?>
    </div>
    <div class="tab-pane" id="tab2">


<?php echo Form::open(NULL, array('class' => 'form-horizontal')); ?>
<fieldset>

	<legend>Import module from github</legend>

	<div class="control-group">
		<?php echo Form::label('github_url', 'Github URL', array('class' => 'control-label'), $errors); ?>
		<div class="controls">
			<?php echo Form::input('github_url', $module->github_url, NULL, $errors); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo Form::label('name', 'Module name', array('class' => 'control-label'), $errors); ?>
		<div class="controls">
			<?php echo Form::input('name', $module->name, NULL, $errors); ?>
		</div>
	</div>

	<div class="form-actions">
		<?php echo Form::submit('save', 'Add module', array('class' => 'btn btn-primary')); ?>
	</div>

</fieldset>
<?php echo Form::close(); ?>
    </div>
  </div>
</div>

</div></div>
