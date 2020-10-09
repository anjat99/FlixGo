<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'){
        if(isset($_POST['btnDodajCountry'])){
            require_once("../../config/konekcija.php");
                $naziv = $_POST['tbNazivDrzave'];
                $rezultat = $konekcija->prepare("INSERT INTO country VALUES (NULL, ?)");

                $greske=[];

                if($naziv==""){
                    array_push($greske, "The field for country name can't be empty!");
                }
                
                if(count($greske)){
                    $_SESSION['poruka']="The field for country name can't be empty!";
                }else{
                    try {
                        $rezultat->execute([$naziv]);
                        http_response_code(201); 
                        $_SESSION['poruka']="Successfully created country!";
                        header("Refresh:0; url=../../views/pages/admin.php?page=country");
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        upisGresaka( $e->getMessage());
                        $_SESSION['poruka']="Error-problem with database, country is not inserted";
                        http_response_code(500);
                    }
                    header("Refresh:0; url=../../views/pages/admin.php?page=country");
                }
                
                
        }else{
            http_response_code(400);
        }
        header("Refresh:0; url=../../views/pages/admin.php?page=country");
    }     