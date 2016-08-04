<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico?" type="image/x-icon"/>

    <title><?php echo $this->viewBag['title']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <?php $this->renderSection('styles'); ?>
    <link rel="stylesheet" href="/css/example.css"/>
</head>

<body>

<!-- Begin page content -->
<div class="container">
    <?php
    $this->renderBody();
    ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">Yapf - Yet Another PHP Framework by Toumash</p>
    </div>
</footer>

<!-- Placed at the end of the document so the pages load faster -->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
<?php $this->renderSection('scripts'); ?>
</body>
</html>
