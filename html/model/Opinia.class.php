<?php

//TEST model Opinia 

class Opinia {

    //TEST atrybuty
    private $idOpinii;
    private $ocena;
    private $opinia;
    public $idProduktu;

    //TEST pobierz id opinii
    public function getIdOpinii() {
        return $this->idOpinii;
    }

    //TEST ustaw id opinii
    public function setIdOpinii($idOpinii) {
        $this->idOpinii = $idOpinii;
    }

    //TEST pobierz opinie
    public function getOpinia() {
        return $this->opinia;
    }

    //TEST ustaw opinie
    public function setOpinia($opinia) {
        $this->opinia = $opinia;
    }

    //TEST pobierz ocene
    public function getOcena() {
        return $this->ocena;
    }

    //TEST ustaw ocene 
    public function setOcena($ocena) {
        $this->ocena = $ocena;
    }

    //TEST pobierz id produktu
    public function getIdProduktu() {
        return $this->idProduktu;
    }

    //TEST ustaw id produktu
    public function setIdProduktu($idProduktu) {
        $this->idProduktu = $idProduktu;
    }

}

?>