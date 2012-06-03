<div class="row-fluid">

  <div class="span3">
    <?php echo View::factory('admin/page/tags/sidebar');?>
  </div>

  <div class="span9">
	
	<div class="page-header">
	<h1>Add tag</h1>
	</div>


		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>
			<fieldset>
				
				<div class="control-group<?php if (isset($errors['name'])){?> error<?php }?>">
					<?php echo Form::label('name', __('Name'), array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::input('name', $tag->name, NULL, $errors);?>
					</div>
				</div>
				
				<div class="control-group<?php if (isset($errors['slug'])){?> error<?php }?>">
					<?php echo Form::label('slug', __('Slug'), array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::input('slug', $tag->slug, NULL, $errors);?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
				</div>

			</fieldset>
		<?php echo Form::close()?>
	</div>
</div>
