<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmenaZanr'])){
        require_once("../../config/konekcija.php");
    
        $naziv=$_POST['tbNazivZanr'];
        $id = $_POST['skrivenoPoljeZanr'];
        $greske=[];

        if($naziv==""){
            array_push($greske, "The field of genre name can't be empty!");
        }
        
        if(count($greske)){
            $_SESSION['poruka']="The field of genre name can't be empty!";
        }else{
            global $konekcija;
           
                $upit="UPDATE genre SET name=:naziv WHERE id_genre=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":naziv",$naziv);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="Genre is successfully updated!";
                    }else{
                        echo "nije uspelo";
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    upisGresaka( $e->getMessage());
                    $_SESSION['poruka']="Error, genre is not updated";
;                }
           
        }
        header("Location:../../views/pages/admin.php?page=genres");
    }
    endif;