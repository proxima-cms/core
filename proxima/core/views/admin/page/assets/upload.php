<div class="row-fluid">

	<div class="span3">
		<?php echo View::factory('admin/page/assets/sidebar_upload');?>
	</div>

	<div class="span9">

		<div class="page-header">
			<h1>Upload asset</h1>
		</div>

		<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data', 'class' => 'form-horizontal'))?>

			<fieldset>

				<div class="control-group<?php if (isset($errors['assets'])){?> error<?php }?>">
					<?php echo Form::label('assets[]', 'Select file', array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::file('assets[]', array(
							'id' => '',
							'maxlength' => $max_file_uploads,
							'accept'		=> $accept_type
						), $errors) . Form::error_msg('assets', $errors)?>
				<p class="help-block">Allowed types: <?php echo $allowed_upload_type?></p>
			<!-- 	<p>Max uploads: <?php echo $max_file_uploads?></p> -->

					</div>
				</div>
				<div class="control-group">
					<?php echo Form::label('folder_id', 'Folder', array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::select('folder_id', $folders, 0, NULL, $errors);?>
					</div>
				</div>

				<div class="form-actions">

					<?php echo Form::button('save', 'Upload', array(
						'type'	=> 'submit',
						'class' => 'btn btn-primary',
						'id'		=> 'upload-asset'
					))?>
				</div>

			</fieldset>

		<?php echo Form::close()?>
	</div>
</div>
