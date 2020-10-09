<?php
    function getAllAges(){
        return izvrsiUpit("SELECT * from limit_age");
    }

    function getOneAge($id){
        global $konekcija;
        $country=$konekcija->prepare("SELECT * FROM limit_age WHERE id_limit_age=$id");
        $country->execute([$id]);
        return $country->fetch();
    }
