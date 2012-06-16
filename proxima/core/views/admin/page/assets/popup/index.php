
<div class="row-fluid tabs" id="assetmanager-tabs">
		
	<ul class="nav nav-tabs">
		<li class="active"><a href="#browse">Browse</a></li>
		<li><a href="#upload">Upload</a></li>
	</ul>
	
	<div class="tab-content">
		<div class="tab-pane active" id="browse">

			<div class="span4">
				<?php echo View::factory('admin/page/assets/popup/sidebar', array(
					'assets'  => $assets,
					'total_assets' => $total_assets,
					'links'   => $links,
					'search'  => $search,
					'folders' => $folders,
					'cur_folder'  => $cur_folder,
					'folder_uri_template'  => $folder_uri_template
					));?>
			</div>

			<div class="span8">

				<?php
					$header_link = URL::site(
					Route::get('admin')->uri(array(
						'controller' => 'assets'
					)) . '?filter='.$filter.'&direction='.$reverse_direction.'&page='.$pagination->current_page);
				?>

				<?php if ($total_assets === 0){?>
					<p class="alert alert-info">
						<em><?php echo __('No assets have been uploaded.');?></em>
					</p>
				<?php } else { ?>

					
					<?php if (count($assets) === 0){?>
						<p class="alert alert-info">
							<em><?php echo __('No results.');?></em>
						</p>
					<?php } else { ?>

					<table class="table table-bordered table-striped table-scroll">
						<thead>
							<tr>
								<th class="filename">
									<a
										title="Sort by filename"
										href="<?php echo HTML::chars($header_link.'&sort=friendly_filename')?>">
										Filename
										<span class="<?php echo ($order_by == 'filename' AND $direction == 'asc') ? 'caret-up' : 'caret'?>"></span>
									</a>
								</th>
								<th class="type">
									<a
										title="Sort by type"
										href="<?php echo HTML::chars($header_link.'&sort=type')?>">
										Type
										<span class="<?php echo ($order_by == 'type' AND $direction == 'asc') ? 'caret-up' : 'caret'?>"></span>
									</a>
								</th>
								<th class="size">
									<a
										title="Sort by size"
										href="<?php echo HTML::chars($header_link.'&sort=filesize')?>">
										Size
										<span class="<?php echo ($order_by == 'filesize' AND $direction == 'asc') ? 'caret-up' : 'caret'?>"></span>
									</a>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($assets as $asset){?>
							<tr>
								<td>
									<a
										href="<?php echo URL::site(Route::get('admin')->uri(array('controller' => 'assets/popup', 'action' => 'view', 'id' => $asset->id))); ?>"
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
										href="<?php echo URL::site(Route::get('admin')->uri(array('controller' => 'assets', 'action' => 'edit')).'?filter=type-'.$asset->mimetype->type.'&direction='.$direction.'&page='.$pagination->current_page)?>"
										class="asset-type subtype-<?php echo $asset->mimetype->subtype?> type-<?php echo $asset->mimetype->type?>"><?php echo $asset->mimetype->type?></a>
								</td>
								<td>
									<?php echo Text::bytes($asset->filesize)?>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<div class="tab-pane" id="upload">
			<?php echo $upload_html; ?>
		</div>
	</div>
</div>
