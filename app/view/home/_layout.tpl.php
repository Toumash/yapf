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
    <link rel="stylesheet" href="/css/main.css"/>
    <?php $this->renderSection('styles'); ?>
</head>

<body>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand">
                        <?php
                        echo(isset($this->viewBag['page-title'])
                            ? $this->viewBag['page-title']
                            : $this->viewBag['title']);
                        ?>
                    </h3>
                    <nav class="nav nav-masthead">
                        <a class="nav-link" href="/">Home</a>
                        <a class="nav-link" href="/example/">Examples</a>
                        <a class="nav-link" href="https://bitbucket.org/Toumash/yapf/overview">Readme</a>
                    </nav>
                </div>
            </div>
            <?php
            $this->renderBody();
            ?>
            <div class="mastfoot">
                <div class="inner">
                    <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a
                            href="https://twitter.com/mdo">@mdo</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
<?php
$this->renderSection('scripts', false);
?>
</body>
</html>