<?php
	$attributes = ($month == $cur_month) ? array('class' => 'selected open') : NULL;
?>

<li><?php echo HTML::anchor('#month', $month, $attributes); ?>
	<ol<?php echo HTML::attributes($attributes); ?>>
