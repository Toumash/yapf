<?php
$this->layout('home/_layout');
$this->ViewBag['title'] = 'Self-check | yapf';
$this->ViewBag['page-title'] = 'Self-check';
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
<?php $this->start_section(); ?>
<script>
    // here you can deploy your own scripts which will go to the scripts section on the page
</script>
<?php $this->end_section('scripts'); ?>
