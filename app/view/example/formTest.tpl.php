<?php
$this->layout('example/_layout');
$this->ViewBag['title'] = 'Forms | yapf';
?>
    <div class="page-header">
        <h1>Forms</h1>
    </div>
    <p>AntiForgeryToken</p>
    <form method="post" action="">
        <?php $this->antiForgeryToken(); ?>
        <div class="form-group <?php echo empty($this->ViewBag['form_errors']['name']) ? '' : 'has-error'; ?>">
            <label>Enter your name:
                <input type="text" name="name" class="form-control"/></label>
            <?php if (!empty($this->ViewBag['form_errors']['name'])) {
                echo "<span>", $this->ViewBag['form_errors']['name'], "</span>";
            }
            ?>
        </div>
        <input type="submit" value="ok"/>
    </form>
<?php
foreach ($this->ViewBag['form_errors'] as $error) {
    echo '<span style="color:red;">', $error, '</span>';
}
?>