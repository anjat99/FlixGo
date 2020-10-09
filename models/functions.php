<?php


function showNavigationMenu(){
    global $konekcija;

    $upitZaMeni = "SELECT * FROM menu";
    $rez = $konekcija -> query($upitZaMeni)->fetchAll();
    //   var_dump($rez);
    $ispisMenija = "<ul class=\"header__nav\">";
        foreach($rez as $li){
            // $ispisMenija.="<li><a href=\"$li->putanja\">$li->naziv</a></li>";
            $ispisMenija.="<li class=\"header__nav-item\"> <a href=\"$li->path\" class=\"header__nav-link\">$li->name</a> </li>";
        }
        if(isset($_SESSION['user']) && $_SESSION['user']->role === 'user'){
            $user = $_SESSION['user'];
            $ispisMenija.="<li class=\"header__nav-item\"><a href=\"index.php?page=user\" class=\"korisnikIme header__nav-link\">USER </a></li>";
            // $ispisMenija.="<li class=\"header__nav-item\"><a href=\"models/logout.php\" class=\"header__nav-link\">Logout</a></li>";
        }
        $ispisMenija.="</ul>";
        return $ispisMenija;
}
function dohvatiSocialMedia(){
    return izvrsiUpit("SELECT * FROM social_media");
}

function showNewMovies(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie WHERE YEAR(m.release_year)>=2020 GROUP BY m.id_movie ");
}

function showNewMoviesWithDetails(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,la.value as limit_age, q.value as quality, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN movie_country mc ON m.id_movie=mc.id_movie LEFT JOIN country c ON c.id_country=mc.id_country  LEFT JOIN country_movie_limit_age cmla ON m.id_movie=cmla.id_movie LEFT JOIN limit_age la ON la.id_limit_age=cmla.id_limit_age LEFT JOIN quality_movie qm ON qm.id_movie=m.id_movie LEFT JOIN quality q ON q.id_quality=qm.id_quality LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie WHERE YEAR(m.release_year)>=2020 GROUP BY m.id_movie LIMIT 0,6");
}

function showNewRandomMovies(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,YEAR(m.release_year) as godina, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie HAVING COUNT(genres)<=3 ORDER BY rand() LIMIT 0,6");
}


function showMoviesPremiere(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie WHERE YEAR(m.release_year)>=2019 GROUP BY m.id_movie LIMIT 0,6");
}


function showNewMoviesPremiere(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie WHERE YEAR(m.release_year)>=2019 GROUP BY m.id_movie LIMIT 6,13");
}


function showAllMovies(){
    return izvrsiUpit("SELECT m.*, ROUND(AVG(rm.value),1) as prosek,GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN  movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie ");
}

function sveStranice(){
    return["Home", "About","Contact","Register","Login","Catalog"];
}
   
function pristupStranicamaProcenat(){
    $niz=[];
    $ukupno=0;
    $home=0;
    $about=0;
    $contact=0;
    $register=0;
    $login=0;
    $catalog=0;
    $oneDayAgo=strtotime("1 day ago");
   
    @$file=file(LOG_FAJL);
    if(count($file)){
        foreach($file as $i){
            $delovi=explode("\t",$i);
        //     $url=explode("/",$delovi[0]);
       
        // $strana=explode("/",$url[2]);
         if(strpos($delovi[2],"?")){
                $strana=explode("?",$delovi[2])[1];
            }else{
                 $strana=$delovi[2];
            }
            
    
        if(strpos($strana,"&")){
            $strana = explode("&",$strana)[0];
        }
    
            if(strtotime($delovi[1])>=$oneDayAgo){
                switch($strana){
                    case "":
                        $home++;
                        $ukupno++;
                        break;
                    case "page=home":
                        $home++;
                        $ukupno++;
                        break;
                    case "page=about":
                        $about++;
                        $ukupno++;
                        break;
                    case "page=contact":
                        $contact++;
                        $ukupno++;
                        break;
                    case "page=register":
                        $register++;
                        $ukupno++;
                        break;
                    case "page=login":
                        $login++;
                        $ukupno++;
                        break;
                    case "page=catalog":
                        $catalog++;
                        $ukupno++;
                        break;
                    default:
                        $home++;
                        $ukupno++;
                        break;
                }
            }
        }

        if($ukupno>0){
            $niz[]=round($home*100/$ukupno,2);
            $niz[]=round($about*100/$ukupno,2);
            $niz[]=round($contact*100/$ukupno,2);
            $niz[]=round($register*100/$ukupno,2);
            $niz[]=round($login*100/$ukupno,2);
            $niz[]=round($catalog*100/$ukupno,2);
        }
   
    }
        return $niz;
}
   
function zabeleziLogovanje($id, $email){
    @$open=fopen(LOGOVANJE_KORISNIKA_FAJL,"a");
    $unos=$id."\t".$email."\t".date('d-m-Y H:i:s')."\n";
    @fwrite($open,$unos);
    @fclose($open);
}
   
function brojUlogovanih(){
    return count(file(LOGOVANJE_KORISNIKA_FAJL));
}
   
function izbrisiLogovanje($id){
    $id=(int)$id;
    $unos="";
    @$file=file(LOGOVANJE_KORISNIKA_FAJL);
    if(count($file)){
        foreach($file as $i){
            $iId=trim((int)$i);

            if($iId!=$id){
                $unos.=$iId."\n";
            }
        }
    }

    @$open=fopen(LOGOVANJE_KORISNIKA_FAJL,"w");
    @fwrite($open,$unos);
    @fclose($open);
}
