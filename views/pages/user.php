
<!-- page title -->
<?php zabeleziPristupStranici(); ?>
<?php
	if(isset($_SESSION['user']) && $_SESSION['user']->role==='user'):
		$user=$_SESSION['user'];
		$id = $_SESSION['user']->id_user;
		$upit = "SELECT m.id_movie, r.id_review,u.id_user as korisnik, m.name as film, ur.date as datumReview, r.title as title, r.message as tekstReview FROM movie m INNER JOIN user_review ur ON ur.id_movie=m.id_movie INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN user u ON u.id_user=ur.id_user WHERE u.id_user=:id";
		$priprema= $konekcija->prepare($upit);
		$priprema->bindParam(":id", $id);
		$priprema->execute();
		$reviews=$priprema->fetchAll();

?>
<section class="section section--first section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Hello, <?= $user->name?> <?=$user->surname?></h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php?page=home">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">UserPage</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- features -->
	<section class="section section--dark">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title section__title--center">Reviews I wrote</h2>
				</div>
				<!-- end section title -->

				<!-- feature -->
				<div class="col-12" >
				<div class="main__table-wrap">
						<table class="main__table table" border="1" id="tabelaReviewsUser">
							<thead>
								<tr>
									<th>MOVIE</th>
									<th>DATE OF REVIEW</th>
									<th>TITLE</th>
									<th>REVIEW</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach($reviews as $review) :?>
								<tr>
									<td>
										<div class="main__table-text"><?=$review->film?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$review->datumReview?></div>
									</td>
									<td>
										<div class="main__table-text main__table-text--green">
										<?php
													if(strlen($review->title)<=30)
													{
													  echo $review->title;
													}
													else
													{
														$review->title=substr($review->title,0,30) . '...';
													  echo $review->title;
													}
											?>
										</div>
									</td>
									<td>
										<div class="main__table-text">
										<?php
													if(strlen($review->tekstReview)<=30)
													{
													  echo $review->tekstReview;
													}
													else
													{
														$review->tekstReview=substr($review->tekstReview,0,30) . '...';
													  echo $review->tekstReview;
													}
											?>
										
										</div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-movie="<?= $review->id_movie?>" data-user="<?= $review->korisnik?>" data-id="<?=$review->id_review?>" class="detalji-review main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
											</a>
											<a href="#" data-movie="<?= $review->id_movie?>" data-user="<?= $review->korisnik?>" data-id="<?=$review->id_review?>" class="obrisi-review main__table-btn main__table-btn--delete open-modal">
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
				<!-- end feature -->
 <!-- Details of review -->
 <div class="container">
					<div class="row">
                    	<div class="col-12" id="detalji-review">
                        	
                    	</div>
                	</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end features -->
	<?php else: header("Location: index.php?page=404"); ?>
	<?php endif; ?>