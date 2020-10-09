<?php
    function getAllQualities(){
        return izvrsiUpit("SELECT * from quality");
    }

    function getOneQuality($id){
        global $konekcija;
        $quality=$konekcija->prepare("SELECT * FROM quality WHERE id_quality=$id");
        $quality->execute([$id]);
        return $quality->fetch();
    }
