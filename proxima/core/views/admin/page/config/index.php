<div class="row-fluid">

<div class="span12">

 <div class="page-header">
 <h1>Configuration</h1>
</div>

<?php echo Form::open(NULL, array('class' => 'form-horizontal'))?>

	<?php foreach($config as $group => $items){?>
	<fieldset>
		<legend><?php echo ucfirst($group)?></legend>
		<?php foreach($items as $item){?>
			 <div class="control-group<?php if (isset($errors['name'])){?> error<?php }?>">

			<?php if ($item->field_type == 'text'){
				echo Form::label("config-{$group}-{$item->config_key}", $item->label, array('class' => 'control-label'), $errors);?>
				<div class="controls"	>
					<?php
					echo Form::input(
						"config-{$group}-{$item->config_key}", 
						Request::current()->post('config-'.$group.'-'.$item->config_key) ?: ( is_array($item->config_value) ? NULL : $item->config_value),
						NULL, 
						$errors
					);
					}?>
				</div>
			</div>
		<?php }?>
				<div class="form-actions">
		<?php echo Form::button('save', 'Save', array('type' => 'submit', 'class' => 'btn btn-primary'))?>
		</div>
	</fieldset>
	<?php }?>
	
<?php echo Form::close()?>
</div>
</div>
