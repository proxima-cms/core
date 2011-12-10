<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li>
				<a href="<?php echo URL::site('admin/tags/delete/'.$tag->id)?>" id="delete-tag" class="button delete small">
					<span>Delete tag</span>
				</a>
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
				Form::input('name', Request::current()->post('name') ?: $tag->name, NULL, $errors)
			?>
		</div>
		
		<div class="field">
			<?php echo 
				Form::label('slug', __('Slug'), NULL, $errors),
				Form::input('slug', Request::current()->post('slug') ?: $tag->slug, NULL, $errors)
			?>
		</div>

		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'ui-button save'))?>
	</fieldset>
<?php echo Form::close()?>
