<?php

//TEST kontroler dla zakładki opinie

class opiniaController extends baseController {

    public function index() {

        //TEST połączenie do bazy
        $db = $this->registry->db;

        //TEST pobranie produktow 
        $results = $db::getProduktList();

        //TEST wrzucenie produktów do tablicy, która jest wysyłana do widoku (katalog view) 
        $produkty = array();
        foreach ($results as $row) {
            $produkt = new Produkt();
            $produkt->setIdProduktu($row['id_produktu']);
            $produkt->setNazwa($row['nazwa']);
            $produkt->setCena($row['cena']);
            $produkt->setOpis($row['opis']);
            $produkt->setIdKategorii($row['id_kategorii']);
            $kategoria = $db::getKategoriaById($row['id_kategorii']);
            $produkt->setKategoria($kategoria);
            $produkty[] = $produkt;
        }

        //TEST pobranie kategorii 
        $results = $db::getKategoriaList();

        //TEST wrzucenie kategorii do tablicy, która jest wysyłana do widoku (katalog view) 
        $kategorie = array();
        foreach ($results as $row) {
            $kategoria = new Kategoria();
            $kategoria->setIdKategorii($row['id_kategorii']);
            $kategoria->setNazwa($row['nazwa']);
            $kategorie[] = $kategoria;
        }

        //TEST pobranie opinii 
        $results = $db::getOpiniaList();

        //TEST wrzucenie opinii do tablicy, która jest wysyłana do widoku (katalog view) 
        $opinie = array();
        foreach ($results as $row) {
            $opinia = new Opinia();
            $opinia->setIdOpinii($row['id_opinii']);
            $opinia->setOpinia($row['opinia']);
            $opinia->setOcena($row['ocena']);
            $opinia->setIdProduktu($row['id_produktu']);
            $opinie[] = $opinia;
        }

        //TEST rejestrowanie zmiennych widoku 
        $this->registry->template->produkty = $produkty;
        $this->registry->template->kategorie = $kategorie;
        $this->registry->template->opinie = $opinie;
        $this->registry->template->helper = new Helper();

        //TEST wybranie widoku (opinie)
        $this->registry->template->show('opinia/opinia_index');
    }

    //TEST dodawanie opinii i ocen - funkcja dostępna tylko dla zalogowanego USERA
    public function add() {
        $error = "";
        $success = "";
        $db = $this->registry->db;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //TEST walidacja -> z posta pobieramy wpisaną opinie przez USERA i sprawdzamy czy zawiera tresc
            if (empty($_POST['opinia'])) {
                $error .= 'Uzupełnij pole opinia <br />';
            }

            if (empty($error)) {
                $opinia = new Opinia();
                $opinia->setOcena($_POST['ocena']);
                $opinia->setOpinia(trim($_POST['opinia']));
                $opinia->setIdProduktu($_POST['idProduktu']);

                if ($db::addOpinia($opinia)) {
                    $success .= 'Dodano opinię <br />';
                } else {
                    $error .= 'Dodanie opinii nie powiodło się <br />';
                }
            }

            $this->registry->template->error = $error;
            $this->registry->template->success = $success;
        }

        if (isset($_GET['id'])) {
            $this->registry->template->produkt = $db::getProduktById($_GET['id']);
        }
        $this->registry->template->show('opinia/opinia_add');
    }

    //TEST usunięcie opinii i ocen - funkcja dostępna tylko dla admina
    public function delete() {
        $this->ograniczDostepTylkoDlaAdmina();
        $db = $this->registry->db;

        //TEST łapiemy produkt ID z URL przez tablicę globalną GET
        $error = "";
        $success = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //TEST Jeśli mamy dane POST to wybieramy na podstawie kliknięcia ADMINA (usun/anuluj) co dalej robimy
            if (isset($_POST['delete'])) {
                if ($db::deleteOpiniaByProductId($_POST['id'])) {
                    $success .= 'Usunięto opinie <br />';
                } else {
                    $error .= 'Usuwanie nie powiodło się. <br />';
                }
            } else {
                $location = '/' . APP_ROOT . '/opinia';
                header("Location: $location");
            }
            $this->registry->template->success = $success;
            $this->registry->template->error = $error;
            $this->registry->template->show('opinia/opinia_action_result');
        } else {
            //TEST Jeśli nie mamy danych w POST to lecimy do widoku opinia_delete z potwierdzeniem usuwania
            //TEST przesylamy do widoku obiekt produkt
            $this->registry->template->produkt = $db::getProduktById($_GET['id']);
            $this->registry->template->show('opinia/opinia_delete');
        }
    }

}

?>