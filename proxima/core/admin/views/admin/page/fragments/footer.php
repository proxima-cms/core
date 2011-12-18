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

<script type="text/javascript">
(function(){
	/*
	Admin.init({
		environment: '<?php echo Kohana::$environment?>',
		paths: <?php echo json_encode(array_map('URL::site', $paths))?>,
		route: {
			controller: '<?php echo Request::current()->controller()?>',
			action: '<?php echo Request::current()->action()?>'
		}
	});
	*/
})(this.jQuery);
</script>
