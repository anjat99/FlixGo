<!-- page title -->
<?php
	if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
		$user=$_SESSION['user'];
		$id = $_SESSION['user']->id_user;

		require_once("../../models/reviews/functions.php");
		$upit = "SELECT u.username, u.email, p.name, p.surname, u.id_user, u.dateReg FROM user u INNER JOIN person_role pr ON pr.id_person_role=u.id_person_role INNER JOIN person p ON p.id_person=pr.id_person ORDER BY u.dateReg DESC LIMIT 0,5;";
		$korisnici= $konekcija->query($upit)->fetchAll(); 
		$upit = "SELECT m.id_movie, m.name as film, ROUND(AVG(rm.value),1) as prosek FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN movie_country mc ON m.id_movie=mc.id_movie LEFT JOIN country c ON c.id_country=mc.id_country LEFT JOIN country_movie_limit_age cmla ON m.id_movie=cmla.id_movie LEFT JOIN limit_age la ON la.id_limit_age=cmla.id_limit_age LEFT JOIN quality_movie qm ON qm.id_movie=m.id_movie LEFT JOIN quality q ON q.id_quality=qm.id_quality LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie GROUP BY m.id_movie ORDER BY prosek DESC LIMIT 0,5;";
		$filmovi= $konekcija->query($upit)->fetchAll(); 
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Dashboard</h2>

					</div>
				</div>
				<!-- end main title -->


				<!-- dashbox -->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3><i class="icon ion-ios-trophy"></i> Top items</h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="admin.php?page=movies">View All</a>
							</div>
						</div>

						<div class="dashbox__table-wrap">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>TITLE</th>
										<th>RATING</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								foreach($filmovi as $f) :?>
									<tr>
										<td>
											<div class="main__table-text"><?=$f->id_movie?></div>
										</td>
										<td>
											<div class="main__table-text"><?=$f->film?></div>
										</td>
										<td>
											<div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i><?=$f->prosek?></div>
										</td>
									</tr>
									<?php endforeach; ?>  
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox -->

				

				<!-- dashbox -->
				<div class="col-12 col-xl-6">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3><i class="icon ion-ios-contacts"></i> Latest users</h3>

							<div class="dashbox__wrap">
								<a class="dashbox__more" href="admin.php?page=users">View All</a>
							</div>
						</div>

						<div class="dashbox__table-wrap">
							<table class="main__table main__table--dash">
								<thead>
									<tr>
										<th>ID</th>
										<th>FULL NAME</th>
										<th>EMAIL</th>
										<th>USERNAME</th>
										<th>DATE OF REG</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								foreach($korisnici as $k) :?>
									<tr>
										<td>
											<div class="main__table-text"><?=$k->id_user?></div>
										</td>
										<td>
											<div class="main__table-text"><?=$k->name?> <?=$k->surname?></div>
										</td>
										<td>
											<div class="main__table-text main__table-text--grey"><?=$k->email?></div>
										</td>
										<td>
											<div class="main__table-text"><?=$k->username?></div>
										</td>
										<td>
											<div class="main__table-text"><?=$k->dateReg?></div>
										</td>
									</tr>
									<?php endforeach; ?>  
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- end dashbox -->


				<!-- dashbox -->
				<div class="col-12">
					<div class="dashbox">
						<div class="dashbox__title">
							<h3><i class="icon ion-ios-contacts"></i> Statistics based on last 24h</h3>

						</div>

						<div class="dashbox__table-wrap">
							<table class="main__table main__table--dash text-bela">
							<?php
								$allPages = sveStranice();
								$numOfPages = count($allPages);
								?>

								<thead>
									<tr>
									<?php foreach ($allPages as $page) : ?>
										<th><?= $page; ?></th>
									<?php endforeach; ?>
									</tr>
									<tr>
										<?php foreach (pristupStranicamaProcenat() as $procenat) : ?>
											<td><?= $procenat; ?>%</td>
										<?php endforeach; ?>
									</tr>
								
							</table>
							
							

						</div>
						
					</div>
				</div>
				<!-- end dashbox -->
				<div class="container">
							<div class="row">
								<div class="col-lg-12 text-center text-bela">
									Number Of LoggedIn Users: <?= brojUlogovanih(); ?>
								</div>
							</div>
						</div>
			</div>
		</div>
	</main>
	<!-- end main content -->
	<?php 
	else: header("Location: admin.php?page=404"); 
	?>
	<?php endif; ?>