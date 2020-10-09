<?php
    session_start();
    $code=404;

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['send'])){ 
            $film=$_POST['movie']; 

            require_once("../../config/konekcija.php");
            require_once("functions.php");
            $upit = "DELETE FROM movie WHERE id_movie=:idM";

            $priprema = $konekcija->prepare($upit);
            $priprema->bindParam(":idM",$film);
         
                try{ 
                    $priprema->execute();
                    $code=204; 
                    header("Refresh:0; url=../../views/pages/admin.php?page=movies");
                } catch(PDOException $e){ 
                    $code=409; 
                    upisGresaka($e->getMessage()); 
                    echo $e->getMessage();
                } 
            http_response_code($code); 
        } 
    endif;