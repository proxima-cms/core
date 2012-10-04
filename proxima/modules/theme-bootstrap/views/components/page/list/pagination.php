<div class="pagination">
	
	<?php if ($previous_page !== FALSE): ?>
		<span>
		<a href="<?php echo HTML::chars($page->url($previous_page)) ?>">
			<span title="<?php echo __('Previous') ?>">&lt;</span>
		</a>
	<?php else: ?>
		<a href="<?php echo HTML::chars($page->url($previous_page)) ?>">
			<span title="<?php echo __('Previous') ?>"></span>
		</a>
	<?php endif ?>
	

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<span title="page <?php echo $i ?>" class="current"><?php echo $i ?></span>
		<?php else: ?>
			<span title="page <?php echo $i ?>">
				<a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a>
			</span>
		<?php endif ?>

	<?php endfor ?>
	
	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo HTML::chars($page->url($next_page)) ?>">
			<span title="<?php echo __('Next') ?>">&gt;</span>
		</a>
	<?php else: ?>
		<a href="<?php echo HTML::chars($page->url($next_page)) ?>">
			<span title="<?php echo __('Next') ?>"></span>
		</a>
	<?php endif ?>
</div>
