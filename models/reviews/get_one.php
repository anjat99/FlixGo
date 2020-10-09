<?php
    session_start();
    $code=404;

    // if(isset($_SESSION['user']) && $_SESSION['user']->role==='user'):
        if(isset($_POST['send'])){ 
            $id=$_POST['id']; 
            $korisnik=$_POST['korisnik']; 
            $film=$_POST['movie']; 

            require_once("../../config/konekcija.php");
            require_once("functions.php");
            $upit = "SELECT u.id_user as korisnik, u.username as username, m.id_movie, m.name as film, ur.date as datumReview, r.title as title, r.message as tekstReview FROM review r INNER JOIN user_review ur ON ur.id_review=r.id_review INNER JOIN movie m ON m.id_movie=ur.id_movie INNER JOIN user u ON u.id_user=ur.id_user  WHERE m.id_movie=:idM AND u.id_user=:idU AND r.id_review=:idR";
            $priprema = $konekcija->prepare($upit);
            $priprema->bindParam(":idM",$film);
            $priprema->bindParam(":idU",$korisnik);
            $priprema->bindParam(":idR",$id);
         
                try{ 
                    $priprema->execute();
                    $review=$priprema->fetch();
                    echo json_encode($review);
                    $code=202; 
                    // header("Refresh:0; url=http://localhost/sajt-pphp/index.php?page=user");
                } catch(PDOException $e){ 
                    $code=409; 
                    upisGresaka($e->getMessage()); 
                    echo $e->getMessage();
                } 
            http_response_code($code); 
        } 
    // endif;