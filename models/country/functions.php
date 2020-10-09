<?php
    function getAllCountries(){
        return izvrsiUpit("SELECT * from country");
    }

    function getOneCountry($id){
        global $konekcija;
        $country=$konekcija->prepare("SELECT * FROM country WHERE id_country=$id");
        $country->execute([$id]);
        return $country->fetch();
    }
