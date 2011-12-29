<h1>Admin dashboard</h1>

<fieldset class="dashboard-database">
	<legend>Environment</legend>
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>
		<div>This site is in DEVELOPMENT mode.</div>
	<?php } else if (Kohana::$environment == Kohana::DEVELOPMENT){?>
		<div>This site is in PRODUCTION mode.</div>
	<?php }?>
</fieldset>

<fieldset class="dashboard-database">
	<legend>Database</legend>

	<div><strong>Type:</strong> <?php echo $db_config['type']?></div>
	<div><strong>Name:</strong> <?php echo $db_config['connection']['database']?></div>
</fieldset>

<fieldset class="dashboard-modules last">
	<legend>Enabled Modules</legend>

	<ul>
	<?php foreach($modules as $name => $path){?>
		<li><?php echo $name?></li>
	<?php }?>
	</ul>
</fieldset>
