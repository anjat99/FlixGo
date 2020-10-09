	

	<!-- sidebar -->
	<div class="sidebar">
		<!-- sidebar logo -->
		<a href="#" class="sidebar__logo">
			<img src="https://flix-go4movies.000webhostapp.com/sajt-flixGo/assets/images/logo.svg" alt="">
		</a>
		<!-- end sidebar logo -->
		
		<!-- sidebar user -->
		<div class="sidebar__user">
			<div class="sidebar__user-img">
				<img src="https://flix-go4movies.000webhostapp.com/sajt-flixGo/assets/images/autor.png" alt="">
			</div>

			<div class="sidebar__user-title">
				<span>Admin</span>
				<p>
				<?= $user->name?> <?=$user->surname?>
				</p>
			</div>

			<button class="sidebar__user-btn" type="button">
				<a href="https://flix-go4movies.000webhostapp.com/sajt-flixGo/models/logout.php"><i class="icon ion-ios-log-out"></i></a>
			</button>
		</div>
		<!-- end sidebar user -->

		<!-- sidebar nav -->
		<ul class="sidebar__nav">
		<li class="sidebar__nav-item">
				<a href="admin.php?page=dashboard" class="sidebar__nav-link sidebar__nav-link--active"><i class="icon ion-ios-keypad"></i> Dashboard</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=menu" class="sidebar__nav-link"><i class="icon ion-ios-chatbubbles"></i> Menu</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=movies" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> Movies</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=quality" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> Quality</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=genres" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> Genres</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=country" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> Country</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=limit_ages" class="sidebar__nav-link"><i class="icon ion-ios-film"></i> Limit ages</a>
			</li>


			<li class="sidebar__nav-item">
				<a href="admin.php?page=reviews" class="sidebar__nav-link"><i class="icon ion-ios-star-half"></i> Reviews</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=users" class="sidebar__nav-link"><i class="icon ion-ios-contacts"></i> Users</a>
			</li>

			<li class="sidebar__nav-item">
				<a href="admin.php?page=messages" class="sidebar__nav-link"><i class="icon ion-ios-contacts"></i> Contact-messages</a>
			</li>


			
		</ul>
		<!-- end sidebar nav -->
		
		<!-- sidebar copyright -->
		<div class="sidebar__copyright">© 2019 FlixGo. <br>Create by <a href="https://themeforest.net/user/dmitryvolkov/portfolio" target="_blank">Dmitry Volkov</a></div>
		<!-- end sidebar copyright -->
	</div>
	<!-- end sidebar -->
