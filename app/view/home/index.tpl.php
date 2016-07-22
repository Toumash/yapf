<?php
$this->layout('home/_layout');
$this->viewBag['title'] = 'Home | yapf';
$this->viewBag['page-title'] = 'Home';
?>
<div class="inner cover">
    <h1 class="cover-heading">yapf</h1>
    <p class="lead">Yet Another PHP Framework.</p>
    <p class="lead">Create your simple pages using simple, lightweight php5 mvc template by toumash</p>
    <p class="lead">
        <a href="https://bitbucket.org/Toumash/yapf" class="btn btn-lg btn-secondary">start today!</a>
    </p>
</div>

<?php $this->startSection(); ?>
<script>
    // here you can deploy your own scripts which will go to the scripts section on the page
</script>
<?php $this->endSection('scripts'); ?>
