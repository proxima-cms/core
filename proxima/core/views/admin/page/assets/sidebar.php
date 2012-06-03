<?php
	function selected($links, $group, $val = 'selected')
	{
		echo ($links['cur_url'] === $links['links'][$group]) ? $val : NULL;
	}
?>

<!-- FILTERS -->
 <div class="well sidebar-nav">
	 <ul class="nav nav-list">
		 <li class="nav-header">Filters</li>

		<li class="<?php selected($links, 'all', 'active');?>">
			<a href="<?php echo URL::site($links['links']['all']);?>" class="<?php selected($links, 'all');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				All files
			</a>
		</li>
		<li class="<?php selected($links, 'img', 'active');?>">
			<a href="<?php echo URL::site($links['links']['img']);?>" class="<?php selected($links, 'img');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				Images
			</a>
		</li>
		<li class="<?php selected($links, 'doc', 'active');?>">
			<a href="<?php echo URL::site($links['links']['doc']);?>" class="<?php selected($links, 'doc');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				Documents
			</a>
		</li>
		<li class="<?php selected($links, 'arc', 'active');?>">
			<a href="<?php echo URL::site($links['links']['arc']);?>" class="<?php selected($links, 'arc');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				Archives
			</a>
		</li>
	</ul>
</div>

<!-- ACTIONS -->
<div class="well sidebar-nav">
	<ul class="nav nav-list">
		<li class="nav-header">Actions</li>
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
						Route::get('admin/config')
							->uri(array(
								'group' => 'asset'
							)), __('Config'), array('id' => 'edit-config'));
					?>
				</li>
				<li>
					<?php echo HTML::anchor(
						Route::get('admin/assets-folders')
							->uri(array(
							)), __('Manage folders'));
					?>
				</li>

	</ul>
</div>


<!-- FOLDERS -->
<div class="well sidebar-nav">
	<ul class="nav nav-list">
		 <li class="nav-header">
		<span style="float:right;font-weight:normal;">
			<?php echo HTML::anchor(Route::get('admin')
				->uri(array(
					'controller' => 'assets/folders',
					'action' => 'add'
				)).'?return_to='.Request::current()->uri(), __('Add +'), array('style' => 'font-weight:normal'));?>
			|
			<?php echo HTML::anchor(Route::get('admin')
				->uri(array(
					'controller' => 'assets',
					'action' => 'folders'
				)), __('Manage'), array('style' => 'font-weight:normal'));?>
		</span>
		Folders
	</li>
	<li>
	<?php echo Form::select('folders', $folders, $cur_folder);?>
	</li>
	</ul>

	<script type="text/html" id="folder-uri-template">
		<?php echo $folder_uri_template, "\n" ?>
	</script>
</div>

<!-- SEARCH -->
<div class="well sidebar-nav">
	<ul class="nav nav-list">
		 <li class="nav-header">Search</li>
		 <li>
	<?php echo Form::open(Route::get('admin')->uri(array('controller' => 'assets')), array('class' => 'ui-helper-clearfix', 'style' => 'padding-bottom:6px'))?>
	<div class="input-append">
		<?php echo Form::input('search', $search, array('class' => 'helper-left', 'style' => 'width: 150px'))?>
		<?php echo Form::button('search-submit', 'Go', array('class' => 'btn'))?>
		</div>
	<?php echo Form::close()?>
	</li>
	</ul>
</div>
