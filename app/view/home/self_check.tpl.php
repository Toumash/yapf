<?php
$this->layout('');
$this->ViewBag['title'] = 'Routes | yapf';
$this->ViewBag['page-title'] = 'Routes';
?>
<div class="inner cover">
    <h1 class="cover-heading">yapf</h1>
    <p class="lead">Received ID: <?php echo $this->ViewBag['id']; ?></p>
    <p class="lead">If above id is equal to the one specified in the address bar - then routing is set up
        correctly.</p>
    <p class="lead">Author: <?php echo $this->ViewBag['author']; ?></p>
    <p class="lead">
        <a href="https://bitbucket.org/Toumash/yapf" class="btn btn-lg btn-secondary">start today!</a>
    </p>
</div>
<?php $this->startSection(); ?>
<script>
    // here you can deploy your own scripts which will go to the scripts section on the page
</script>
<?php $this->endSection('scripts'); ?>
