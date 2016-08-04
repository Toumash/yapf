<?php
$this->layout('example/_layout');
$this->viewBag['title'] = 'Examples | yapf';
?>
<div class="page-header">
    <h1>Yapf Examples</h1>
</div>
<p>List of provided examples</p>
<ul>
    <li><a href="/RoutingCheck">Routing check</a></li>
    <li><a href="/subdirectory/whatever/index">Advanced routing (subdirectories) (look at the address bar)</a></li>
    <li><a href="/example/xmlTest">Xml test</a></li>
    <li><a href="/example/jsonTest/5">JSON test</a></li>
    <li><a href="/example/status/418">Return status code</a></li>
    <li><a href="/example/simpleContent?best_framework=yapf">Content string</a></li>
    <li><a href="/example/formTest">Forms</a></li>
</ul>
