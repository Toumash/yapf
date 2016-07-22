<?php
$this->layout('');
$this->viewBag['title'] = 'Routes | yapf';
?>
<html>
<head>
    <title><?php echo $this->viewBag['title']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        .container {
            margin: 0 auto;
            width: auto;
            max-width: 680px;
        }

        code {
            margin-top: .5em;
            margin-bottom: 1em;
            padding-left: 1em;
        }

        .code-full {
            display: block;
            width: 100%;
            background-color: aliceblue;
            white-space: pre-wrap;
            font-family: monospace;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Yapf - Routing check</h1>
    </div>
    <p><strong>Parameters:</strong><br/>
        ID: <?php echo $this->viewBag['id']; ?><br/>
        Author: <?php echo $this->viewBag['author']; ?></p>
    <hr/>
    <p>This page is intended to be minimalistic. If you want to look like the main page, then set the theme like that
        and remove css styles.<br/>
        <code class="code-full">$this->layout('');</code>
        to
        <code class="code-full">$this->layout('/home/_layout');</code>
        In case you would like additional css styles on this particular page add code below
        anywhere into the template file (<code>app/view/example/index.tpl.php</code>)
        <code class="code-full">&lt;?php $this->startSection();?&gt;
&lt;style&gt;body{color:aquamarine;}&lt;/style&gt;
&lt;?php $this->endSection('styles');?&gt;</code>
    </p>
</div>
</body>
</html>