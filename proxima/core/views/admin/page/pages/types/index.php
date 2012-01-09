<div class="action-bar clear">
	<div class="action-menu helper-right">
		<button>Actions</button>
		<ul>
			<li><?php echo HTML::anchor('admin/pages/types/add', __('Add page type'))?></li>
		</ul>
	</div>
	<?php echo $breadcrumbs?>
</div>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Template</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($items as $page_type){?>
		<tr>
			<td><?php echo $page_type->id;?></td>
			<td>
				<?php echo HTML::anchor('admin/pages/types/edit/'.$page_type->id, $page_type->name)?>
			</td>
			<td><?php echo $page_type->template?></td>
			<td><?php echo $page_type->friendly_date?></td>
		</tr>
		<?php }?> 
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<div style="float:right"><?php echo $pagination->render()?></div>
				Showing <?php echo $items->count()?> of <?php echo $total?> page types
			</td> 
		</tr>   
	</tfoot>   
</table>
