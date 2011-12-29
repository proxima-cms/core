<ul>
<?php foreach($pages as $page){?>
	<li>
		<h3><?php echo HTML::anchor($page->uri, $page->title)?></h3>
		<div>
			<?php echo $page->body?>
		</div>
		<div>
			Tagged: 
			<?php 
				$tags = $page->tags->find_all();
				$anchors = array();
				foreach($tags as $tag)
				{
						$anchors[] = HTML::anchor($tag->slug, $tag->name);
				}
				echo implode($anchors, ', ');
			?>
		</div>
	</li>
<?php }?>
</ul>
