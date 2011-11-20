<div class="action-bar clear">
  <div class="action-menu helper-right">
    <button>Actions</button>
    <ul>
      <li><?php echo HTML::anchor('admin/tags/add', __('Add tag'))?></li>
      <li><?php echo HTML::anchor('admin/tags', __('Delete tags'), array('id' => 'delete-tags'))?></li>
    </ul>
  </div>
  <?php echo $breadcrumbs?>
</div>

<table>
  <thead>
    <tr>
      <th>
				<label for="tag-all">
					<?php echo Form::checkbox('tag-all', '1', FALSE); ?>
					Name
				</label>
			</th>
			<th>Date</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($tags as $tag){?>
    <tr>
			<td>
				<?php echo Form::checkbox('tag-'.$tag->id, '1', FALSE); ?>
        <?php echo HTML::anchor('admin/tags/edit/'.$tag->id, $tag->name)?>
      </td>
      <td><?php echo $tag->date?></td>
    </tr>
    <?php }?> 
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2">
        <div style="float:right"><?php echo $page_links?></div>
        Showing <?php echo $tags->count()?> of <?php echo $total?> tags
      </td> 
    </tr>   
  </tfoot>   
</table>
