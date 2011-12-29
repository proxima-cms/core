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

	<div class="tabs simple">

		<ul>
			<li><a href="#page-publishing">Publishing &amp; Metadata</a></li>
			<li><a href="#page-content">Content</a></li>
			<li><a href="#page-categorize">Categorize</a></li>
			<li><a href="#page-routing">Routing</a></li>
		</ul>

		<!-- Tab Publishing -->
		<div id="page-publishing">
			<fieldset>
				<legend>Metadata</legend>
				<div class="field">
					<?php echo 
						Form::label('title', __('Title'), NULL, $errors).
						Form::input('title', $page->title, NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php 
						echo 
						Form::label('uri', __('URI'), array('style' => 'display:inline'), $errors);

						echo '&nbsp;&nbsp;&nbsp;'. 
						HTML::anchor('admin/pages/generate_uri?page_id='.$page->id, '[Generate]', array('id' => 'update-uri')).
						'<br/>';
					
						echo
						Form::input('uri', $page->uri, NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php echo 
						Form::label('description', __('Description'), NULL, $errors).
						Form::input('description', $page->description, NULL, $errors)
					?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Publishing</legend>
				<div class="field">
					<?php if ($page_published === TRUE){?>
						<p>
						<img src="/modules/admin/media/img/tick-circle-frame.png" style="float:left;margin-right:4px;" />
						This page is published!</p>
					<?php } else {?>
						<p>
						<img src="/modules/admin/media/img/exclamation-red-frame.png" style="float:left;margin-right:4px;" />
						This page is not published!</p>
					<?php }?>
				</div>
				<div class="field clear">
					<div class="clear">
						<?php echo 
							Form::label('visible_in_nav', __('Visible in nav?'), NULL, $errors);
						?>
					</div>
					<div>
						<?php 
						echo
							Form::select('visible_in_nav', array(
								0 => 'No',
								1 => 'Yes'
							), $page->visible_in_nav, NULL, $errors);
						?>
					</div>
				</div>
				<div class="field clear">
					<div class="clear">
						<?php echo 
							Form::label('status', __('Status'), NULL, $errors);
						?>
					</div>
					<div>
						<?php echo
							Form::select('draft', $statuses, $page->draft, NULL, $errors);
						?>
					</div>
				</div>
				<div class="field datepicker-wrapper clear">
					<div class="clear">
						<?php echo 
							Form::label('visible_from', __('Visible from'), NULL, $errors);
						?>
					</div>
					<div>
						<?php echo
							Form::input('visible_from', $page->visible_from, array('class' => 'datepicker'), $errors);
						?>
					</div>
				</div>
				<div class="field datepicker-wrapper clear">
					<div class="clear">
						<?php echo 
							Form::label('visible_to', __('Visible to'), NULL, $errors)
						?>
						<?php 
							$visible_to = $page->visible_to;
							$visible_to_forever = ((bool) Arr::get(Request::current()->post(), 'visible_to_forever') OR !$visible_to);
							echo 
								Form::checkbox('visible_to_forever', 1, $visible_to_forever, array('style' => 'display:inline'), $errors);
							echo 
								Form::label('visible_to_forever', __('Forever'), NULL, $errors)
						?>
					</div>
					<div>
						<?php echo 
							Form::input('visible_to', $page->visible_to, array('class' => 'datepicker'), $errors);
						?>
					</div>
				</div>
			</fieldset>
		</div>
		
		<!-- Tab Content -->
		<div id="page-content">
			<fieldset>
				<legend>Content</legend>
				<div class="field">
					<div class="hidden">
						<?php echo 
							Form::label('body', __('Body content'), NULL, $errors);
							//Form::textarea('body', Arr::get($_POST, 'body'), array('class' => 'wysiwyg'), TRUE, $errors)
						?>
					</div>
					<div id="body" class="wysiwyg">
						<?php echo $page->body; ?>
					</div>
				</div>		
			</fieldset>
		</div>

		<!-- Tab Categorize -->
		<div id="page-categorize">
			<fieldset>
				<legend>Categorize</legend>
				<div class="field">
					<?php echo 
						Form::label('parent_id', __('Parent page'), NULL, $errors, 'admin/messages/label_error').
						Form::select('parent_id', $pages, $page->parent_id, NULL, $errors)
					?>
				</div>
				<div class="field">
					<?php echo 
						Form::label('pagetype_id', __('Page type'), NULL, $errors).
						Form::select('pagetype_id', $page_types, $page->pagetype_id, NULL, $errors);
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
							Form::checkbox('tags[]', $tag->id, (bool) Request::current()->post('tag-'.$tag->id) ?: FALSE OR in_array($tag->id, $page_tags), array('id'=>'tag-'.$tag->id))
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
		</div>
			
		<!-- Tab Routing -->
		<div id="page-routing">
			<fieldset>
				<legend>Routing</legend>
				<p>Add key matches to convert url sections into request parameters.</p>
				<div class="field">
					<?php echo 
						Form::label('route_uri', __('Route URI'), array('style' => 'display:inline'), $errors).
						'&nbsp;&nbsp;&nbsp;'. 
						HTML::anchor('admin/pages/generate_uri?page_id='.$page->id, '[Generate]', array('id' => 'update-uri')).
						'<br/>'.
						Form::input('route_uri', Arr::get($_POST, 'route_uri'), NULL, $errors)
					?>
				</div>
				<div class="field" style="display:none">
					<?php echo 
						Form::label('route_key1_name', __('Key name'), NULL, $errors).
						Form::input('route_key1_name', Arr::get($_POST, 'route_key1_name'), NULL, $errors)
					?>
					<?php echo 
						Form::label('route_key1_regex', __('Key regex'), NULL, $errors).
						Form::input('route_key1_regex', Arr::get($_POST, 'route_key1_regex'), NULL, $errors)
					?>
				</div>
				<div class="field">
					<button class="ui-button default">
						<span>+ Add key match</span>
					</button>
				</div>
			</fieldset>
		</div>

	</div>

	<?php echo Form::button('save', 'Update', array('type' => 'submit', 'class' => 'ui-button save'))?>
		
	<div class="helper-right">
		<?php echo Form::button('preview', 'Preview', array('type' => 'submit', 'class' => 'ui-button save'))?>	
		<?php echo Form::button('publish', 'Publish', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</div>
		
<?php echo Form::close()?>
