<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/pages/add/'.$page->id, __('Add child page'))?></li>
			<li><?php echo HTML::anchor('admin/pages/delete/'.$page->id, __('Delete page'))?></li>
		</ul>
	</div>
	<script type="text/javascript">
	(function($){
		$('#delete-page').click(function(){

			return confirm('<?php echo __('Are you sure you want to delete this page? All children pages will also be deleted!')?>');
		});
	})(this.jQuery);
	</script>
	<?php echo $breadcrumbs?>
</div>

<?php echo Form::open(NULL)?>

	<fieldset>
		<legend>Metadata</legend>
		<div class="field">
			<?php echo 
				Form::label('title', __('Title'), NULL, $errors).
				Form::input('title', $_POST['title'], NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('uri', __('URI'), NULL, $errors).
				Form::input('uri', $_POST['uri'], NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('description', __('Description'), NULL, $errors).
				Form::input('description', $_POST['description'], NULL, $errors)
			?>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Categorize</legend>
		<div class="field">
			<?php echo 
				Form::label('parent_id', __('Parent page'), NULL, $errors, 'admin/messages/label_error').
				Form::select('parent_id', $pages, Arr::GET($_POST, 'parent_id'), NULL, $errors)
			?>
		</div>
		<div class="field">
			<?php echo 
				Form::label('pagetype_id', __('Page type'), NULL, $errors).
				Form::select('pagetype_id', $pagetypes, Arr::get($_POST, 'pagetype_id'), NULL, $errors)
			?>	
		</div>	
	</fieldset>

	<fieldset>
		<legend>Tags</legend>
		<ul style="margin-left:0">
		<?php foreach($tags as $tag){?>
		<li class="clear" style="list-style:none;padding-bottom:5px;">
			<span style="float:left">
				<?php echo 
					Form::checkbox('tags[]', $tag->id, (bool) Arr::get($_POST, 'tag-'.$tag->id, FALSE) OR in_array($tag->id, $page_tags), array('id'=>'tag-'.$tag->id))
				?>
			</span>
			<span style="float:left">
			<?php echo
				Form::label('tag-'.$tag->id, __($tag->name), NULL, $errors)
			?>	
			</span>
		</li>
		<?php }?> 
	</fieldset>

	
	<fieldset>
		<legend>Publishing</legend>
		<div class="field datepicker-wrapper clear">
			<div class="clear">
				<?php echo 
					Form::label('visible_from', __('Visible from'), NULL, $errors);
				?>
			</div>
			<div>
				<?php echo
					Form::input('visible_from', $_POST['visible_from'], array('class' => 'datepicker'), $errors);
				?>
			</div>
		</div>
		<div class="field datepicker-wrapper clear">
			<div class="clear">
				<?php echo 
					Form::label('visible_to', __('Visible to'), NULL, $errors)
				?>
				<?php 
					$visible_to_forever = ((bool) Arr::get($_POST, 'visible_to_forever') OR Arr::get($_POST, 'visible_to', NULL) === NULL);
					echo 
						Form::checkbox('visible_to_forever', 1, $visible_to_forever, array('style' => 'display:inline'), $errors);
					echo 
						Form::label('visible_to_forever', __('Forever'), NULL, $errors)
				?>
			</div>
			<div>
				<?php echo 
					Form::input('visible_to', $_POST['visible_to'], array('class' => 'datepicker'), $errors);
				?>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend>Content</legend>
		<div class="field">
			<?php echo 
				Form::label('body', __('Body content'), NULL, $errors),
				Form::textarea('body', $_POST['body'], array('class' => 'wysiwyg'), TRUE, $errors)
			?>
		</div>		
	</fieldset>
	<?php echo Form::button('save', 'Update', array('type' => 'submit', 'class' => 'ui-button save'))?>
	
	<div class="helper-right">
	<?php echo Form::button('preview', 'Preview', array('type' => 'submit', 'class' => 'ui-button save'))?>	
	<?php echo Form::button('publish', 'Publish', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</div>
	
<?php echo Form::close()?>
