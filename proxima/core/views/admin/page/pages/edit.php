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

		<?php echo Form::open(NULL, array('class' => 'form-horizontal tabs', 'id' => 'edit-page'))?>

			<ul class="nav nav-tabs">
				<li><a href="#metadata">Metadata</a></li>
				<li><a href="#publishing">Publishing</a></li>
				<li><a href="#content">Content</a></li>
				<li><a href="#categorize">Categorize</a></li>
				<!-- <li><a href="#routing">Routing</a></li> -->
			</ul>
			 
			<div class="tab-content">

				<div class="tab-pane" id="metadata">
						<fieldset>
							<legend>Metadata</legend>

							<?php echo Form::control_group(array(
								'name' => 'title',
								'label' => __('Title'),
								'type' => 'input',
								'value' => $page->title,
							), $errors);?>

							<?php echo Form::control_group(array(
								'name' => 'uri',
								'label' => __('URI'),
								'type' => 'input',
								'value' => $page->uri,
								'errors' => $errors,
								'help-block' => HTML::anchor('admin/pages/generate_uri?page_id='.$page->id, '[Generate]', array('id' => 'update-uri'))
							), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'description',
								'label' => __('Description'),
								'type' => 'input',
								'value' => $page->description,
							), $errors);?>

						</fieldset>
				</div>

				<div class="tab-pane" id="publishing">
			
						<fieldset>
							<legend>Publishing</legend>

							<?php echo Form::control_group(array(
								'name' => 'visible_in_nav',
								'label' => __('Visible in nav?'),
								'type' => 'select',
								'options' => array('No', 'Yes'),
								'value' => $page->visible_in_nav,
							), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'status',
								'label' => __('Status'),
								'type' => 'select',
								'options' => $statuses,
								'value' => $page->draft,
							), $errors);?>
							
							<?php echo Form::control_group(array(
								'name' => 'visible_from',
								'label' => __('Visible from'),
								'type' => 'input',
								'value' => $page->visible_from,
								'class' => 'datepicker'
							), $errors);?>
							
							<?php 
							$visible_to = $page->visible_to;
							$visible_to_forever = ((bool) Arr::get(Request::current()->post(), 'visible_to_forever') OR !$visible_to);
							$help_block = '<label class="checkbox">'
								.Form::checkbox('visible_to_forever', 1, $visible_to_forever, array('style' => 'display:inline'), $errors)
								.' '.__('Forever')
								.'</label>';
							echo Form::control_group(array(
								'name' => 'visible_to',
								'label' => __('Visible to'),
								'type' => 'input',
								'class' => 'datepicker',
								'value' => $page->visible_to,
								'help-block' => $help_block
							), $errors);?>
						</fieldset>

				</div>
				<div class="tab-pane" id="content">
						<fieldset>
							<legend>Content</legend>
							<div class="control-group">
								<textarea id="body" class="wysiwyg" style="width:90%">
									<?php echo $page->body; ?>
								</textarea>
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
								Form::submit('add-new-tag', __('Add'), array('class' => 'btn'), $errors);
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
		</div>

		<?php echo Form::close()?>
	</div>
</div>
