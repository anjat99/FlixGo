<?php

require "../../config/konekcija.php";
if(isset($_POST['keyword'])){ 
    $keyword = "%".$_POST['keyword']."%"; 

    $findMovieQuery = "SELECT m.id_movie as id, m.name as filmName, m.cover as coverName,  ROUND(AVG(rm.value),1) as prosek, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genresName FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie WHERE m.name LIKE :keyword GROUP BY m.id_movie"; 

    $upitZaZanrove = "SELECT m.id_movie, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre GROUP BY m.id_movie";
        $stmtZanr = $konekcija->prepare($upitZaZanrove);
        $stmtZanr->execute();

    $priprema = $konekcija->prepare($findMovieQuery); 
     $priprema->bindParam(":keyword", $keyword); 
     $filmovi = $priprema->execute(); 
     
     if($filmovi){ 
         $filmovi= $priprema->fetchAll(); 
            echo json_encode(["movie" => $filmovi, "zanrovi"=>$stmtZanr->fetchAll(), "uspeh"=>"Success"]); 
    } 
}