<div class="action-bar clear">
  <div class="action-menu helper-right">
    <button>Actions</button>
    <ul>
      <li><?php echo HTML::anchor('admin/tags/add', __('Add tag'))?></li>
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
    <?php foreach($tags as $tag){?>
    <tr>
      <td><?php echo $tag->id;?></td>
      <td>
        <?php echo HTML::anchor('admin/tags/edit/'.$tag->id, $tag->name)?>
      </td>
      <td><?php echo $tag->date?></td>
    </tr>
    <?php }?> 
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">
        <div style="float:right"><?php echo $page_links?></div>
        Showing <?php echo $tags->count()?> of <?php echo $total?> tags
      </td> 
    </tr>   
  </tfoot>   
</table>
