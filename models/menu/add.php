<?php
    session_start();
    ob_start();
    header('Content-Type: application/json');
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'){
        if(isset($_POST['btnDodajNavLink'])){
            require_once("../../config/konekcija.php");
                $naziv = $_POST['tbName'];
                $path = $_POST['tbPath'];
                $rezultat = $konekcija->prepare("INSERT INTO menu VALUES (NULL, UPPER(?), ?)");

                $greske=[];

                if($naziv==""){
                    array_push($greske, "The field for name of navlink can't be empty!");
                }
                if($path==""){
                    array_push($greske, "The field for path can't be empty!");
                }
                
                if(count($greske)){
                    $_SESSION['poruka']="The field for name and path can't be empty!";
                }else{
                    try {
                        $rezultat->execute([$naziv,$path]);
                        http_response_code(201); 
                        $_SESSION['poruka']="Successfully created navlink!";
                        header("Refresh:0; url=../../views/pages/admin.php?page=menu");
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                        upisGresaka($e->getMessage());
                        $_SESSION['poruka']="Error-problem with database, navlink is not inserted";
                        http_response_code(500);
                    }
                    header("Refresh:0; url=../../views/pages/admin.php?page=menu");
                }
                
                
        }else{
            http_response_code(400);
        }
        header("Refresh:0; url=../../views/pages/admin.php?page=menu");
    }     