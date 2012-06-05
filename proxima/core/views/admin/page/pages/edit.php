<div class="row-fluid">
	<div class="span3">
		<div class="well sidebar-nav">
			<ul class="nav nav-list">
				<li class="nav-header">Actions</li>
				<li><?php echo HTML::anchor('admin/pages/add/'.$page->id, __('Add child page'))?></li>
				<li><?php echo HTML::anchor('admin/pages/delete/'.$page->id, __('Delete page'))?></li>
			</ul>
		</div><!--/.well -->
		<div class="well sidebar-nav">
		<ul class="nav nav-list">
		<li class="nav-header">Info</li>
		<li>
								<?php if ($page_published === TRUE){?>
									<p>
										<b class="icon-ok"></b>
										This page is published.
									</p>
								<?php } else {?>
									<p>
										<b class="icon-warning-sign"></b>
										This page is not published.
									</p>
								<?php }?>
								</li>
								</ul>
		</div>
	</div><!--/span-->

	<div class="span9">

		<div class="page-header">
			<h1>Edit page</h1>
		</div>

		<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>

			<ul class="nav nav-tabs">
				<li class="active"><a href="#metadata">Metadata</a></li>
				<li><a href="#publishing">Publishing</a></li>
				<li><a href="#content">Content</a></li>
				<li><a href="#categorize">Categorize</a></li>
				<!-- <li><a href="#routing">Routing</a></li> -->
			</ul>
			 
			<div class="tab-content">

				<div class="tab-pane active" id="metadata">

						<fieldset>
							<legend>Metadata</legend>
							<div class="control-group">
								<?php echo Form::label('title', __('Title'), array('class' => 'control-label'), $errors);?>
								<div class="controls">
									<?php echo Form::input('title', $page->title, NULL, $errors) ?>
								</div>
							</div>
							<div class="control-group">
								<?php
									echo
									Form::label('uri', __('URI'), array('class' => 'control-label', 'style' => 'display:inline'), $errors);
								?>
								<div class="controls">
								<?php 
									echo
									Form::input('uri', $page->uri, NULL, $errors)
								?>
								<div class="help-block">
								<?php echo  
									HTML::anchor('admin/pages/generate_uri?page_id='.$page->id, '[Generate]', array('id' => 'update-uri'));
									?>
									</div>
								</div>
							</div>
							<div class="control-group">
								<?php echo Form::label('description', __('Description'), array('class' => 'control-label'), $errors);?>
								<div class="controls">
									<?php echo Form::input('description', $page->description, NULL, $errors); ?>
								</div>
							</div>
						</fieldset>
				</div>

				<div class="tab-pane" id="publishing">
			
						<fieldset>
							<legend>Publishing</legend>
							<div class="control-group">
								<div class="controls">
</div>
							</div>
							<div class="control-group">
								<?php echo
									Form::label('visible_in_nav', __('Visible in nav?'), array('class' => 'control-label'), $errors);
								?>
								<div class="controls">
									<?php
									echo
										Form::select('visible_in_nav', array(
											0 => 'No',
											1 => 'Yes'
										), $page->visible_in_nav, NULL, $errors);
									?>
								</div>
							</div>
							<div class="control-group">
								<?php echo
									Form::label('status', __('Status'), array('class' => 'control-label'), $errors);
								?>
								<div class="controls">
									<?php echo
										Form::select('draft', $statuses, $page->draft, NULL, $errors);
									?>
								</div>
							</div>
							<div class="control-group datepicker-wrapper clear">
									<?php echo
										Form::label('visible_from', __('Visible from'), array('class' => 'control-label'), $errors);
									?>
								<div class="controls">
									<?php echo
										Form::input('visible_from', $page->visible_from, array('class' => 'datepicker'), $errors);
									?>
								</div>
							</div>
							<div class="control-group datepicker-wrapper clear">
									<?php echo
										Form::label('visible_to', __('Visible to'), array('class' => 'control-label'), $errors)
									?>
								<div class="controls">
									<?php
										$visible_to = $page->visible_to;
										$visible_to_forever = ((bool) Arr::get(Request::current()->post(), 'visible_to_forever') OR !$visible_to);?>
										<label class="checkbox">
										<?php echo
											Form::checkbox('visible_to_forever', 1, $visible_to_forever, array('style' => 'display:inline'), $errors).
											__('Forever')
											
									?></label>
									<?php echo
										Form::input('visible_to', $page->visible_to, array('class' => 'datepicker'), $errors);
									?>
								</div>
							</div>
						</fieldset>

				</div>
				<div class="tab-pane" id="content">

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
				<div class="tab-pane" id="categorize">

						<fieldset>
							<legend>Categorize</legend>
							<div class="control-group">
								<?php echo Form::label('parent_id', __('Parent page'), array('class' => 'control-label'), $errors); ?>
								<div class="controls">
									<?php echo Form::select('parent_id', $pages, $page->parent_id, NULL, $errors) ?>
								</div>
							</div>
							<div class="control-group">
								<?php echo Form::label('pagetype_id', __('Page type'), array('class' => 'control-label'), $errors);?>
								<div class="controls">
									<?php echo Form::select('pagetype_id', $page_types, $page->pagetype_id, NULL, $errors); ?>
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Tags</legend>
							<div class="control-group">
							<?php echo Form::label('new-tag', __('New tag'), array('class' => 'control-label'), $errors);?>
								<div class="controls">
								<?php echo Form::input('new-tag', '', NULL, $errors); ?>

							<?php echo
								Form::submit('add-new-tag', __('Add'), array('class' => 'ui-button save'), $errors);
							?>
							</div>
							</div>
							<div class="control-group">
							<label class="control-label">
								<?php echo __('Tags');?>
							</label>
								
								<div class="controls">
									<?php foreach($tags as $tag){?>
									<label class="checkbox">
									<?php echo
										Form::checkbox('tags[]', $tag->id, (bool) Request::current()->post('tag-'.$tag->id) ?: FALSE OR in_array($tag->id, $page_tags), array('id'=>'tag-'.$tag->id)).
										__($tag->name)
									?>
									</label>
							<?php }?>
								</div>
						</fieldset>

				</div>
				<div class="tab-pane" id="routing">

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
			</div>

		<div class="form-actions">
			<?php echo Form::submit('save', __('Update'), array('class' => 'btn btn-primary'))?>
				<?php echo Form::submit('preview', __('Preview'), array('class' => 'btn'))?>
				<?php echo Form::submit('publish', __('Publish'), array('class' => 'btn'))?>
		</div>

		<?php echo Form::close()?>
	</div>
		</div>
