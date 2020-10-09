	<!-- header -->
	<header class="header">
		<div class="header__wrap">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="header__content">
							<!-- header logo -->
							<a href="index.php" class="header__logo logo">
								<img src="assets/images/logo.png" alt="">FLIXGO
							</a>
							<!-- end header logo -->

							<!-- header nav -->
							<!-- <ul class="header__nav">
								<li class="header__nav-item">
									<a href="index.php?page=home" class="header__nav-link">Home</a>
								</li>

								<li class="header__nav-item">
									<a href="index.php?page=about" class="header__nav-link">About</a>
								</li>

								<li class="header__nav-item">
									<a href="index.php?page=catalog" class="header__nav-link">Catalog</a>
								</li>

								<li class="header__nav-item">
									<a href="index.php?page=price" class="header__nav-link">Pricing Plan</a>
								</li>

								<li class="header__nav-item">
									<a href="index.php?page=contact" class="header__nav-link">Contact</a>
								</li>

							</ul> -->
							<!-- end header nav --> 
							<?php
              echo showNavigationMenu();
          ?>

							<!-- header auth -->
							<div class="header__auth">
						<!-- header auth-->
								
						<?php	if(isset($_GET['page']) && $_GET['page'] == "catalog"): ?>
								<button class="header__search-btn" type="button">
									<i class="icon ion-ios-search"></i>
								</button>
						<?php endif; ?>
							<?php	if(isset($_SESSION['user']) && $_SESSION['user']->role === 'user'):?>
									<a href="models/logout.php" class="header__sign-in">
									<i class="icon ion-ios-log-in"></i>
									<span>Logout</span>
								</a>
							<?php else: ?>
								<a href="index.php?page=register" class="header__sign-in mr-1">
									<i class="icon ion-ios-log-in"></i>
									<span>Register</span>
								</a>
								<a href="index.php?page=login" class="header__sign-in">
									<i class="icon ion-ios-log-in"></i>
									<span>Login</span>
								</a>
							<?php endif;  ?>
							</div>
							<!-- end header auth -->

							<!-- header menu btn -->
							<button class="header__btn" type="button">
								<span></span>
								<span></span>
								<span></span>
							</button>
							<!-- end header menu btn -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- header search -->
		<form action="#" class="header__search">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="header__search-content">
							<input type="text" id="search" name="search" placeholder="Search for a movie that you are looking for">

							<button id="btnSearch" name="btnSearch" type="button">search</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- end header search -->
	</header>
	<!-- end header -->