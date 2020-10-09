<?php
    if(isset($_SESSION['user']) && $_SESSION['user']->role==='admin'):
		$user=$_SESSION['user'];
		$id = $_SESSION['user']->id_user;

	$upit = "SELECT COUNT(*) as broj from movie";
	$obj = $konekcija->query($upit)->fetch();
	$poStrani = 5;
	$brojLink = ceil($obj->broj/$poStrani);
	$strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
	$od = $poStrani*($strana-1);


	$upit = "SELECT COUNT(DISTINCT ur.id_review)as broj, ROUND(AVG(rm.value),1) as prosek, m.*, la.value as limit_age, q.value as quality, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres, GROUP_CONCAT(DISTINCT c.name SEPARATOR ',') AS country FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN movie_country mc ON m.id_movie=mc.id_movie LEFT JOIN country c ON c.id_country=mc.id_country LEFT JOIN country_movie_limit_age cmla ON m.id_movie=cmla.id_movie LEFT JOIN limit_age la ON la.id_limit_age=cmla.id_limit_age LEFT JOIN quality_movie qm ON qm.id_movie=m.id_movie LEFT JOIN quality q ON q.id_quality=qm.id_quality LEFT JOIN rating_movie rm ON rm.id_movie=m.id_movie LEFT OUTER JOIN user_review ur ON ur.id_movie=m.id_movie LEFT OUTER JOIN review r ON r.id_review=ur.id_review GROUP BY m.id_movie LIMIT $od, $poStrani;";
	$filmovi= $konekcija->query($upit)->fetchAll();
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Movies</h2>
						<a href="admin.php?page=add_item" class="main__title-link">add item</a>

						<div class="main__title-wrap">
						</div>
					</div>
				</div>
				<!-- end main title -->

				<!-- users -->
				<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table">
							<thead>
								<tr>
									<th>#</th>
									<th>COVER</th>
									<th>TITLE</th>
									<th>RELEASE YEAR</th>
									<th>RATING</th>
									<th>NO.REVIES</th>
									<th>GENRES</th>
									<th>COUNTRIES</th>
									<th>QUALITY</th>
									<th>AGE</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
							<?php 
							$trenutno=0;
								foreach($filmovi as $f) :?>
								<tr>
									<td>
										<div class="main__table-text"><?=$f->id_movie?></div>
									</td>
									<td>
										<img class="main__table-text" width="50" height="50" src="../../<?=$f->cover?>" alt="<?=$f->name?>" />
									</td>
									<td>
										<div class="main__table-text"><?=$f->name?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->release_year?></div>
									</td>
									<td>
										<div class="main__table-text main__table-text--rate"><i class="icon ion-ios-star"></i> 
										<?php
											echo $f->prosek != null ? $f->prosek : "0 votes";
										?>
										</div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->broj?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->genres?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->country?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->quality?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$f->limit_age?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<!-- <a href="admin.php?page=edit_item" class="main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
											</a> -->
											<a href="#" data-movie="<?= $f->id_movie?>" class="obrisiFilm main__table-btn main__table-btn--delete">
												<i class="icon ion-ios-trash"></i>
											</a>
										</div>
									</td>
									
								</tr>
							
								
                                <?php endforeach; ?>   
								
							</tbody>
						</table>
					</div>
				</div>
				<!-- end users -->

				<!-- paginator -->
				<div class="col-12">
					<div class="paginator-wrap">
					<span> <?php echo $obj->broj ?> Total</span>
					<?php  if(($obj->broj)>$poStrani): ?>
						<ul class="paginator">
							<?php
								for($i=0;$i<$brojLink;$i++):?>
									<li class="paginator__item" >
										<a href="admin.php?page=movies&strana=<?=$i+1?>" class="pagee" >
											<?=$i+1 ?>
									
										</a>
										
									</li>
							<?php endfor;?>
							
						</ul>
								<?php endif;?>
					</div>
				</div>
				<!-- end paginator -->
				<!-- <div class="container export"><a href="../../models/files/export_movies_to_excel.php" class="btn btn-primary">Export to excel</a></div> -->
			</div>
		</div>
	</main>
	<!-- end main content -->

	<?php else: header("Location: admin.php?page=404"); ?>
	<?php endif; ?>