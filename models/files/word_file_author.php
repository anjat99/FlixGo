<?php

//     $word = new COM("word.application") or die("Unable to open Word");
//     $word->Visible = 0;

//     $word->Documents->Add();

//     $word->Selection->Font->Name = 'Arial';
//     $word->Selection->Font->Size = 10;

//     $logo = "C:\\xampp1\\htdocs\\sajt-flixGo\\assets\\images\\autor.png";
//     try {
//         $word->Selection->InlineShapes->AddPicture($logo,0,1);
//     } catch (com_exception $e) {
//         print_r($e); 
//     }

//     $word->Selection->TypeText("\n Name: Anja Tomic \n");
//     $word->Selection->TypeText("Index number: 7/18 \n");
//     $word->Selection->TypeText("Hello! My name is Anja Tomic and I come from Pancevo. This website is made for the course of Practicum of PHP.For more information you can visit my portfolio and contact me anytime....");
      
//     // $filename = tempnam(sys_get_temp_dir(), "CV_AnjaTomic");
//     $filename = tempnam("../../data", "CV_AnjaTomic");
//     $word->Documents[1]->SaveAs($filename);
//     $word->Quit();
//     unset($word);

//     header("Content-type: application/vnd.ms-word");
//     header("Content-Disposition: attachment;Filename=myCV_AnjaTomic.doc");

//     // Send file to browser
// readfile($filename);
// unlink($filename);

    // header("Location:../../index.php");

    /*** novoooo */ ?>
<?php

   $filename = 'author.doc'; 
   header("Content-type: application/vnd.ms-word"); 
   header( "Content-Disposition: attachment; filename=".basename($filename)); 
   header( "Content-Description: File Transfer"); 

   @readfile($filename); 

   $content =   '<html xmlns:v="urn:schemas-microsoft-com:vml" ' 
                .'xmlns:o="urn:schemas-microsoft-com:office:office" ' .'xmlns:w="urn:schemas-microsoft-com:office:word" '
                .'xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"= ' 
                .'xmlns="http://www.w3.org/TR/REC-html40">' 
                .'<head><meta http-equiv="Content-Type" content="text/html; charset=Windows1252">' 
                .'<title>O autoru</title>' 
                .'<!--[if gte mso 9]>' 
                .'<xml>' 
                .'<w:WordDocument>' 
                .'<w:View>Print' 
                .'<w:Zoom>100' 
                .'<w:DoNotOptimizeForBrowser/>' 
                .'</w:WordDocument>' 
                .'</xml>' 
                .'<![endif]-->' 
                    .'<style> 
                        @page { 
                            font-family: Arial; 
                            size:215.9mm 279.4mm; /* A4 */margin:14.2mm 17.5mm 14.2mm 16mm; /* Margins: 2.5 cm on each side */ 
                        } 
                        h2 { 
                            font-family: Arial; 
                            font-size: 18px; 
                            text-align:center; 
                        }
                        p.para {
                            font-family: Arial; 
                            font-size: 13.5px; 
                            text-align: justify;
                        } 
                        </style>' 
                    .'</head>' 
                    .'<body>' 
                        .'<img src="assets/images/autor.png"><br/>' 
                        .'<h2>Anja Tomic 7/18</h2><br/>' 
                        .'<p>City: Belgrade, Serbia</p>' 
                        .'<p>Hello! My name is Anja Tomic and I come from Pancevo. This website is made for the course of Practicum of PHP.For more information you can visit my portfolio and contact me anytime...</p>'; 
                 
                 
        echo $content; 
                 
    ?>