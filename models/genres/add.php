<?php
    session_start();
    ob_start();
    // header('Content-Type: application/json');
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'){
        if(isset($_POST['btnDodajGenre'])){
            require_once("../../config/konekcija.php");
                $naziv = $_POST['tbNazivZanra'];
                $rezultat = $konekcija->prepare("INSERT INTO genre VALUES (NULL, ?)");

                $greske=[];

                if($naziv==""){
                    array_push($greske, "The field of genre name can't be empty!");
                }
                
                if(count($greske)){
                    $_SESSION['poruka']="The field of genre name can't be empty!";
                }else{
                    try {
                        $rezultat->execute([$naziv]);
                        http_response_code(201); 
                           $_SESSION['poruka']="Successfully created genre!";
                        header("Refresh:0; url=../../views/pages/admin.php?page=genres");
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        $_SESSION['poruka']="Error-problem with database, genre is not inserted";
                        http_response_code(500);
                    }
                    header("Refresh:0; url=../../views/pages/admin.php?page=genres");
                }

                
        }else{
            http_response_code(400);
        }
        header("Refresh:0; url=../../views/pages/admin.php?page=genres");
    }     