<h1>Dodaj Opinie</h1>
<!--TEST dodawanie opinii -->

<?php
if (!empty($success)) {
    ?>
    <div class="alert alert-success" role="alert">
        <?= $success ?>
    </div>
    <?php
} else {
    if (!empty($error)) {
        ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>

        <?php
    }
    ?>
    <form method="POST" action="/<?= APP_ROOT ?>/opinia/add">
        <div class="form-group">
            <label>Ocena</label>
            <select name="ocena" class="form-control">
                <?php
                for ($i = 0; $i <= 10; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
            <br />
        </div>
        <div class="form-group">
            <label>Opinia </label>
            <input type="text" name="opinia"  class="form-control" /> 
        </div>
        <input type="hidden" name="idProduktu" value="<?php echo $produkt->getIdProduktu() ?>" class="form-control" /> 
        <input type="submit" value="Dodaj" class="btn btn-default"/> <br />
    </form>
    <?php
}
?>