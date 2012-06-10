<div class="row-fluid">
	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor('admin/pages', __('View pages'))?></li>
				<li><?php echo HTML::anchor('admin/pages/create', __('Add page'))?></li>
			</ul>
		</div><!--/.well -->
	</div><!--/span-->

	<div class="span9">

	<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
  <div class="page-header">
      <h1>Add page</h1>
    </div>
		<div class="alert alert-info">
			<strong>Note:</strong> You can add page content once the page has been created.
   	</div>
	<fieldset>
		<div class="control-group<?php if (isset($errors['title']) || isset($errors['_external']['title'])){?> error<?php }?>">
			<?php echo Form::label('title', __('Title'), array('class' => 'control-label'), $errors);?>
			<div class="controls">
				<?php echo Form::input('title', $page->title, NULL, $errors) . Form::error_msg('title', $errors) ?>
			</div>
		</div>
		<div class="control-group<?php if (isset($errors['description']) || isset($errors['_external']['description'])){?> error<?php }?>">
			<?php echo Form::label('description', __('Description'), array('class' => 'control-label'), $errors);?>
			<div class="controls">
				<?php echo Form::input('description', $page->description, NULL, $errors) . Form::error_msg('description', $errors);?>
			</div>
		</div>
		<div class="control-group<?php if (isset($errors['parent_id']) || isset($errors['_external']['parent_id'])){?> error<?php }?>">
			<?php echo Form::label('parent_id', __('Parent page'), array('class' => 'control-label'), $errors);?>
			<div class="controls">
				<?php echo Form::select('parent_id', $pages, $page->parent_id, NULL, $errors) . Form::error_msg('parent_id', $errors);?>
			</div>
		</div>
		<div class="control-group<?php if (isset($errors['name']) || isset($errors['_external']['pagetype_id'])){?> error<?php }?>">
			<?php echo Form::label('pagetype_id', __('Page type'), array('class' => 'control-label'), $errors); ?>
			<div class="controls">
				<?php echo Form::select('pagetype_id', $page_types, $page->pagetype_id, NULL, $errors) . Form::error_msg('pagetype_id', $errors) ?>
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
	<?php echo Form::button('save', 'Save', array(
		'type' => 'submit',
		'class' => 'btn btn-primary'
	))?>
	</div>

<?php echo Form::close()?>
</div></div>
