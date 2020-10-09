<?php
    session_start();
    ob_start();
    require_once "../../config/konekcija.php";
    header("Content-Type: application/json");
    $data = null;
    $code = 404;
    if(isset($_POST['send'])){
        if(isset($_SESSION['user'])){
            $naslov=$_POST['naslov'];
            $poruka=$_POST['poruka'];
            $user=$_SESSION['user']->id_user;
            $movie=$_POST['movie'];

            $greske=[];
            $ispis="";

            if(empty($naslov) || !isset($naslov)){
                $greske[]= "The field for the title is required!";
            }
            if(empty($poruka) || !isset($poruka)){
                $greske[]= "The field for the text of review is required!";
            }

            if(count($greske)){
                foreach($greske as $g){
                    upisGresaka($g);
                    echo json_encode(["message"=>$g]); 
                }
                $code=422;      
            }else{

                $upit="INSERT INTO review VALUES(NULL,:title, :message)";
                    $rez=$konekcija->prepare($upit);
                    $rez->bindParam(":title",$naslov);
                    $rez->bindParam(":message",$poruka);
                
                $upit1="INSERT INTO user_review (id_user_review, id_user, id_review, id_movie) VALUES(NULL,:idU, :idLR, :idM)";
                    $rez1=$konekcija->prepare($upit1);
                    $rez1->bindParam(":idU",$user);
                    $rez1->bindParam(":idLR",$idLR);
                    $rez1->bindParam(":idM",$movie);
                
                    try{
                        $konekcija->beginTransaction();
                        $rez->execute();
                        $idLR = $konekcija->lastInsertId();
                        $rez1->execute();
                        $konekcija->commit();
                            echo json_encode(['message'=> 'Review successfully sent']);
                            $code=201;
                       
                        header("Refresh:0;");
                    }
                    catch(PDOException $e){
                        $konekcija->rollback();
                        echo json_encode(['message'=> $e->getMessage()]);
                        $code=500;
                        upisGresaka($e->getMessage());
                    }
            }

        }else{
            $poruka="You have to login/register in order to write in review";
            $code=404;
        }
http_response_code($code);
 }
?>