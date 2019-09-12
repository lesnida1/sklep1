<?php

//TEST wybór opinie na podstawie kategorii
include '../application/database.class.php';
include '../model/Produkt.class.php';
include '../model/Kategoria.class.php';
include '../libs/Helper.php';
$db = Database::getInstance();
$idKategorii = $_GET['kategoria'];
$login = $_GET['login'];
if ($idKategorii == "Wszystkie") {
    $results = $db::getProduktList();
} else {
    $results = $db::getProduktListByCategory($idKategorii);
}

$response = "<tr><th>Nazwa</th><th>Kategoria</th><th>Ocena</th><th>Opinie</th>";

//TEST sprawdzenie, czy aktywna jest sesja admina
$isAdmin = $db::isUserInRole($login, 'admin');

if ($isAdmin) {
    $response .= "<th>Usuwanie</th>";
} elseif (!empty($login)) {
    $response .= "<th>Dodawanie recenzji</th>";
}

$response .= "</tr>";
foreach ($results as $row) {
    $kategoria = $db::getKategoriaById($row['id_kategorii']);
    $response .= '<tr>';
    $response .= '<td>' . $row['nazwa'] . "</td>";
    $response .= '<td>' . $kategoria->getNazwa() . "</td>";
    $response .= '<td>' . Helper::calculateAverageRating($db::getOpiniaById($row['id_produktu'])) . '</td>';
    $response .= '<td>' . Helper::getOpinions($db::getOpiniaById($row['id_produktu'])) . '</td>';
    if ($isAdmin) {
        $response .= '<td><a href="opinia/delete/?id=' . $row['id_produktu'] . '">Usuń wszystkie opinie i oceny</a></td>';
    } elseif (!empty($login)) {
        $response .= '<td><a href="opinia/add/?id=' . $row['id_produktu'] . '">Dodaj ocenę i opinie</a></td>';
    }
    $response .= "</tr>";
}
echo $response;


