<div class="action-bar clear">
  <div class="action-menu helper-right">
    <button>Actions</button>
    <ul>
      <li><?php echo HTML::anchor('admin/pagetypes/add', __('Add page type'))?></li>
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
    <?php foreach($pagetypes as $pagetype){?>
    <tr>
      <td><?php echo $pagetype->id;?></td>
      <td>
        <?php echo HTML::anchor('admin/pagetypes/edit/'.$pagetype->id, $pagetype->name)?>
      </td>
      <td><?php echo $pagetype->template?></td>
      <td><?php echo $pagetype->date?></td>
    </tr>
    <?php }?> 
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4">
        <div style="float:right"><?php echo $page_links?></div>
        Showing <?php echo $pagetypes->count()?> of <?php echo $total?> page types
      </td> 
    </tr>   
  </tfoot>   
</table>
