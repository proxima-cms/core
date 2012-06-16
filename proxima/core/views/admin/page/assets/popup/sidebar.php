<?php
	function selected($links, $group, $val = 'selected')
	{
		echo $links['cur_url']. ' test ';
		echo ($links['cur_url'] === $links['links'][$group]) ? $val : NULL;
	}
?>

<?php if ($total_assets > 0){?>
	<!-- FILTERS -->
 	<div class="well sidebar-nav">
		 <ul class="nav nav-list">
			 <li class="nav-header">Filters</li>

			<li class="<?php selected($links, 'all', 'active');?>">
				<a href="<?php echo URL::site($links['links']['all']);?>" class="<?php selected($links, 'all');?>">
					<i class="icon-folder-close"></i>
					All files
				</a>
			</li>
			<li class="<?php selected($links, 'img', 'active');?>">
				<a href="<?php echo URL::site($links['links']['img']);?>" class="<?php selected($links, 'img');?>">
					<i class="icon-folder-close"></i>
					Images
				</a>
			</li>
			<li class="<?php selected($links, 'doc', 'active');?>">
				<a href="<?php echo URL::site($links['links']['doc']);?>" class="<?php selected($links, 'doc');?>">
					<i class="icon-folder-close"></i>
					Documents
				</a>
			</li>
			<li class="<?php selected($links, 'arc', 'active');?>">
				<a href="<?php echo URL::site($links['links']['arc']);?>" class="<?php selected($links, 'arc');?>">
					<i class="icon-folder-close"></i>
					Archives
				</a>
			</li>

			 <li class="nav-header">
				Folders
			</li>
			<li>
				<?php echo Form::select('folders', $folders, $cur_folder);?>
			</li>
		</ul>
	</div>

	<!-- SEARCH -->
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			 <li class="nav-header">Search</li>
			 <li>
		<?php echo Form::open(Route::get('admin')->uri(array('controller' => 'assets/popup')).'?search=1', array('class' => 'ui-helper-clearfix', 'style' => 'padding-bottom:6px;margin:0;'))?>
		<div class="input-append">
			<?php echo Form::input('search', $search, array('class' => 'helper-left', 'style' => 'width: 140px'))?>
			<?php echo Form::button('search-submit', 'Go', array('class' => 'btn'))?>
			</div>
		<?php echo Form::close()?>
		</li>
		</ul>
	</div>
<?php }?>
