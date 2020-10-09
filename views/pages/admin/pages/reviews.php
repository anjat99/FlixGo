<?php
         require_once("../../models/reviews/functions.php");
		 $upit = "SELECT COUNT(*) as broj from review";
		 $obj = $konekcija->query($upit)->fetch();
		 $poStrani = 5;
		 $brojLink = ceil($obj->broj/$poStrani);
		 $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
		 $od = $poStrani*($strana-1);
		 $upit = "SELECT u.id_user as korisnik, m.id_movie, m.name as film, ur.date as datumReview, r.title as title, r.message as tekstReview, u.username as username, r.id_review as id_review FROM movie m INNER JOIN user_review ur ON m.id_movie=ur.id_movie INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN user u ON u.id_user=ur.id_user LIMIT $od, $poStrani;";
		 $reviews= $konekcija->query($upit)->fetchAll(); 
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>REVIEWS</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- users -->
				<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table table text-center" id="tabelaReviewsAdmin">
							<thead>
								<tr>
									<th>MOVIE</th>
									<th>USER</th>
									<th>TITLE</th>
									<th>SUMMARY</th>
									<th>DATE OF POST</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach($reviews as $review) :?>
								<tr>
									<td>
										<div class="main__table-text text-centar"><?=$review->film?></div>
									</td>
									<td>
										<div class="main__table-text text-centar"><?=$review->username?></div>
									</td>
									<td>
										<div class="main__table-text main__table-text--green text-centar">
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
										<div class="main__table-text text-centar align-middle">
										<?php
													if(strlen($review->tekstReview)<=35)
													{
													  echo $review->tekstReview;
													}
													else
													{
														$review->tekstReview=substr($review->tekstReview,0,35) . '...';
													  echo $review->tekstReview;
													}
											?>
										</div>
									</td>
									<td>
										<div class="main__table-text text-centar"><?=$review->datumReview?></div>
									</td>
									<td>
										<div class="main__table-btns text-centar">
											<a href="#" data-movie="<?= $review->id_movie?>" data-user="<?= $review->korisnik?>" data-id="<?=$review->id_review?>" class="detaljiReview main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
											</a>
											<a href="#" data-movie="<?= $review->id_movie?>" data-user="<?= $review->korisnik?>" data-id="<?=$review->id_review?>" class="obrisiReview main__table-btn main__table-btn--delete">
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
				
						<?php  if(($obj->broj)>$poStrani): ?>
							<ul class="paginator">
								<?php
									for($i=0;$i<$brojLink;$i++):?>
										<li class="paginator__item" >
											<a href="admin.php?page=reviews&strana=<?=$i+1?>" class="pagee" >
												<?=$i+1 ?>
											</a>
										</li>
								<?php endfor;?>
							</ul>
							<?php endif;?>
					</div>
				</div>
				<!-- end paginator -->

				 <!-- Details of message -->
				 <div class="container">
					<div class="row">
                    	<div class="col-12" id="detaljiReview">
                        	
                    	</div>
                	</div>
				</div>
			

			</div>
		</div>
	</main>
	<!-- end main content -->

	