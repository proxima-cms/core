<div class="row-fluid">
	<div class="span12">
		<ul class="breadcrumb">
			<?php foreach($pages as $c => $page){?>
					<li>
						<?php echo HTML::anchor($page['url'], $page['title'], array('class' => 'active'))?>
						<?php if ($c < count($pages)-1){?>
							<span class="divider">/</span>
						<?php }?>
					</li>
			<?php }?>
		</ul>
	</div>
</div>
