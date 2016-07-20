<?php
$this->layout('home/_layout');
$this->ViewBag['title'] = 'yapf - PHP Framework';
?>
<div class="inner cover">
    <h1 class="cover-heading">yapf</h1>
    <p class="lead">Yet Another PHP Framework.</p>
    <p class="lead">Create your simple pages using simple, lightweight php5 mvc template by toumash</p>
    <p class="lead">
        <a href="https://bitbucket.org/Toumash/yapf" class="btn btn-lg btn-secondary">start today!</a>
    </p>
</div>


<?php $this->start_section(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
<?php $this->end_section('scripts'); ?>
