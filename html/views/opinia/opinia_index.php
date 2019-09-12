<h1>Opinie</h1>
<br />
<h3>Wybierz kategorie, aby zobaczyć opinie o produktach:</h3>
<!--TEST wybieramy kategorie produktu, żeby sprawdzić opinie -->
<br />
<div class="form-group">
    <label>Wybierz kategorię</label>
    <select id="kategoria" name="kategoria" class="form-control">
        <option value="Wszystkie">Wszystkie</option>
        <?php
        foreach ($kategorie as $kategoria) {
            echo '<option value="' . $kategoria->getIdKategorii() . '">' . $kategoria->getNazwa() . '</option>';
        }
        ?>
    </select>
    <br />
</div>
<?php
$user = '';
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>
<!--TEST wybieramy kategorie produktu, żeby sprawdzić opinie -->
<div class="table-responsive">
    <input type="hidden" id="sessionUser" value="<?php echo $user ?>"</input>
    <table id="produkty" class="table table-bordered table-hover">
        <tr><th>Nazwa</th><th>Kategoria</th><th>Ocena</th><th>Opinie</th>
            <?php
            global $isAdmin;
            if ($isAdmin) {
                ?>
                <th>Usuwanie</th>
                <?php
            } elseif (!empty($user)) {
                ?>
                <th>Dodawanie recenzji</th>
                <?php
            }
            ?>
        </tr>
        <?php
        foreach ($produkty as $produkt) {
            echo '<tr>';
            echo '<td>' . $produkt->getNazwa() . '</td>';
            echo '<td>' . $produkt->getKategoria()->getNazwa() . '</td>';
            echo '<td>' . Helper::calculateAverageRating($opinie, $produkt->getIdProduktu()) . '</td>';
            echo '<td>' . Helper::getOpinions($opinie, $produkt->getIdProduktu()) . '</td>';
            if ($isAdmin) {
                echo '<td><a href="opinia/delete/?id=' . $produkt->getIdProduktu() . '">Usuń wszystkie opinie i oceny</a></td>';
            } elseif (!empty($user)) {
                echo '<td><a href="opinia/add/?id=' . $produkt->getIdProduktu() . '">Dodaj ocenę i opinie</a></td>';
            }
            echo '<tr>';
        }
        ?>
    </table>
</div>
<br />

<!--TEST skrypt .js, podobny do getProductsByCategory, który obsługuje zmiany kategorii w select -->
<script>
    $("#kategoria").change(function () {
        var kat = $("#kategoria option:selected").val();
        var user = $("#sessionUser").val();

        $.ajax({
            url: 'html/async/getProductsOpinionsByCategory.php',
            type: 'GET',
            data: {
                kategoria: kat,
                login: user
            },
            dataType: "html",
            contentType: 'application/html; charset=utf-8',
            success: function (response) {

                $("#produkty").html(response);
            },
            error: function () {
                alert("error");
            }
        });
    })
</script>
