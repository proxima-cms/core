
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
		<?php if (count($page->tags)){?>
			<div class="footer clear">
				<div class="tags">
					Tags: 
					<?php 
					$tags_html = array();
					foreach($page->tags as $tag)
					{
						$tags_html[] = HTML::anchor('tag/'.$tag->name, $tag->name);
					}
					echo join($tags_html, ', ')?>
				</div>
			</div>
		<?php }?>

	</div>

<?php }?>

<div class="pagination">
<?php echo $page_links; ?>
</div>
