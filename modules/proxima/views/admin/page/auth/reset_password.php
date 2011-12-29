<?php echo Form::open()?>
	<fieldset>

		<?php if (!$message_sent){?>

			<?php if ($errors) {?>
				<ul class="errors">
				<?php foreach($errors as $field => $error){?>
					<li><?php echo $error ?></li>
				<?php }?>
				</ul>
			<?php }?>
		
			<div class="field">
				<?php echo 
					Form::label('email', 'Enter your email:'), 
					Form::input('email', Arr::get($_POST, 'email'), array('type' => 'email', 'id'=>'email'))
				?>
			</div>
		
			<?php echo Form::submit('resetpass', 'Reset password', array('class' => 'ui-button default'))?>
	
		<?php } else { ?>

			<div class="form-success">
				 A password reset link has been sent to your email.
			</div>
		<?php }?>

	</fieldset> 
<?php echo Form::close()?>