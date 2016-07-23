<?php
use app\helper\Html;

$this->layout('example/_layout');
$this->viewBag['title'] = 'Forms | yapf';
?>
<div class="page-header">
    <h1>Forms</h1>

</div>
<form method="post" action="">
    <?php $this->antiForgeryToken(); ?>
    <div class="form-horizontal">
        <h4>AntiForgeryToken test</h4>
        <p>Test HTML methods</p>
        <?php Html::exampleLink(); ?>
        <hr/>
        <?php $this->validationSummary('', ['class' => 'text-danger']); ?>
        <div class="form-group">
            <?php $this->labelFor('name', 'enter your name', ['class' => 'control-label col-md-3']); ?>
            <div class="col-md-9">
                <?php
                $this->editorFor('name', isset($this->viewBag['name']) ? $this->viewBag['name'] : 'mike', ['class' => 'form-control']);
                $this->validationMessageFor('name', '', ['class' => 'text-danger']);
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="Save" class="btn btn-default"/>
            </div>
        </div>
    </div>
</form>
