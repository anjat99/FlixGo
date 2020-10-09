<?php
    header("Content-Type: application/json");
    require_once "../../config/konekcija.php";
    require_once "../functions.php";
    require_once "functions.php";
    $data = null;
    $code = 404;

        if (isset($_POST['send'])) {
            $idZanr = isset($_POST['idZanr']) ? (int)$_POST['idZanr'] : 0;
           
            $sortValue = isset($_POST['sortValue']) ? (int)$_POST['sortValue'] : 0;
           

           $upitZaZanrove = "SELECT m.id_movie, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre GROUP BY m.id_movie";

            if ($idZanr != 0) {
                $brojFilmova = "SELECT COUNT(*) as broj FROM movie m INNER JOIN movie_genre mg ON m.id_movie=mg.id_movie INNER JOIN genre g ON g.id_genre=mg.id_genre WHERE g.id_genre = $idZanr";
            }else {
                $brojFilmova = "SELECT COUNT(*) as broj FROM movie";
            }

            $strana = isset($_POST['strana']) ? intval($_POST['strana']) : 1;
            $poStrani = 6;
            $stmt = $konekcija->query($brojFilmova)->fetch();
            $totalNum = $stmt->broj;
            $numOfPages = ceil($totalNum / $poStrani);
            $offset = ($strana - 1) * $poStrani;


            $upit = "SELECT tmp.* FROM (SELECT m.id_movie as id, m.name as filmName, m.cover as coverName, m.release_year as godina, ROUND(AVG(rm.value),1) as prosek,g.id_genre as genreId, GROUP_CONCAT(DISTINCT g.id_genre SEPARATOR ',') AS genresId ,GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genresName FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie ORDER BY m.id_movie ASC ";

            $test = [];

            if ($idZanr != 0 || $sortValue != 0) {
                $test[] = "prvi if"; 

                    if ($idZanr == 0 && $sortValue != 0) {
                        $test[] = "Prvi if u ifu";
                        $upit .= " LIMIT $poStrani OFFSET $offset) AS tmp ";
                        if ($sortValue == 1) {
                            $test[] = "prvi sort if - name asc";
                            $upit .= "  ORDER BY filmName";
                        } elseif ($sortValue == 2) {
                            $test[] = "prvi sort elseif - name desc"; 
                            $upit .= " ORDER BY filmName DESC";
                        } elseif ($sortValue == 5) {
                            $test[] = "drugi sort elseif - release year asc"; 
                            $upit .= " ORDER BY YEAR(godina)";
                        }elseif ($sortValue == 6) {
                            $test[] = "treci sort elseif - release year desc"; 
                            $upit .= " ORDER BY YEAR(godina) DESC";
                        }                        
                    } elseif($idZanr != 0 && $sortValue == 0) {
                            $upit .= " ) AS tmp WHERE FIND_IN_SET (?, genresId) != 0";           
                            $test[] = "Prvi elseif u ifu";
                    }else{
                        $test[] = "Drugi elseif u ifu";
                        $upit .= " ) AS tmp WHERE FIND_IN_SET (?, genresId) != 0 ";
                        if ($sortValue == 1) {
                            $test[] = "drugi sort if u elsu - name asc";
                            $upit .= " ORDER BY filmName";
                        } elseif ($sortValue == 2) {
                            $test[] = "prvi sort elseif sort if u elsu - name desc"; 
                            $upit .= " ORDER BY filmName DESC";
                        } elseif ($sortValue == 5) {
                            $test[] = "drugi sort elseif sort if u elsu - release year asc"; 
                            $upit .= " ORDER BY YEAR(godina)";
                        }elseif ($sortValue == 6) {
                            $test[] = "treci sort elseif sort if u elsu - release year desc"; 
                            $upit .= " ORDER BY YEAR(godina) DESC";
                        }
                    }
            }

            $stmt = $konekcija->prepare($upit);
            $stmtZanr = $konekcija->prepare($upitZaZanrove);
            
            try {
                $success = $stmtZanr->execute();
                if ($idZanr != 0 || $sortValue != 0) {
                    $test[] = "treci if"; 

                    if ($idZanr == 0 && $sortValue != 0) {
                        $test[] = "drugi if u ifu";
                        $success = $stmt->execute();
                    } else {
                        $test[] = "drugi else"; 
                        $success = $stmt->execute([$idZanr]);
                    }
                } else {
                    $test[] = "treci else";
                    $success = $stmt->execute();
                }

                if($idZanr == 0 && $sortValue == 0){
                    $getGenresAndNoOfPages = postMoviesAndNoOfPages();
                    $getAllMovies = getAllMovies();
                    $test[] = "cetvrti if";

                    $data = ["movie" => $getAllMovies, "numOfPages" => $getMoviesAndNoOfPages['numOfPages'], "strana" => $strana, "test"=>$test];
                } else{
                    if ($success) {
                        $test[] = "Success";
                        $data = ["movie" => $stmt->fetchAll(), "zanrovi"=>$stmtZanr->fetchAll(), "numOfPages" => $numOfPages, "strana" => $strana, "test"=>$test];
                        $code = 201;
                    } else {
                        $code = 409;
                        echo "Lose";
                    }
                }
            } catch (PDOException $e) {
                $code = 500;
                echo $e->getMessage() ."<br/>";
                upisGresaka($e->getMessage());
            }
             
        }
   echo json_encode($data);
    http_response_code($code);
?>