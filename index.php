<?php
ob_start();
session_start();
 require_once "config/konekcija.php";

 require_once "models/functions.php";
//  require_once "models/comment/fetch.php";
 
 require_once("views/fixed/head.php");
 require_once("views/fixed/header.php");
 
if(isset($_GET['page'])){
	$page=$_GET['page'];
	switch($page){
		case 'home':
			require_once("views/pages/home.php");
			break;
		case 'about':
			require_once("views/pages/about.php");
			break;
		case 'catalog':
			require_once("views/pages/catalog.php");
			break;
		case 'movieDetails':
			require_once("views/pages/movie.php");
			break;
		case 'contact':
			require_once("views/pages/contact.php");
		 	break;
		case 'register':
			require_once("views/pages/register.php");
			break;
		case 'login':
			require_once("views/pages/login.php");
			break;
		case 'user':
			require_once("views/pages/user.php");
			break;
		case '404':
			require_once("views/pages/404.php");
			break;
		default:
			require_once("views/pages/home.php");
			break;
	}
}else{
	require_once("views/pages/home.php");
}

require_once("views/fixed/footer.php");
   ?>