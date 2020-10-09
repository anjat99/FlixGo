<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'){
        if(isset($_POST['btnDodajQuality'])){
            require_once("../../config/konekcija.php");
                $naziv = $_POST['tbNazivRezolucije'];
                $rezultat = $konekcija->prepare("INSERT INTO quality VALUES (NULL, ?)");

                $greske=[];

                if($naziv==""){
                    array_push($greske, "The field of quality name can't be empty!");
                }
                
                if(count($greske)){
                    $_SESSION['poruka']="The field of quality name can't be empty!";
                }else{
                    try {
                        $rezultat->execute([$naziv]);
                        http_response_code(201); 
                        $_SESSION['poruka']="Successfully created quality!";
                        header("Refresh:0; url=../../views/pages/admin.php?page=quality");
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        $_SESSION['poruka']="Error, quality is not inserted";
                        http_response_code(500);
                    }
                    header("Refresh:0; url=../../views/pages/admin.php?page=quality");
                }
               
                
        }else{
            http_response_code(400);
        }
        header("Refresh:0; url=../../views/pages/admin.php?page=quality");
    }     