
<div class="row-fluid">

  <div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'tags', 
								'action' => 'add'
							)), __('Add tag'));?>
				</li>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'tags',
								'action' => 'delete',
								'id' => $tag->id
							)), __('Delete tag'), array('id' => "delete-tag", 'class' => "button delete small"));
					?>
				</li>
			</ul>
	  </div><!--/.well -->
  </div>

  <div class="span9">
	
		<div class="page-header">
			<h1>Edit tag</h1>
		</div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>

				<?php echo Form::control_group(array(
					'name' => 'name',
					'label' => __('Name'),
					'value' => $tag->name,
				), $errors);?>
				
				<?php echo Form::control_group(array(
					'name' => 'slug',
					'label' => __('Slug'),
					'value' => $tag->slug,
				), $errors);?>

				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>

			</fieldset>
		<?php echo Form::close()?>
	</div>
</div>
