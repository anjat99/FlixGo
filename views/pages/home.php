<!-- home -->
<?php zabeleziPristupStranici();?>
<section class="home">
		<!-- home bg -->
		<div class="owl-carousel home__bg">
			<div class="item home__cover" data-bg="assets/images/home/home__bg.jpg"></div>
			<div class="item home__cover" data-bg="assets/images/home/home__bg2.jpg"></div>
			<div class="item home__cover" data-bg="assets/images/home/home__bg3.jpg"></div>
			<div class="item home__cover" data-bg="assets/images/home/home__bg4.jpg"></div>
		</div>
		<!-- end home bg -->

		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1 class="home__title"><b>NEW ITEMS</b> OF THIS SEASON</h1>

					<button class="home__nav home__nav--prev" type="button">
						<i class="icon ion-ios-arrow-round-back"></i>
					</button>
					<button class="home__nav home__nav--next" type="button">
						<i class="icon ion-ios-arrow-round-forward"></i>
					</button>
				</div>

				<div class="col-12">
					<div class="owl-carousel home__carousel">
						<?php
							require_once "models/functions.php";
							$newItems=showNewMovies(); 
							foreach ($newItems as $item):
						?>
						<!-- card -->
						<div class="item">
							<div class="card card--big">
								<div class="card__cover">
									<img src="<?= $item->cover ?>" alt="<?= $item->name ?>">
									<a href="index.php?page=catalog" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="index.php?page=catalog"><?= $item->name?></a></h3>
									<span class="card__category">
										<a href="#"><?=  $item->genres ?></a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>
									<?php		
										echo $item->prosek != null ? $item->prosek : "0 votes";
									?>
									</span>
								</div>
							</div>
						</div>
						<!-- end card -->
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
</section>
<!-- end home -->

	<!-- content -->
	<section class="content">
		<div class="content__head">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- content title -->
						<h2 class="content__title">New items</h2>
						<!-- end content title -->

						<!-- content tabs nav -->
						<ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">NEW RELEASES</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">MOVIES</a>
							</li>
						</ul>
						<!-- end content tabs nav -->

						<!-- content mobile tabs nav -->
						<div class="content__mobile-tabs" id="content__mobile-tabs">
							<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<input type="button" value="New items">
								<span></span>
							</div>

							<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">NEW RELEASES</a></li>

									<li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">MOVIES</a></li>
								</ul>
							</div>
						</div>
						<!-- end content mobile tabs nav -->
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- content tabs -->
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
					<div class="row">
					<?php
							require_once "models/functions.php";
							$newItemsDetails=showNewMoviesWithDetails(); 
							foreach ($newItemsDetails as $itemDetail):
					?>
						<!-- card -->
						<div class="col-6 col-sm-12 col-lg-6">
							<div class="card card--list">
								<div class="row">
									<div class="col-12 col-sm-4">
										<div class="card__cover">
											<img src="<?= $itemDetail->cover ?>" alt="<?= $itemDetail->name ?>">
											<a href="index.php?page=catalog" class="card__play">
												<i class="icon ion-ios-play"></i>
											</a>
										</div>
									</div>

									<div class="col-12 col-sm-8">
										<div class="card__content">
											<h3 class="card__title"><a href="index.php?page=catalog"><?= $itemDetail->name ?></a></h3>
											<span class="card__category">
												<a href="#"><?=  $itemDetail->genres ?></a>
											</span>

											<div class="card__wrap">
												<span class="card__rate"><i class="icon ion-ios-star"></i>
												<?php		
													echo $itemDetail->prosek != null ? $itemDetail->prosek : "0";
												?>
												</span>

												<ul class="card__list">
													<li><?=  $itemDetail->quality  ?></li>
													<li><?=  $itemDetail->limit_age  ?></li>
												</ul>
											</div>

											<div class="card__description">
												<p><?php
													if(strlen($itemDetail->description)<=270)
													{
													  echo $itemDetail->description;
													}
													else
													{
														$itemDetail->description=substr($itemDetail->description,0,270) . '...';
													  echo $itemDetail->description;
													}
											?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end card -->
						<?php endforeach; ?>
						
					</div>
				</div>

				<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
					<div class="row">
						<?php
							require_once "models/functions.php";
							$randomItems=showNewRandomMovies(); 
							foreach ($randomItems as $random):
						?>
						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-3 col-xl-2">
							<div class="card">
								<div class="card__cover">
									<img src="<?= $random->cover ?>" alt="<?= $random->name ?>">
									<a href="index.php?page=catalog" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="index.php?page=catalog"><?= $random->name."<br>"."(".$random->godina.")" ?></a></h3>
									<span class="card__category">
										<a href="#"><?= $random->genres ?></a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>
									<?php		
										echo $random->prosek != null ? $random->prosek : "0 votes";
									?>
									</span>
								</div>
							</div>
						</div>
						<!-- end card -->
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<!-- end content tabs -->
		</div>
	</section>
	<!-- end content -->

	<!-- expected premiere -->
	<section class="section section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title">Expected premiere</h2>
				</div>
				<!-- end section title -->
					<?php
							require_once "models/functions.php";
							$premiereMovies=showMoviesPremiere(); 
							foreach ($premiereMovies as $premiere):
					?>
				<!-- card 6filmova + 6filmova posle show more-->
				<div class="col-6 col-sm-4 col-lg-3 col-xl-2">
					<div class="card">
						<div class="card__cover">
							<img src="<?= $premiere->cover ?>" alt="<?= $premiere->name ?>">
							<a href="index.php?page=catalog" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
						</div>
						<div class="card__content">
							<h3 class="card__title"><a href="index.php?page=catalog"><?= $premiere->name ?></a></h3>
							<span class="card__category">
								<a href="#"><?= $premiere->genres ?></a>
							</span>
							<span class="card__rate"><i class="icon ion-ios-star"></i>
							<?php
									echo $premiere->prosek != null ? $premiere->prosek : "0 votes";
								?>
							</span>
						</div>
					</div>
				</div>
				<!-- end card -->
				<?php endforeach; ?>

				<!-- section btn -->
				<div class="col-12">
					<a href="#" id="prikaziViseFilmova" class="section__btn">Show more</a>
				</div>
				<!-- end section btn -->
				<div id="dodatak" class="col-12">
					<?php
							require_once "models/functions.php";
							$premiereMoviesMore=showNewMoviesPremiere(); 
							foreach ($premiereMoviesMore as $premiereMore):
					?>
				<!-- card -->
				<div class="col-6 col-sm-4 col-lg-3 col-xl-2 levo">
					<div class="card">
						<div class="card__cover">
							<img src="<?= $premiereMore->cover ?>" alt="<?= $premiereMore->name ?>">
							<a href="#" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
						</div>
						<div class="card__content">
							<h3 class="card__title"><a href="#"><?= $premiereMore->name ?></a></h3>
							<span class="card__category">
								<a href="#"><?= $premiereMore->genres ?></a>
							</span>
							<span class="card__rate"><i class="icon ion-ios-star"></i>
							<?php
								echo $premiereMore->prosek != null ? $premiereMore->prosek : "0 votes";
							?>
							</span>
						</div>
					</div>
				</div>
				<!-- end card -->
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<!-- end expected premiere -->