<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/modules/generate_config', 'Re-generate module data')?></li>
			<li><?php echo HTML::anchor('admin/modules/add', 'Add new module')?></li>
		</ul>
	</div>

	<?php echo $breadcrumbs?>
</div>

<h2>Upload module</h2>


<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data')); ?>
<fieldset>
	<legend>Select file</legend>

	<p>Allowed types: <?php echo $allowed_upload_type?></p>

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
			<?php echo Form::file('module_file', NULL, $errors)?>
		</div>
	</div>

	<?php echo Form::button('save', 'Upload', array(
		'type'  => 'submit',
		'class' => 'ui-button save ui-helper-hiddens',
		'id'    => 'upload-asset'
	))?>

</fieldset>
<?php echo Form::close(); ?>

<h2>Add module from git url</h2>


<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data')); ?>
<fieldset>
	<legend>Github repository url:</legend>

	<p>Allowed urls types: <?php echo $allowed_github_urls; ?></p>

	<?php echo
		Form::label('github-url', 'Github URL'),
		Form::input('github-url', NULL, NULL, $errors);
	?>

	<?php echo
		Form::label('github-name', 'Module name'),
		Form::input('github-name', NULL, NULL, $errors);
	?>

	<?php echo Form::submit('save', 'Add module'); ?>

</fieldset>
<?php echo Form::close(); ?>
