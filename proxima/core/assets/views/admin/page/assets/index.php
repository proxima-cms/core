<div class="clear">
	<div class="action-bar">
		<div class="action-menu helper-right">
			<button>Actions</button>
			<ul>
				<li><?php echo HTML::anchor('admin/assets/upload', __('Upload assets'))?></li>
				<li><?php echo HTML::anchor('admin/config/asset', __('Edit config'), array('id' => 'edit-config'))?></li>
				<li><?php echo HTML::anchor('admin/assets/delete', __('Delete assets'), array('id' => 'delete-assets'))?></li>
			</ul>
		</div>
	</div>	

	<?php echo $breadcrumbs?>
</div>
<br/>

<?php

	$filters_link = 'admin/assets?direction='.$direction;

	$c = array(
		'links' => array(
			'all' => $filters_link,
			'img' => $filters_link.'&filter=subtype-image',
			'doc' => $filters_link.'&filter=type-pdf|doc|txt',
			'arc' => $filters_link.'&filter=type-tar|zip|rar'
		),
		'cur_url' => Request::current()->uri() . URL::query()
	);

	function clean($url)
	{
		$url = preg_replace('/(direction|page)=[\w|\d]+&?/', '', $url);
		$url = preg_replace('/\?$/', '', $url);
		
		return urldecode($url);
	}

	function selected($c, $group, $val = 'selected')
	{
		echo (clean($c['cur_url']) === clean($c['links'][$group])) ? $val : NULL;
	}

?>

<div class="clear assetmanager popup">

	<div class="sidepane" style="width:25%">
		
		<div class="section first clear">
			<h3>Filters</h3>
			<ul class="folder-list">
				<li class="<?php selected($c, 'all', 'ui-state-default ui-corner-all');?>">
					<a href="<?php echo URL::site($c['links']['all']);?>" class="<?php selected($c, 'all');?>">
						<span class="ui-icon ui-icon-folder-collapsed"></span>
						All files
					</a>
				</li>
				<li class="<?php selected($c, 'img', 'ui-state-default ui-corner-all');?>">
					<a href="<?php echo URL::site($c['links']['img']);?>" class="<?php selected($c, 'img');?>">
						<span class="ui-icon ui-icon-folder-collapsed"></span>
						Images
					</a>
				</li>
				<li class="<?php selected($c, 'doc', 'ui-state-default ui-corner-all');?>">
					<a href="<?php echo URL::site($c['links']['doc']);?>" class="<?php selected($c, 'doc');?>">
						<span class="ui-icon ui-icon-folder-collapsed"></span>
						Documents
					</a>
				</li>
				<li class="<?php selected($c, 'arc', 'ui-state-default ui-corner-all');?>">
					<a href="<?php echo URL::site($c['links']['arc']);?>" class="<?php selected($c, 'arc');?>">
						<span class="ui-icon ui-icon-folder-collapsed"></span>
						Archives
					</a>
				</li>
			</ul>
		</div>
		<div class="section clear">
			<h3>Folders</h3>
			<select id="folders">
				<option value="">Root</option>
				<option value="test">--Test</option>
			</select>
		</div>
		<div class="section clear">
			<h3>Search</h3>
			<?php echo Form::open()?>
				<?php echo Form::input('search', '', array('class' => 'helper-left', 'style' => 'width: 124px'))?>
				<?php echo Form::button('search', 'Go', array('class' => 'helper-left ui-button default'))?>
			<?php echo Form::close()?>
		</div>
	</div>

	<?php $header_link = URL::site('admin/assets?filter='.$filter.'&direction='.$reverse_direction.'&page='.$pagination->current_page)?>

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
						<?php echo $asset->date?>
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
	</div>	
</div>