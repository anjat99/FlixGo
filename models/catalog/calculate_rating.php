<?php
//  require_once "../config/konekcija.php";
    $id=$_GET['id'];
    $upit="SELECT AVG(value) AS ocena,COUNT(*) AS broj FROM rating_movie WHERE id_movie=:id";

    $priprema=$konekcija->prepare($upit);
    $priprema->bindParam(":id",$id);

    try{
        $priprema->execute();
        $ocena=$priprema->fetch();
        $zaokruzeno=round($ocena->ocena, 1 );
        $broj=$ocena->broj;
        // $glasovi=$ocena->glasovi == 0 ? "zero votes" : $ocena->glasovi;
    }catch(PDOException $e){
        echo $e->getMessage();
        echo "Došlo je do greške";
    }
?>