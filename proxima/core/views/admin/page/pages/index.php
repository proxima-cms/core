<div class="row-fluid">
	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor('admin/pages/add', __('Add page'))?></li>
				<li><?php echo HTML::anchor('admin/pages/types', __('Manage types'))?></li>
				<li><?php echo HTML::anchor('admin/redirects', __('Page redirects'))?></li>
			</ul>
		</div><!--/.well -->
	</div><!--/span-->

	<div class="span9">

   <div class="page-header">
      <h1>Pages</h1>
    </div>

		<?php echo $pages_tree; ?>
	</div>
</div>
