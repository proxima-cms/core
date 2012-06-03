<div class="row-fluid">
	<div class="span7" style="margin:auto;float:none;">
	<div class="page-header">
				<h1>Sign in</h1>
						</div>
	<?php echo View::factory('admin/page/fragments/messages') ?>

		<?php echo Form::open(NULL, array('class' => 'well form-horizontal', 'style' => 'padding-bottom:0;'))?>
			<fieldset>

				<?php echo Form::hidden('return_to', Arr::get($_REQUEST, 'return_to', 'admin'))?>

				<div class="control-group">
					<?php echo Form::label('username', 'Username', array('class' => 'control-label'), $errors);?>
					<div class="controls">
						<?php echo Form::input('username', @$_REQUEST['username'], NULL, $errors);?>
					</div>
				</div>

				<div class="control-group">
					<?php echo Form::label('password', 'Password', array('class' => 'control-label'), $errors); ?>
					<div class="controls">
						<?php echo Form::password('password', NULL, NULL, $errors);?>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<label class="checkbox">
							<?php echo Form::checkbox('remember', 1, TRUE, array('id' => 'remember'));?>
							Remember me
						</label>
					</div>
				</div>


			<div class="form-actions">
				<button class="btn btn-primary" type="submit" style="float:left;margin-right:1em;">
					Sign in
				</button>
				<?php echo HTML::anchor('/admin/auth/reset', __('Reset password'));?>
				|
				<?php echo HTML::anchor('/admin/auth/signup', __('Sign up'));?>
			</div>

			</fieldset>
		<?php echo Form::close()?>
	</div>
</div>
