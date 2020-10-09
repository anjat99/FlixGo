<?php
    function getAllNavLinks(){
        return izvrsiUpit("SELECT * from menu");
    }

    function getOneNavLink($id){
        global $konekcija;
        $menu=$konekcija->prepare("SELECT * FROM menu WHERE id_menu=$id");
        $menu->execute([$id]);
        return $menu->fetch();
    }
