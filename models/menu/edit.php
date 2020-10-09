<?php
 session_start();

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
        if(isset($_POST['btnIzmenaNav'])){
        require_once("../../config/konekcija.php");
    
        $naziv=$_POST['tbNameNav'];
        $id = $_POST['skrivenoPoljeNavs'];
        $greske=[];

        if($naziv==""){
            array_push($greske, "The field for navlink  can't be empty");
        }
        
        if(count($greske)){
            $_SESSION['poruka']="The field for navlink  can't be empty";
        }else{
            global $konekcija;
           
                $upit="UPDATE menu SET name=UPPER(:naziv) WHERE id_menu=$id";
                $send=$konekcija->prepare($upit);
                $send->bindParam(":naziv",$naziv);

                try{
                    $uspelo = $send->execute();
                    if($uspelo){
                       $_SESSION['poruka']="Navlink is successfully updated!";
                    }else{
                        echo "nije uspelo";
                    }
                    
                }catch(PDOException $e){
                    echo $e->getMessage();
                    upisGresaka( $e->getMessage());
                    $_SESSION['poruka']="Error, Navlink is not updated";
;                }
           
        }
        header("Location:../../views/pages/admin.php?page=menu");
    }
    endif;