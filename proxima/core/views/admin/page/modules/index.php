<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
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
	</div>

	<?php echo $breadcrumbs?>
</div>

<h2>Proxima Modules</h2>
<p>These are the Kohana 3.2 modules that are required by proxima cms.</p>

<ul>
	<?php foreach($default_modules as $name) {?>
		<li><?php echo $name; ?></li>
	<?php } ?>
</ul>

<h2>Enabled Modules

</h2>
<p>These are all enabled Kohana 3.2 modules.</p>
<ul>
	<?php foreach($kohana_modules as $name => $path) {?>
		<li><?php echo $name; ?></li>
	<?php } ?>
</ul>

<h2>Addon modules

			[<?php echo HTML::anchor(Route::get('admin')->uri(
				array(
					'controller' => 'modules',
					'action' => 'add'
				)), 'Add module')?>]
</h2>

<p>Addon modules can add new functionality to the proxima core, or can be any Kohana 3.2 compatible module.</p>

<ul>
	<?php foreach($addon_modules as $name => $path){?>
		<li>
			<?php echo $name;?> -
			<?php if (in_array($name, $enabled_modules)){?>

				<?php echo HTML::anchor(Route::get('admin')->uri(
					array('controller' => $name, 'View'))
				, __('View')); ?>
				|
				<?php echo HTML::anchor(Route::get('admin')->uri(
					array(
						'controller' => 'modules',
						'action' => 'disable'
					)).'/'.$name, 'Disable')?>

			<?php } else { ?>

				<?php echo HTML::anchor(Route::get('admin')->uri(
					array(
						'controller' => 'modules',
						'action' => 'enable'
					)).'/'.$name, 'Enable')?>

			<?php }?>
			|
			<?php echo HTML::anchor(Route::get('admin')->uri(
				array(
					'controller' => 'modules',
					'action' => 'remove'
				)).'/'.$name, 'Remove')?>
		</li>
	<?php }?>
</ul>
