<?php
 session_start();
 ob_start();

 $code = 404;

    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
    $uploadDir = 'assets/images/covers/';
        if(isset($_POST['btnAddMovie'])){
                require_once("../../config/konekcija.php");
         
                //text fields
                $title = $_POST['titleAdd'];
                $trailer = $_POST['trailerAdd'];
                $releaseYear = $_POST['releaseY'];
                $duration = $_POST['durationAdd'];
                $description = $_POST['text'];

                //ddl
                $genre=$_POST['genre'];
                $country=$_POST['country'];
                $quality=$_POST['quality'];
                $limitAge=$_POST['age'];

                // var_dump($slika);

                $greske=[];
                


                if(!preg_match("/^\w+(\s\w+)*$/", $title)){
                    $greske[]="The title is not in good format";
                }
                if(!preg_match("/^\d{2,4}$/", $duration)){
                    $greske[]="The duration is not in good format";
                }
                if($title==""){
                    array_push($greske, "The field of title can't be empty!");
                }
                if($trailer==""){
                    array_push($greske, "The field of trailer can't be empty!");
                }
                if($duration==""){
                    array_push($greske, "The field of duration can't be empty!");
                }
                if($description==""){
                    array_push($greske, "The field of description can't be empty!");
                }
                if(empty($genre)){
                    $greske[]="You must choose the genre";
                }
                if(empty($country)){
                    $greske[]="You must choose the country";
                }
                if(empty($quality)){
                    $greske[]="You must choose the quality";
                }
                if(empty($limitAge)){
                    $greske[]="You must choose the limitAge";
                }
                // slika
                $slika = $_FILES['form__img-upload'];
               
                $dozvoljeniTipovi=array("image/jpg", "image/jpeg", "image/png");
                $max_size=3*1024*1024;

                $name=$slika["name"];
                $tmpName=$slika["tmp_name"];
                $size=$slika["size"];
                $type=$slika["type"];

                $filePath = $uploadDir . $name;
                $novNazivUpload = 'assets/images/covers/nova_'.time();
  
                $lokacijaSlike=$_SERVER["DOCUMENT_ROOT"]."/sajt-flixGo/assets/images/covers/";
                $lokacija=$lokacijaSlike.time()."-".$name;
                // $novaLokacija=time()."-".$name;
                // $putanjaZaBazu="assets/images/covers/".$novaLokacija;

                $name  = addslashes($name);
                $filePath  = addslashes($filePath);
                
                if(empty($slika)){
                    $greske[]="You must add a picture of the movie";
                }else{

                    if(!in_array($type, $dozvoljeniTipovi)){
                        $greske[]="Your image format is not supported ($name)";
                    }
                    if($size>$max_size){
                        $greske[]="Your image is bigger then 2MB ($name)";
                    }
                }
            
                

                if(count($greske)){
                    $data=["greske"=>$greske];
                    $code=422;
                    $_SESSION['poruka']="The fields can't be empty and all fields are required!";
                }
                if(move_uploaded_file($tmpName, '../../'.$filePath)){

                     $poX=260;

                    list($sirina,$visina)=getimagesize($filePath);
                    $novaSirina=$poX;

                    $procenat_promene = $novaSirina/$sirina ;
                    $novaVisina = $visina * $procenat_promene;

                    if($type=="image/jpeg" || $type=="image/jpg"){
                        $uploadedSlika=imagecreatefromjpeg($filePath);
                        $image=imagecreatetruecolor($novaSirina,$novaVisina);
                        imagecopyresampled($image,$uploadedSlika,0,0,0,0,$novaSirina,$novaVisina,$sirina,$visina);

                        imagejpeg($image, $novNazivUpload.".jpg", 100);
                    }elseif($type=="image/png"){
                        $uploadedSlika=imagecreatefrompng($filePath);
                        $image=imagecreatetruecolor($novaSirina,$novaVisina);
                        imagecopyresampled($image,$uploadedSlika,0,0,0,0,$novaSirina,$novaVisina,$sirina,$visina);

                        imagepng($image, $novNazivUpload.".png", 100);
                    }
                 
                    $upit1 = "INSERT INTO movie VALUES(NULL,:title, :cover,:description, :trailer, :releaseYear, :duration)";
                    $rez1 = $konekcija->prepare($upit1);
                    $rez1->bindParam(":title", $title);
                    $rez1->bindParam(":cover",  $filePath);
                    $rez1->bindParam(":description", $description);
                    $rez1->bindParam(":trailer", $trailer);
                    $rez1->bindParam(":releaseYear", $releaseYear);
                    $rez1->bindParam(":duration", $duration);
    
                    $upit2 = "INSERT INTO movie_genre VALUES (NULL, :idLM, :genre)";
                    $rez2 = $konekcija->prepare($upit2);
                    $rez2->bindParam(":idLM", $idLM);
                    $rez2->bindParam(":genre", $genre);
    
                    $upit3 = "INSERT INTO movie_country VALUES (NULL, :idLM, :country)";
                    $rez3 = $konekcija->prepare($upit3);
                    $rez3->bindParam(":idLM", $idLM);
                    $rez3->bindParam(":country", $country);
    
                    $upit4 = "INSERT INTO quality_movie VALUES (NULL, :idLM, :quality)";
                    $rez4 = $konekcija->prepare($upit4);
                    $rez4->bindParam(":idLM", $idLM);
                    $rez4->bindParam(":quality", $quality);
    
                    $upit5 = "INSERT INTO country_movie_limit_age VALUES (NULL, :idLM, :limitAge)";
                    $rez5 = $konekcija->prepare($upit5);
                    $rez5->bindParam(":idLM", $idLM);
                    $rez5->bindParam(":limitAge", $limitAge);
    
                    try{
                        $konekcija->beginTransaction();
                        // $rez0->execute();
                        $rez1->execute();
                        $idLM = $konekcija->lastInsertId();
                        $rez2->execute();
                        $rez3->execute();
                        $rez4->execute();
                        $rez5->execute();
                        $konekcija->commit();
                        // echo json_encode(['message'=> 'Movie successfully created']);
                        $_SESSION['poruka']="Successfully created movie!";
                        $code=201;
                        // header("Refresh:0;");
                        header("Refresh:0; url=../../views/pages/admin.php?page=movies");
                    }catch(PDOException $e){
                        $code=500;
                        $konekcija->rollback();
                        // echo json_encode(['message'=> $e->getMessage()]);
                        upisGresaka($e->getMessage());
                        $_SESSION['poruka']="Error on server, movie is not inserted";
                        // http_response_code(500);
                        header("Refresh:0; ");
                    }    
                 
                    // header("Refresh:0; ");
                // }
        }
                
    }
                
           

    endif;
