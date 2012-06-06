MIGRATIONS FOR GITHUB_URL



<div class="row-fluid">

	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li><?php echo HTML::anchor(Route::get('admin')->uri(
					array(
						'controller' => 'modules',
						'action' => 'generate_config'
					)), 'Re-generate module data')?></li>
				<li><?php echo HTML::anchor(Route::get('admin')->uri(
					array(
						'controller' => 'modules',
						'action' => 'add'
					)), 'Add new module')?></li>
			</ul>
		</div><!--/.well -->
	</div>

	<div class="span9">
		<div class="page-header">
			<h1>Modules</h1>
		</div>

		<p>Addon modules can add new functionality to the CMS and can be any Kohana 3.2 compatible module.</p>

		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>
							Module
					</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>

		<?php foreach($addon_modules as $name => $path){?>
			<tr>
				<td>
					<?php if (in_array($name, $enabled_modules)){?>
						<?php echo HTML::anchor(Route::get('admin')->uri(
							array('controller' => $name, 'View'))
						, $name); ?>
					<?php } else {?>
						<?php echo $name;?>
					<?php }?>
				</td>
				<td>
					<div class="btn-group">
					<?php if (in_array($name, $enabled_modules)){?>
						<?php echo HTML::anchor(Route::get('admin')->uri(
							array(
								'controller' => 'modules',
								'action' => 'disable'
							)).'/'.$name, __('Disable'), array('class' => 'btn'))?>

					<?php } else { ?>

						<?php echo HTML::anchor(Route::get('admin')->uri(
							array(
								'controller' => 'modules',
								'action' => 'enable'
							)).'/'.$name, 'Enable', array('class' => 'btn'))?>

					<?php }?>
					<?php echo HTML::anchor(Route::get('admin')->uri(
						array(
							'controller' => 'modules',
							'action' => 'remove'
						)).'/'.$name, 'Remove', array('class' => 'btn'))?>
				</div>
			</td>
		</tr>
	<?php }?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						Showing <?php echo count($addon_modules);?> addon modules
					</td> 
				</tr>
			</tfoot>
		</table>

<?php echo HTML::anchor(Route::get('admin')->uri(
				array(
					'controller' => 'modules',
					'action' => 'add'
				)), __('Add module').' &raquo;', array('class' => 'btn'));?>


<!--
<h3>Required modules</h3>
<p>These are the Kohana 3.2 modules that are required by proxima cms.</p>

<ul>
	<?php foreach($default_modules as $name) {?>
		<li><?php echo $name; ?></li>
	<?php } ?>
</ul>
-->

<!--
<h2>Enabled modules</h2>
<p>These are all enabled Kohana 3.2 modules.</p>
<ul>
	<?php foreach($kohana_modules as $name => $path) {?>
		<li><?php echo $name; ?></li>
	<?php } ?>
</ul>
-->


</div></div>

