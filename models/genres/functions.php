<?php
    

    function getAllGenres(){
        return izvrsiUpit("SELECT * from genre ");
    }

    function getOneGenre($id){
        global $konekcija;
        $genre=$konekcija->prepare("SELECT * FROM genre WHERE id_genre=$id");
        $genre->execute([$id]);
        // var_dump($genre);
        return $genre->fetch();
    }
