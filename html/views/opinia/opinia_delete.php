<!--TEST potwierdzenie usunięcia wszystkich opinii produktu -->
<h1>Usuń wszystkie opinie</h1>
<h3>Czy na pewno chcesz usunąć opinie dla produktu: <b><?= $produkt->getNazwa() ?></b>?</h3><br />
<form method="POST" action="/<?= APP_ROOT ?>/opinia/delete">
    <input type="hidden" name="id" value="<?= $produkt->getIdProduktu() ?>"/>
    <button class="btn btn-default"  type="submit" name="delete"> Usuń </button>
    <button class="btn btn-default" type="submit" name="cancel" > Anuluj </button><br /><br />
</form>