<h2>Nav</h2>

<ul>
<?php
foreach($pages as $page){?>
	<li><?php echo HTML::anchor($page->uri, $page->title)?></li>
<?php }?>
</ul>
