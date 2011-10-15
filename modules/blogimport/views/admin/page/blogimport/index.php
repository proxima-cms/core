<div class="action-bar clear">
	<?php echo $breadcrumbs?>
</div>

<p>
	<em>
		<strong>Note:</strong>
	</em>
</p>
<ul>
	<li>Only the latest 50 posts will be imported</li>
	<li>Pages will not be imported</li>
</ul>

<?php echo Form::open() ?>

	<fieldset>
		<legend>Options</legend>

		<div class="field">
			<?php echo Form::label('service', __('Blog service'), NULL, $errors); ?>
			<?php echo Form::select('service', array(
						'Tumblr' => 'Tumblr', 
						//'Wordpress' => 'Wordpress'
					), Arr::get($_POST, 'service', 'Tumblr'), NULL, $errors) ?>
		</div>

		<div class="field">
			<?php echo Form::label('blog_url', __('Blog URL'), array('style' => 'display:inline-block'), $errors); ?>
			<small><em>(eg: http://myblog.tumblr.com)</em></small><br />
			<?php echo Form::input('blog_url', Arr::get($_POST, 'blog_url', 'http://'), NULL, $errors); ?>
		</div>

		<div class="field">
				<?php echo Form::label('categories', __('Import tags'), NULL, $errors); ?>
				<?php echo Form::select('categories', array('1' => 'Yes', '0' => 'No'), Arr::get($_POST, 'categories', '1'), NULL, $errors) ?>
		</div>

		<div class="field">
			<?php echo Form::label('parent_id', __('Parent page'), NULL, $errors); ?>
			<?php echo Form::select('parent_id', $pages, Arr::get($_POST, 'parent_id'), NULL, $errors); ?>
		</div>

		<div class="field">
			<?php echo Form::label('url_prefix', __('URL prefix'), NULL, $errors); ?>
			<?php echo Form::input('url_prefix', Arr::get($_POST, 'url_prefix'), NULL, $errors); ?>
		</div>

		<div class="field">
			<?php echo Form::label('page_type_id', __('Page type'), NULL, $errors); ?>
			<?php echo Form::select('page_type_id', $page_types, Arr::get($_POST, 'page_type_id')); ?>
		</div>

		<div class="field">
			<?php echo Form::label('status', __('Publish status'), NULL, $errors); ?>
			<?php echo Form::select('status', array(
							'1' => __('Draft'), 
							'0' => __('Live')
						), Arr::get($_POST, 'status', 'draft'), NULL, $errors) ?>
		</div>
		
	</fieldset>
		
	<?php echo Form::button('import', 'Import', array('type' => 'submit', 'class' => 'ui-button save'))?>

<?php echo Form::close(); ?>
