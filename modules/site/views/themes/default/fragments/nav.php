<h2>Nav</h2>

<ul>
<?php
$pages = ORM::factory('page')->where('parent_id', '=', 0)->find_all();
foreach($pages as $page){?>
	<li><?php echo HTML::anchor($page->uri, $page->title)?></li>
<?php }?>
</ul>
