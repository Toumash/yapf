<?php
$this->layout('');
$this->ViewBag['title'] = 'Routes | yapf';
$this->ViewBag['page-title'] = 'Routes';
?>
<div class="inner cover">
    <h1 class="cover-heading">yapf</h1>
    <p class="lead"><strong>Parameters:</strong></p>
    <p class="lead">ID: <?php echo $this->ViewBag['id']; ?><br/>
        Author: <?php echo $this->ViewBag['author']; ?></p>
    <p class="lead">This page is intended to be simple text, if you want it to be with layout change line:<br/>
        $this->layout(''); <br/>
        to <br/>
        $this->layout('/home/_layout');</p>
    <p class="lead">
        <a href="https://bitbucket.org/Toumash/yapf" class="btn btn-lg btn-secondary">start today!</a>
    </p>
</div>
<?php $this->startSection(); ?>
<script>
    // here you can deploy your own scripts which will go to the scripts section on the page
</script>
<?php $this->endSection('scripts'); ?>
