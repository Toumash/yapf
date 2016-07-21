<?php
$this->layout('example/_layout');
$this->ViewBag['title'] = 'Examples | yapf';
?>
<div class="page-header">
    <h1>Yapf Examples</h1>
</div>
<p>List of provided examples</p>
<ul>
    <li><a href="/RoutingCheck">Routing check</a></li>
    <li><a href="/example/xmlTest">Xml test</a></li>
    <li><a href="/example/jsonTest">JSON test</a></li>
    <li><a href="/example/status">Return status code</a></li>
    <li><a href="/example/simpleContent?best_framework=yapf">Content string</a></li>
</ul>
