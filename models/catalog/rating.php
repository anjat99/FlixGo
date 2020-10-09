<?php
    session_start();
    require_once "../../config/konekcija.php";
    header("Content-Type: application/json");
    $data = null;
    $code = 404;
    if(isset($_POST['send'])){
        if(isset($_SESSION['user'])){
            $ocena=$_POST['ocena'];
            $user=$_SESSION['user']->id_user;
            $movie=$_POST['movie'];

            $upit="SELECT * FROM rating_movie WHERE id_user=:idU AND id_movie=:idM";
            $priprema=$konekcija->prepare($upit);
            $priprema->bindParam(":idU",$user);
            $priprema->bindParam(":idM",$movie);

            try{
                $test = $priprema->execute();
                $rezultat=$priprema->fetch();

                if($priprema->rowCount() >=1){
                    // $update="UPDATE rating_movie SET value=:ocena WHERE id_user=:idU AND id_movie=:idM";
                    // $priprema2=$konekcija->prepare($update);
                    // $priprema2->bindParam(":ocena",$ocena);
                    // $priprema2->bindParam(":idU",$user);
                    // $priprema2->bindParam(":idM",$movie);

                    // try{
                    //     $priprema2->execute();
                    //     $data='ok';
                    //     $code=200;
                    // }catch(PDOException $e){
                    //     $data="Greska sa serverom";
                    //     $code=500;
                    // }
                    
                    $data='already voted';
                    $code=409;
                
                }else{
                    $insert="INSERT INTO rating_movie VALUES(null,:idU,:idM,:ocena)";
                    $priprema3=$konekcija->prepare($insert);
              
                    $priprema3->bindParam(":idU",$user);
                    $priprema3->bindParam(":idM",$movie);
                    $priprema3->bindParam(":ocena",$ocena);
                    try{
                        $priprema3->execute();
                        $data='ok';
                        $code=200;
                    }
                    catch(PDOException $e){
                        $code=500;
                echo $e->getMessage() ."<br/>";
                upisGresaka($e->getMessage());
                    }
                }
            }catch(PDOException $e){
                $code=500;
                echo $e->getMessage() ."<br/>";
                upisGresaka($e->getMessage());
            }
        }else{
            $poruka="Morate se ulogovati da biste ocenili proizvod";
            $code=404;
        }
        echo json_encode($data);
http_response_code($code);
 }
