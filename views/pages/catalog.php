<!-- page title -->
<?php zabeleziPristupStranici();?>
<?php
		require_once "models/catalog/functions.php";
?>
<section class="section section--first section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<h2 class="section__title">EXPLORE OUR CATALOG OF MOVIES AND FIND THE ONES YOU MOST PREFER...</h2>
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php?page=home">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Catalog</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- filter -->
	<div class="filter">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="filter__content">
						<div class="filter__items">
							<!-- filter item -->
							<div class="filter__item" id="filter__sort">
								<span class="filter__item-label">SORT BY:</span>
								<div class="form-group">
									<select name='ddlSort' id='ddlSort' class="form-control ddls">
										<option value='0' selected disabled data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>" >Choose</option>
										<option value="1" data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>">Name A-Z</option>
										<option value="2" data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>">Name Z-A</option>
										<option value="5" data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>">Release date asc</option>
										<option value="6" data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>">Release date desc</option>
									</select>
								</div>
			
							</div>
							<!-- end filter item -->

							<!-- filter item -->
							<div class="filter__item" id="filter__genre">
								<span class="filter__item-label">GENRE:</span>

								<div class="form-group">
									<select name='ddlGenre' id='ddlGenre' class="form-control ddls">
										<option value='0' selected disabled data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>">Choose</option>
                                         <?php
                                            $getAllGenres = getAllGenres();
                                            foreach ($getAllGenres as $genre) :
                                            ?>
                                        <option class="zanr" value="<?= $genre->id_genre ?>" data-str="<?= isset($_GET['strana']) ? $_GET['strana'] : 1;?>"><?= $genre->name ?></option>
                                        <?php endforeach; ?>
									</select>
								</div>
								</div>
							<!-- end filter item -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end filter -->

	<!-- catalog -->
	<div class="catalog">
		<div class="container" id="sviFilmovi">
			<div class="row" id="filmovi">
				<?php
							require_once "models/functions.php";
							$defaultAllMovies=getMoviesAndNoOfPages()["filmovi"]; 
							foreach ($defaultAllMovies as $movie):

					?>
				<!-- card col-6 col-sm-4 col-lg-3-->
				<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
					<div class="card">
						<div class="card__cover">
							<img src="<?= $movie->cover ?>" alt="<?= $movie->name ?>">
							<a href="index.php?page=catalog" class="card__play">
								<i class="icon ion-ios-play"></i>
							</a>
						</div>
						<div class="card__content">
							<h3 class="card__title"><a href="index.php?page=movieDetails&id=<?= $movie->id_movie  ?>"><?= $movie->name ?></a></h3>
							<span class="card__category">
								<a href="#"><?= $movie->genres ?></a>
							</span>
							<span class="card__rate text-bela"><i class="icon ion-ios-star"></i>
							<?php
									echo $movie->prosek != null ? $movie->prosek : "0 votes";
								?>
							</span>
						</div>
					</div>
				</div>
				<!-- end card -->
				<?php endforeach; ?> 
			</div>
			<!-- paginator -->
			<div class=" row col-12">
					<ul class="paginator" id="paginationCatalog">
                            <?php
                                $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
                                $numOfPages = getMoviesAndNoOfPages()['numOfPages'];
                                for ($i = 1; $i <= $numOfPages; $i++) :
                            ?>
                                
                                <li class="paginator__item <?= ($strana == $i) ? "paginator__item--active" : "" ?>">
                                    <a class="<?= ($strana == $i) ? "paginator__item--active" : "" ?>" href="index.php?page=catalog&strana=<?= $i ?>" data-id="<?= $i ?>" ><?= $i   ?></a>
                                </li>
                            <?php endfor;?>
					</ul>
				</div>
				<!-- end paginator -->
		</div>
	</div>
	<!-- end catalog -->