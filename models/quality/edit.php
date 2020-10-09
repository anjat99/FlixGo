<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmenaRezolucija'])){
        require_once("../../config/konekcija.php");
    
        $naziv=$_POST['tbNazivRezolucija'];
        $id = $_POST['skrivenoPoljeRezolucija'];
        $greske=[];

        if($naziv==""){
            array_push($greske, "The field of quality name can't be empty!");
        }
        
        if(count($greske)){
            $_SESSION['poruka']="The field of quality name can't be empty!";
        }else{
            global $konekcija;
           
                $upit="UPDATE quality SET value=:naziv WHERE id_quality=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":naziv",$naziv);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="Quality is success updated!";
                    }else{
                        echo "nije uspelo";
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    $_SESSION['poruka']="Error, quality is not updated";
;                }
           
        }
        header("Location:../../views/pages/admin.php?page=quality");
    }
    endif;