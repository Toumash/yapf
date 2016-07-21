<?php
$this->layout('');
$this->ViewBag['title'] = 'Routes | yapf';
?>
<h1>yapf</h1>
<p class="lead"><strong>Parameters:</strong></p>
<p class="lead">ID: <?php echo $this->ViewBag['id']; ?><br/>
    Author: <?php echo $this->ViewBag['author']; ?></p>
<p class="lead">This page is intended to be simple text, if you want it to be with layout change line:<br/>
<pre>
    $this->layout('');
    to
    $this->layout('/home/_layout');
    </pre>
<?php $this->startSection(); ?>
<script>
    // here you can deploy your own scripts which will go to the scripts section on the page
</script>
<?php $this->endSection('scripts'); ?>
