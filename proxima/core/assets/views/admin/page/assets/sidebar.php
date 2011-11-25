<?php
	function selected($links, $group, $val = 'selected')
	{
		echo ($links['cur_url'] === $links['links'][$group]) ? $val : NULL;
	}
?>

<div class="section first clear">
	<h3>Filters</h3>
	<ul class="folder-list">
		<li class="<?php selected($links, 'all', 'ui-state-default ui-corner-all');?>">
			<a href="<?php echo URL::site($links['links']['all']);?>" class="<?php selected($links, 'all');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				All files
			</a>
		</li>
		<li class="<?php selected($links, 'img', 'ui-state-default ui-corner-all');?>">
			<a href="<?php echo URL::site($links['links']['img']);?>" class="<?php selected($links, 'img');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				Images
			</a>
		</li>
		<li class="<?php selected($links, 'doc', 'ui-state-default ui-corner-all');?>">
			<a href="<?php echo URL::site($links['links']['doc']);?>" class="<?php selected($links, 'doc');?>">
				<span class="ui-icon ui-icon-folder-collapsed"></span>
				Documents
			</a>
		</li>
		<li class="<?php selected($links, 'arc', 'ui-state-default ui-corner-all');?>">
			<a href="<?php echo URL::site($links['links']['arc']);?>" class="<?php selected($links, 'arc');?>">
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
	<?php echo Form::open('admin/assets', array('class' => 'ui-helper-clearfix', 'style' => 'padding-bottom:6px'))?>
		<?php echo Form::input('search', $search, array('class' => 'helper-left', 'style' => 'width: 150px'))?>
		<?php echo Form::button('search-submit', 'Go', array('class' => 'helper-left ui-button default'))?>
	<?php echo Form::close()?>
</div>
