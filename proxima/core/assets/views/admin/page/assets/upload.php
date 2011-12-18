<?php echo $breadcrumbs?>

<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data'))?>

	<fieldset class="last">
		<legend>Select file</legend>
		
		<p>Allowed types: <?php echo $allowed_upload_type?></p>
		<p>Max uploads: <?php echo $max_file_uploads?></p>
		
		<div class="field">
			<?php if (isset($errors)){?>
				<strong>Errors:</strong><br />
				<ul>
					<?php foreach($errors as $error){?>
						<li><?php echo $error?></li>
					<?php }?>			
				</ul>
			<?php }?>
			<div class="field">	
				<?php echo Form::file('assets[]', array(
					'id' => '', 
					'maxlength' => $max_file_uploads,
					'accept'    => $accept_type
				), $errors)?>
			</div>
		</div>
		
		<?php echo Form::button('save', 'Upload', array(
			'type'  => 'submit', 
			'class' => 'ui-button save ui-helper-hiddens', 
			'id'    => 'upload-asset'
		))?>		
		
	</fieldset>

<?php echo Form::close()?>
