<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmenaDrzava'])){
        require_once("../../config/konekcija.php");
    
        $naziv=$_POST['tbNazivDrzava'];
        $id = $_POST['skrivenoPoljeDrzava'];
        $greske=[];

        if($naziv==""){
            array_push($greske, "The field for country name can't be empty!");
        }
        
        if(count($greske)){
            $_SESSION['poruka']="The field for country name can't be empty!";
        }else{
            global $konekcija;
           
                $upit="UPDATE country SET name=:naziv WHERE id_country=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":naziv",$naziv);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="Country is success updated!";
                    }else{
                        echo "nije uspelo";
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    upisGresaka( $e->getMessage());
                    $_SESSION['poruka']="Error, country is not updated";
;                }
           
        }
        header("Location:../../views/pages/admin.php?page=country");
    }
    endif;