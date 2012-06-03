<div class="row-fluid">

	<div class="span3">

		<!-- ACTIONS -->
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'download',
							'id' => $asset->id
						)), __('Download asset'));?>
				</li>	
				<li><?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'delete',
							'id' => $asset->id
						)), __('Delete asset'));?>
				</li>
				<?php if ($asset->mimetype->subtype == 'image'){?>
					<li><?php echo HTML::anchor(
						Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'rotate',
							'id' => $asset->id
						)), __('Rotate 90deg'))
					?></li>
					<li><?php echo HTML::anchor(
						Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'sharpen',
							'id' => $asset->id
						)), __('Sharpen'))
					?></li>
					<li><?php echo HTML::anchor(
						Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'flip_horizontal',
							'id' => $asset->id
						)), __('Flip horizontal'))
					?></li>
					<li><?php echo HTML::anchor(
						Route::get('admin')
						->uri(array(
							'controller' => 'assets',
							'action' => 'flip_vertical',
							'id' => $asset->id
						)), __('Flip vertical'))
					?></li>
				<?php }?>
			</ul>

		</div>
	</div>

	<div class="span9">

		<div class="page-header">
			<h1>View asset</h1>
		</div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>

			<?php echo Form::hidden('id', $asset->id)?>

			<?php if ($asset->is_image()){?>
				<fieldset>
					<legend>Preview</legend>
					<a href="<?php echo $asset->image_url(600, 600)?>" data-type="<?php echo $asset->is_pdf() ? 'image' : $asset->mimetype->subtype?>" class="thumb ui-lightbox" title="<?php echo $asset->filename?>">
						<img src="<?php echo URL::site($asset->image_url(300, 300))?>" />
					</a>
				</fieldset>
			<?php }?>

		<hr />
			<table class="table table-bordered table-striped">
			<tbody>
<tr>
	<th scope="row">
			Uploaded:
</th>
<td>
				<?php echo HTML::anchor(
					Route::get('admin')
					->uri(array(
						'controller' => 'users',
						'action' => 'view',
						'id' => $asset->user->id
					)), $asset->user->username). ' '. __('on') . ' ' .$asset->friendly_date
				?>
</td>
</tr>
<tr>
<th scope="row">
			Mimetype:
</th>
<td>
				<?php echo $asset->mimetype->subtype.'/'.$asset->mimetype->type?> <br />
</td>
</tr>
<tr>
<th scope="row">
				Filesize: 
</th>
<td>
				<?php echo Text::bytes($asset->filesize)?><br />
</td></tr></body></table>
			
			<?php if ($asset->mimetype->subtype == 'image'){?>
				<?php if (count($resized)){?>
					<fieldset>
						<legend>Resized images</legend>
						<ul>
							<?php foreach($resized as $size){?>
							<li>
								<a	href="<?php echo URL::site(
									Route::get('media/assets')
									->uri(array(
										'id' => $size->asset->id,
										'width' => $size->width,
										'height' => $size->height,
										'crop' => 0,
										'filename' => preg_replace('/^'.$size->asset->id.'_/', '', $size->asset->filename)
									))); ?>"
									data-type="image" 
									class="ui-lightbox" 
									title="<?php echo $size->filename?>">
									<?php echo $size->filename?>
								</a>
								 (<?php echo $size->width?> x <?php echo $size->height?>px)
						</li>
						<?php }?>
					</ul>
				</fieldset>
			<?php }?>
		<?php }?>
		<fieldset class="last">
			<legend>Edit asset</legend>

			<div class="control-group">
				<?php echo Form::label('filename', 'Filename', array('class' => 'control-label'), $errors);?>
				<div class="controls">
					<?php echo Form::input('filename', Request::current()->post('filename') ?: $asset->filename, NULL, $errors)?>
				</div>
			</div>
			<div class="control-group">
				<?php echo Form::label('description', 'Description', array('class' => 'control-label'), $errors);?>
				<div class="controls">
					<?php echo Form::input('description', Request::current()->post('description') ?: $asset->description, NULL, $errors);?>
				</div>
			</div>
			<div class="control-group">
				<?php echo Form::label('folder_id', 'Folder', array('class' => 'control-label'), $errors);?>
				<div class="controls">
					<?php echo Form::select('folder_id', $folders, $asset->asset_folder->id, NULL, $errors); ?>
				</div>
			</div>
		</fieldset>
		<div class="form-actions">
			<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
		</div>
		<?php echo Form::close()?>
	</div>
</div>
