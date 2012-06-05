
<hr />
<footer>
<p>
	V0.1 - <?php echo Kohana::$environment === Kohana::DEVELOPMENT ? 'Development' : 'Production'; ?> mode [<a href="#">profiler</a>]
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT) {?>
	- {execution_time} - {memory_usage}
	<?php }?>
</p>
</footer>

{profiler}
