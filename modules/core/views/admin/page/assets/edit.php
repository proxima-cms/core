<div class="clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/assets/download/'.$asset->id, __('Download asset'))?></li>
			<li><?php echo HTML::anchor('admin/assets/delete/'.$asset->id, __('Delete asset'))?></li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<br />

<div class="clear assetmanager popup">

	<div class="sidepane" style="width:25%">
		<?php echo View::factory('admin/page/assets/sidebar_edit', array(
			'links' => $links,
			'search' => NULL,
			'folders' => $folders,
			'cur_folder'  => $cur_folder,
			'folder_uri_template'  => $folder_uri_template
			));?>
	</div>

	<?php echo Form::open(NULL, array('class' => 'assets-edit ajax-validate'))?>

		<div class="ui-grid assets-list view-list clear" style="width:73%">

			<?php echo Form::hidden('id', $asset->id)?>

			<?php if ($asset->is_image()){?>
				<fieldset>
					<legend>Preview</legend>
					<a href="<?php echo $asset->image_url(600, 600)?>" data-type="<?php echo $asset->is_pdf() ? 'image' : $asset->mimetype->subtype?>" class="thumb ui-lightbox" title="<?php echo $asset->filename?>">
						<img src="<?php echo URL::site($asset->image_url(300, 300))?>" />
					</a>
				</fieldset>
			<?php }?>

			<fieldset>
				<legend>Information</legend>
				<strong>Uploaded by:</strong> <?php echo HTML::anchor('admin/users/view/'.$asset->user->id, $asset->user->username).' on '.$asset->friendly_date?> <br />
				<strong>Mimetype:</strong> <?php echo $asset->mimetype->subtype.'/'.$asset->mimetype->type?> <br />
				<strong>Filesize:</strong> <?php echo Text::bytes($asset->filesize)?><br />
			</fieldset>
			
			<?php if ($asset->mimetype->subtype == 'image'){?>
				<fieldset>
					<legend>Image actions</legend>
					<ul>
						<li><?php echo HTML::anchor('admin/assets/rotate/'.$asset->id, 'Rotate 90deg')?></li>
						<li><?php echo HTML::anchor('admin/assets/sharpen/'.$asset->id, 'Sharpen')?></li>
						<li><?php echo HTML::anchor('admin/assets/flip_horizontal/'.$asset->id, 'Flip horizontal')?></li>
						<li><?php echo HTML::anchor('admin/assets/flip_vertical/'.$asset->id, 'Flip vertical')?></li>						
					</ul>
				</fieldset>
				<?php if (count($resized)){?>
					<fieldset>
						<legend>Resized images</legend>
						<ul>
							<?php foreach($resized as $size){?>
							<li>
								<a 	href="<?php echo URL::site('media/assets/resized/'.$size->filename)?>" 
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

			<div class="field">
				<?php echo
					Form::label('filename', 'Filename', NULL, $errors).
					Form::input('filename', Request::current()->post('filename') ?: $asset->filename, NULL, $errors)
				?>
			</div>
			<div class="field">
				<?php echo
					Form::label('description', 'Description', NULL, $errors).
					Form::input('description', Request::current()->post('description') ?: $asset->description, NULL, $errors)
				?>
			</div>
			<div class="field">
				<?php echo
					Form::label('folder_id', 'Folder', NULL, $errors).
					Form::select('folder_id', $folders, $asset->asset_folder->id, NULL, $errors);
				?>
			</div>
		</fieldset>
		<br />
		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
		<?php echo Form::close()?>
</div>
