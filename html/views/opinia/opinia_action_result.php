<?php
//TEST widok rezultatu usuwnia opini i oceny
if (!empty($error)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?>
    </div>
    <?php
} else if (!empty($success)) {
    ?>
    <div class="alert alert-success" role="alert">
        <?= $success ?>
    </div>
    <?php
}
?>
<a href="/<?= APP_ROOT ?>/opinia">Powrót do listy</a>
