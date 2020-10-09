<?php

function dohvatiPrviZanr(){
    return izvrsiUpit("SELECT * FROM genre ORDER BY name ASC LIMIT 0,1");
}

function dohvatiPrviKvalitet(){
    return izvrsiUpit("SELECT * FROM quality ORDER BY value ASC LIMIT 0,1");
}

function dohvatiJednuKategoriju($id){
    global $konekcija;
    $kategorija=$konekcija->prepare("SELECT * FROM kategorije WHERE idKategorija=$id");
    $kategorija->execute([$id]);
    return $kategorija->fetch();
}


function getAllMovies(){
    return izvrsiUpit("SELECT *, ROUND(AVG(rm.value),1) as prosek,m.id_movie, m.name, m.cover, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie ");
}
function get_all_movies(){
    return izvrsiUpit("SELECT * from movie ");
}
function getAllQualities(){
    return izvrsiUpit("SELECT * from quality");
}
function getAllGenres(){
    return izvrsiUpit("SELECT * from genre ");
}

function getMoviesAndNoOfPages(){
    global $konekcija;
    $broj = "SELECT COUNT(*) as broj FROM movie";
    $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
    $poStrani = 6;
    $totalNum = $konekcija->query($broj)->fetch()->broj;
    $numOfPages = ceil($totalNum/$poStrani);
    $offset = ($strana- 1) * $poStrani;
    $upit = "SELECT *, ROUND(AVG(rm.value),1) as prosek, m.id_movie, m.name, m.cover, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie LIMIT $poStrani OFFSET $offset";
    $rez = $konekcija->query($upit)->fetchAll();
    return ["filmovi"=>$rez,"numOfPages"=>$numOfPages,"totalNum"=> $totalNum,"poStrani" => $poStrani];
   }
function postMoviesAndNoOfPages(){
    global $konekcija;
    $broj = "SELECT COUNT(*) as broj FROM movie";
    $strana = isset($_POST['strana']) ? $_POST['strana'] : 1;
    $poStrani = 6;
    $totalNum = $konekcija->query($broj)->fetch()->broj;
    $numOfPages = ceil($totalNum/$poStrani);
    $offset = ($strana- 1) * $poStrani;
    $upit = "SELECT *, m.id_movie, m.name, m.cover, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre GROUP BY m.id_movie LIMIT $poStrani OFFSET $offset";
    $rez = $konekcija->query($upit)->fetchAll();
    return ["filmovi"=>$rez,"numOfPages"=>$numOfPages,"totalNum"=> $totalNum,"poStrani" => $poStrani];
   }