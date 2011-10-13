<p>
	<em>
		<strong>Note:</strong> Only the latest 50 posts will be imported, and pages will not be imported.
	</em>
</p>

<?php
function alternator(){ } 
?>
<?php echo Form::open() ?>
	<ul>
		<li class="<?php echo alternator('', 'even'); ?>">
			<?php echo Form::label('blog_url', 'Tumblr blog URL'); ?>
			<?php echo Form::input('blog_url', Arr::get($_POST, 'blog_url', 'http://')); ?>
			<small><em>(eg: http://myblog.tumblr.com)</em></small>
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<?php echo Form::label('categories', 'Import tags'); ?>
			<?php echo Form::select('categories', array('1' => 'Yes', '0' => 'No'), Arr::get($_POST, 'categories', '1')) ?>
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<?php echo Form::label('status', 'Publish status'); ?>
			<?php echo Form::select('status', array(
							'1' => __('Draft'), 
							'0' => __('Live')
						), Arr::get($_POST, 'status', 'draft')) ?>
		</li>
	</ul>
	<div class="buttons float-right padding-top">
		<button class="button" value="save" name="btnAction" type="submit">
			<span>Import</span>
		</button>
	</div>
<?php echo Form::close(); ?>
