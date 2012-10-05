<div class="navbar navbar-fixed-top" id="navbar">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="/">
        Site name
      </a>
      <nav class="nav-collapse">
       <ul class="nav">
        <?php
        foreach($pages as $page){?>
          <li><?php echo HTML::anchor($page->uri, $page->title)?></li>
        <?php }?>
        </ul>
      </nav>
    </div>
  </div>
</div>