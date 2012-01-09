<div class="clear">
	<div class="action-bar">
		<div class="action-menu helper-right">
			<button>Actions</button>
			<ul>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'assets',
								'action' => 'upload'
							)), __('Upload assets'));
					?>
				</li>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin')
							->uri(array(
								'controller' => 'assets',
								'action' => 'delete'
							)), __('Delete assets'), array('id' => 'delete-assets'));
					?>
				</li>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin/config')
							->uri(array(
								'group' => 'asset'
							)), __('Assets config'), array('id' => 'edit-config'));
					?>
				</li>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin/assets-folders')
							->uri(array(
								'action' => 'add'
							)), __('Add folder'));
					?>
				</li>
			</ul>
		</div>
	</div>	
	<?php echo $breadcrumbs ?>
</div>

<br/>

<div class="clear assetmanager popup">

	<div class="sidepane" style="width:25%">
		<?php echo View::factory('admin/page/assets/sidebar', array(
			'links'   => $links,
			'search'  => $search,
			'folders' => $folders,
			'cur_folder'  => $cur_folder,
			'folder_uri_template'  => $folder_uri_template
			));?>
	</div>

	<?php 
		$header_link = URL::site(
			Route::get('admin')->uri(array(
				'controller' => 'assets'
			)) . '?filter='.$filter.'&direction='.$reverse_direction.'&page='.$pagination->current_page);
	?>

	<div class="ui-grid assets-list view-list clear" style="width:73%">
		<table>
			<thead>
				<tr>
					<th class="filename">
						<a 
							title="Sort by filename" 
							href="<?php echo HTML::chars($header_link.'&sort=friendly_filename')?>">
							Filename
							<span class="ui-icon <?php echo ($order_by == 'filename' AND $direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
					<th class="type">
						<a 
							title="Sort by type" 
							href="<?php echo HTML::chars($header_link.'&sort=type')?>">
							Type
							<span class="ui-icon <?php echo ($order_by == 'type' AND $direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
					<th class="size">
						<a 
							title="Sort by size" 
							href="<?php echo HTML::chars($header_link.'&sort=filesize')?>">
							Size
							<span class="ui-icon <?php echo ($order_by == 'filesize' AND $direction == 'asc') ? 'ui-icon-triangle-1-n' : 'ui-icon-triangle-1-s'?>"></span>
						</a>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($assets as $asset){?>
				<tr>
					<td>
						<a 
							href="<?php echo URL::site('admin/assets/edit/'.$asset->id)?>" 
							class="asset" 
							data-id="<?php echo $asset->id?>"
							data-mimetype="<?php echo $asset->mimetype->subtype.'/'.$asset->mimetype->type?>"
							data-filename="<?php echo $asset->filename?>">
							
							<?php if ($asset->is_text_document()){?>
								<img src="/modules/assets/media/img/admin/assets/page-white-text.png" class="asset-thumb helper-left" />
							<?php } else if ($asset->is_archive()){?>
								<img src="/modules/assets/media/img/admin/assets/page-white-zip.png" class="asset-thumb helper-left" />
							<?php } else {?>
								<img src="<?php echo URL::site($asset->image_url(40, 40, TRUE))?>" class="asset-thumb helper-left" />
							<?php }?>
											
							<?php echo $asset->friendly_filename?>
						</a>
						<div style="color:#888;padding-top:.5em">
						<?php echo $asset->friendly_date?>
						</div>
					</td>
					<td>
						<a 
							href="<?php echo URL::site('admin/assets?filter=type-'.$asset->mimetype->type.'&direction='.$direction.'&page='.$pagination->current_page)?>"
							class="asset-type subtype-<?php echo $asset->mimetype->subtype?> type-<?php echo $asset->mimetype->type?>"><?php echo $asset->mimetype->type?></a>
					</td>
					<td>
						<?php echo Text::bytes($asset->filesize)?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<?php if (count($assets) === 0){?>
			<p style="margin-top:10px"><em>No results.</em></p>
		<?php }?>
	</div>	
</div>
