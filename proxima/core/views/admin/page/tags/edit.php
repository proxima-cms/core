<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li>
				<?php echo HTML::anchor(
					Route::get('admin')
						->uri(array(
							'controller' => 'tags',
							'action' => 'delete',
							'id' => $tag->id
						)), __('Delete tag'), array('id' => "delete-tag", 'class' => "button delete small"));
				?>
			</li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<?php echo Form::open(NULL)?>
	<fieldset class="last">
		
		<div class="field">
			<?php echo 
				Form::label('name', __('Name'), NULL, $errors),
				Form::input('name',  $tag->name, NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('slug', __('Slug'), NULL, $errors),
				Form::input('slug', $tag->slug, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>