<?php
ob_start();
session_start();
if(!isset($_SESSION['user'])){
    header("Location: admin.php?page=404");
} 
   
	if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
		$user=$_SESSION['user'];


?>
<?php
 require_once "../../config/konekcija.php";

 require_once "../../models/functions.php";
 require_once "../../models/movies/functions.php";
 
 require_once("../../views/pages/admin/fixed/head.php");
 require_once("../../views/pages/admin/fixed/header.php");
 require_once("../../views/pages/admin/fixed/nav.php");
 
if(isset($_GET['page'])){
	$page=$_GET['page'];
	switch($page){
		case 'dashboard':
			require_once("admin/pages/dashboard.php");
			break;
		case 'movies':
			require_once("../../views/pages/admin/pages/movies.php");

			break;
		case 'messages':
			require_once("../../views/pages/admin/pages/messages.php");
			break;
		case 'genres':
			require_once("../../views/pages/admin/pages/genres.php");
			break;
		case 'quality':
			require_once("../../views/pages/admin/pages/quality.php");
			break;
		case 'country':
			require_once("../../views/pages/admin/pages/country.php");
			break;
		case 'limit_ages':
			require_once("../../views/pages/admin/pages/limit_ages.php");
			break;
		case 'users':
			require_once("../../views/pages/admin/pages/users.php");
			break;
		case 'edit_user':
			require_once("../../views/pages/admin/pages/edit_user.php");
			break;
		case 'add_item':
			require_once("../../views/pages/admin/pages/add_item.php");
			break;
		case 'edit_item':
			require_once("../../views/pages/admin/pages/edit_item.php");
			break;
		case 'menu':
			require_once("../../views/pages/admin/pages/menu.php");
			break;
		case 'reviews':
			require_once("../../views/pages/admin/pages/reviews.php");
            break;
        case 'access_pages':
            require_once("../../views/pages/admin/pages/access_pages.php");
            break;
        case '404':
            require_once("admin/pages/404.php");
			break;
		default:
			require_once("../../views/pages/admin/pages/dashboard.php");
			break;
	}
}else{
	require_once("../../views/pages/admin/pages/dashboard.php");
}

require_once("../../views/pages/admin/fixed/footer.php");
   ?>
<?php 
// else:
// 	 header("Location: admin.php?page=404");  
	 ?>

<?php 
endif; 
?>