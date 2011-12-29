<footer>

<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>
	
	<div class="benchmark"> 
		<!--
		{execution_time} - {memory_usage}
		-->
	</div>
	
<?php } else {?>
	<!-- {execution_time} - {memory_usage} -->
<?php }?>

</footer>
