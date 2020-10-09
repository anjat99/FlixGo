<?php
ob_start();
//  require_once '../../config/konekcija.php';
//  include "../catalog/functions.php";
//  $movies = getAllMovies();

//     $excelApp = new COM("Excel.Application");
//     $excelApp->Visible = true;
//     $excelFile = $excelApp->Workbooks->Add();
//     $worksheet = $excelFile->Worksheets("Sheet1"); 
   
//     $rb = 0;
//     $count = count($movies);

//     $poljeA1 = $worksheet->Range("A1");
//     $poljeA1->activate;
//     $poljeA1->Value = "Movie Title";
//     $poljeB1 = $worksheet->Range("B1");
//     $poljeB1->activate;
//     $poljeB1->Value = "Movie Release Date";

//     for ($i = 2; $i <= $count; $i++) {
//         if ($rb == $count) 
//             break;
//         $poljeA = $worksheet->Range("A" . $i);
//         $poljeA->activate;
//         $poljeA->Value = $movies[$rb]->name;
//         $poljeB = $worksheet->Range("B" . $i);
//         $poljeB->activate;
//         $poljeB->Value = $movies[$rb]->release_year;
//         $rb++;
//     }

//     $excelFile->_SaveAs("movies" . time() . ".xlsx");
//     $excelFile->Save();
//     $excelFile->Saved = true;
//     $excelFile->Close;
//     $excelApp->Workbooks->Close();
//     $excelApp->Quit();

// unset($polje);
// unset($excelFile);
// unset($excelApp);

// header("Location:../../views/pages/admin.php?page=movies");

// ob_start();

/// proba 222
// require_once "../../config/konekcija.php";
// include "../catalog/functions.php";

//     $movies = getAllMovies();
//     $excelApp = new COM("Excel.Application");
//     $excelApp->Visible = 1;
//     $excel_file=$excelApp->Workbooks->Add();
//     $worksheet=$excel_file->Worksheets("Sheet1");

//     $poljeA1 = $worksheet->Range("A1");
//     $poljeA1->activate;
//     $poljeA1->Value = "Movie Title";
//     $poljeB1 = $worksheet->Range("B1");
//     $poljeB1->activate;
//     $poljeB1->Value = "Genres of movie";
//     $poljeC1 = $worksheet->Range("C1");
//     $poljeC1->activate;
//     $poljeC1->Value = "Movie Release Date";

//         $rb = 2;
//         foreach($movies as $m){
//             $fieldA = $worksheet->Range("A{$rb}");
//             $fieldA->activate;
//             $fieldA->Value = $m->name;
//             $fieldB = $worksheet->Range("B{$rb}");
//             $fieldB->activate;
//             $fieldB->Value = $m->genres;
//             $fieldC = $worksheet->Range("C{$rb}");
//             $fieldC->activate;
//             $fieldC->Value = $m->release_year;
//             $rb++;
//         }

// $excel_file->_SaveAs("Movies".time().".xlsx");
// header( "Content-Type: application/vnd.ms-excel" );
// header( "Content-Disposition: attachment; filename=movies.xls" );

// header("Location:../../views/pages/admin.php?page=movies");
?>


<?php
    require "../../config/konekcija.php";
    $output = '';
    // $upit = "SELECT v.name, c.categoryName, br.brandName, v.description FROM vehicles v INNER JOIN categories c on v.categoryId = c.categoryId INNER JOIN brands br ON v.brandId = br.brandId";
    $upit = "SELECT m.*, la.value as limit_age, q.value as quality, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres, GROUP_CONCAT(DISTINCT c.name SEPARATOR ',') AS country FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN movie_country mc ON m.id_movie=mc.id_movie LEFT JOIN country c ON c.id_country=mc.id_country  LEFT JOIN country_movie_limit_age cmla ON m.id_movie=cmla.id_movie LEFT JOIN limit_age la ON la.id_limit_age=cmla.id_limit_age LEFT JOIN quality_movie qm ON qm.id_movie=m.id_movie LEFT JOIN quality q ON q.id_quality=qm.id_quality GROUP BY m.id_movie";
    $stmt = $konekcija->query($upit)->fetchAll();

    if(count($stmt) > 0){
        $output .= "<table class='excelTable'>
        <thead>
        <tr>
        <td>TITLE</td>
        <td>RELEASE YEAR</td>
        <td>GENRES</td>
        <td>COUNTRIES</td>
        <td>QUALITY</td>
        </tr>
        </thead>
        <tbody>";

            foreach($stmt as $rez){
                $output .= "<tr>
                <td>" . $rez->name . "</td>
                <td>" . $rez->release_year . "</td>
                <td>" . $rez->genres . "</td>
                <td>" . $rez->country . "</td>
                <td>" . $rez->quality . "</td>
                </tr>";
            }

    $output .= "</tbody></table>";
}

header("Content-Type: application/xls");
 header("Content-Disposition: attachment; filename=movies.xls");
 echo $output;
?>
