<?php
	$attributes = ($year == $cur_year) ? array('class' => 'selected open') : NULL;
?>

<li><?php echo HTML::anchor('#year', $year, $attributes); ?>
	<ol<?php echo HTML::attributes($attributes); ?>>
