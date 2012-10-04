<?php foreach ($messages as $message) { ?>
<p class="alert alert-<?php echo $message->type ?>">
  <?php echo $message->text ?>
</p>
<?php } ?>