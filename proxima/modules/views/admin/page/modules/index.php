<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/modules/generate_config', 'Re-generate module data')?></li>
		</ul>
	</div>
	
	<?php echo $breadcrumbs?>
</div>

<h2>Modules</h2>

<ul>
	<?php foreach($modules as $name => $path){?>
		<li>
			<?php echo $name;?> -
			<?php if (in_array($name, $enabled_modules)){?>
				<?php echo HTML::anchor('admin/modules/disable/'.$name, 'Disable');?>
			<?php } else { ?>
				<?php echo HTML::anchor('admin/modules/enable/'.$name, 'Enable');?>
			<?php }?>
		</li>
	<?php }?>
</ul>
