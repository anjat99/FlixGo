<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmenaAge'])){
        require_once("../../config/konekcija.php");
    
        $naziv=$_POST['tbNazivLimit'];
        $id = $_POST['skrivenoPoljeLimit'];
        $greske=[];

        if($naziv==""){
            array_push($greske, "The field for value of limit age can't be empty");
        }
        
        if(count($greske)){
            $_SESSION['poruka']="The field for value of limit age can't be empty";
        }else{
            global $konekcija;
           
                $upit="UPDATE limit_age SET value=:naziv WHERE id_limit_age=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":naziv",$naziv);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="Limit of age is success updated!";
                    }else{
                        echo "nije uspelo";
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    upisGresaka( $e->getMessage());
                    $_SESSION['poruka']="Error, limit of age is not updated";
;                }
           
        }
        header("Location:../../views/pages/admin.php?page=limit_ages");
    }
    endif;