<?= implode("\n\t", array_map('HTML::style', $styles)), "\n";?>
<?= implode("\n\t", array_map('HTML::script', $scripts)), "\n" ?>
<script>(function(d,c){d[c]=d[c].replace(/\bno-js\b/, "js");})(document.documentElement,"className");</script>
