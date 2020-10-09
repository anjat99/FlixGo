<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'){
        if(isset($_POST['btnDodajLimitAge'])){
            require_once("../../config/konekcija.php");
                $naziv = $_POST['tbNazivOgranicenjaGodina'];
                $rezultat = $konekcija->prepare("INSERT INTO limit_age VALUES (NULL, ?)");

                $greske=[];

                if($naziv==""){
                    array_push($greske, "The field for value of limit age can't be empty!");
                }
                
                if(count($greske)){
                    $_SESSION['poruka']="The field for value of limit age can't be empty!";
                }else{
                    try {
                        $rezultat->execute([$naziv]);
                        http_response_code(201); 
                        $_SESSION['poruka']="Successfully created limit-age!";
                        header("Refresh:0; url=../../views/pages/admin.php?page=limit_ages");
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        upisGresaka($e->getMessage());
                        $_SESSION['poruka']="Error-problem with database, limit-age is not inserted";
                        http_response_code(500);
                    }
                    header("Refresh:0; url=../../views/pages/admin.php?page=limit_ages");
                }
                
                
        }else{
            http_response_code(400);
        }
        header("Refresh:0; url=../../views/pages/admin.php?page=limit_ages");
    }     