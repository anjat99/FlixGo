<?php
session_start();
ob_start();
require_once("../../config/konekcija.php");
require_once("functions.php");
require_once "../functions.php";
$data=null;
$code=404;
header("Content-type:application/json");

    if(isset($_POST['kliknuto'])):
        $strana = isset($_POST['strana']) ? intval($_POST['strana']) : 1;
        $upitZaZanrove = "SELECT m.id_movie, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre GROUP BY m.id_movie";
        $stmtZanr = $konekcija->prepare($upitZaZanrove);
            try{

                $getMoviesAndNoOfPages = postMoviesAndNoOfPages();
                $test[] = "success";

                $data=["movie" => getAllMovies(),"numOfPages" => $getMoviesAndNoOfPages['numOfPages'], "strana" => $strana, "zanrovi"=>$stmtZanr->fetchAll(),"uspex"=>"dohvaceniSviFilmovi", "test"=>$test];
                $code=200;
            }catch(PDOException $e){
                $code=500;
                $data=["greska"=>$e->getMessage()];
                echo $e->getMessage();
            }
        echo json_encode($data);
        http_response_code($code);
    endif;
