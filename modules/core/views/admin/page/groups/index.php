<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/groups/add/', __('Add group'))?></li>
		</ul>
	</div>

	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $group){?>
		<tr>
			<td><?php echo $group->id;?></td>
			<td>
				<?php echo HTML::anchor('admin/groups/edit/'.$group->id, $group->name)?>
			</td>
			<td><?php echo $group->friendly_date?></td>
		</tr>
		<?php }?> 
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<div style="float:right"></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> groups
			</td> 
		</tr>   
	</tfoot>   
</table>

<fieldset id="users-information" class="users-information ui-helper-hidden last">
	Showing <span id="total-users"></span> users and groups
</fieldset>
