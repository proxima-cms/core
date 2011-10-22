<?php foreach($pages as $page){?>
	<div class="box post">
		<h2 class="title"><?php echo HTML::anchor($page->uri, $page->title)?></h2>
		<div class="copy clear">
			<?php echo $page->body?>
		</div>
		<div class="footer clear">
			<div class="date">
				Posted: <?php echo $page->date?>
			</div>
		</div>
		<div class="footer clear">
			Tagged: 
			<?php 
				$tags = $page->tags->find_all();
				$anchors = array();
				foreach($tags as $tag)
				{
						$anchors[] = HTML::anchor('tag/'.$tag->slug, $tag->name);
				}
				echo implode($anchors, ', ');
			?>
		</div>
	</div>
<?php }?>
