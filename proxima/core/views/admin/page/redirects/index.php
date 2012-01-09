<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/redirects/add', __('Add redirect'))?></li>
		</ul>
	</div>

	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>URI</th>
			<th>Target</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $redirect){
			$target = ORM::factory($redirect->target, $redirect->target_id);
		?>
		<tr>
			<td><?php echo $redirect->id;?></td>
			<td>
				<?php echo HTML::anchor('admin/redirects/edit/'.$redirect->id, $redirect->uri)?>
			</td>
			<td>
				<?php echo HTML::anchor($target->uri, $target->title)?>
			</td>
			<td><?php echo $redirect->date?></td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<div style="float:right"><?php /* echo $user_links*/?></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> redirects
			</td>
		</tr>
	</tfoot>
</table>
