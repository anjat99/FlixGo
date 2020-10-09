<?php 
    if(isset($_GET['id'])){ 
        $id = $_GET['id']; 

        $upit = "SELECT m.*, la.value as limit_age, q.value as quality, GROUP_CONCAT(DISTINCT g.name SEPARATOR ',') AS genres, GROUP_CONCAT(DISTINCT c.name SEPARATOR ',') AS country FROM movie m LEFT JOIN movie_genre mg ON m.id_movie=mg.id_movie LEFT JOIN genre g ON g.id_genre=mg.id_genre LEFT JOIN movie_country mc ON m.id_movie=mc.id_movie LEFT JOIN country c ON c.id_country=mc.id_country LEFT JOIN country_movie_limit_age cmla ON m.id_movie=cmla.id_movie LEFT JOIN limit_age la ON la.id_limit_age=cmla.id_limit_age LEFT JOIN quality_movie qm ON qm.id_movie=m.id_movie LEFT JOIN quality q ON q.id_quality=qm.id_quality WHERE m.id_movie=:id GROUP BY m.id_movie "; 
        
        $rez=$konekcija->prepare($upit);
        $rez->bindParam(':id',$id); 
        
        try { 
            $rez->execute(); 
            $film = $rez->fetch(); 
            
            if($film): ?> 
			<!-- section details -->
               <section class="section details">
                    <!-- details background -->
                    <div class="details__bg" data-bg="assets/images/home/home__bg.jpg"></div>
                    <!-- end details background -->

                    <!-- details content -->
                    <div class="container">
                        <div class="row">
                            <!-- title -->
                            <div class="col-12">
                                <h1 class="details__title"><?= $film->name ?></h1>
                                 <?php	if(isset($_SESSION['user']) && $_SESSION['user']->role === 'user'):?>
                                <form method="post" action="add_rating.php">
                                     <div>
                                        <?php
                                            require_once "models/catalog/calculate_rating.php";
                                            $br=1;
                                            for($i=0;$i<5;$i++):
                                                if($i<$zaokruzeno):
                                        ?>
                                            <i class="fas fa-star" data-id="<?=$br?>" data-movie="<?=$film->id_movie?>"></i>
                                        <?php
                                            else:
                                        ?>
                                            <i class="far fa-star" data-id="<?=$br?>" data-movie="<?=$film->id_movie?>"></i>
                                        <?php
                                        endif; $br++; endfor;
                                        ?>
                                          <br><br>
                                            <p id="greskaOcena" class="text-red"></p>
                                     </div>
                                    <!-- <span id="rating">Nesto</span> -->
                                </form>
                                    <?php endif; ?>
                            </div>
                            <!-- end title -->

                            <!-- content -->
                            <div class="col-12 col-xl-6">
                                <div class="card card--details">
                                    <div class="row">
                                        <!-- card cover -->
                                        <div class="col-12 col-sm-4 col-md-4 col-lg-3 col-xl-5">
                                            <div class="card__cover">
                                                <img src="<?= $film->cover ?>" alt="<?= $film->name ?>">
                                            </div>
                                        </div>
                                        <!-- end card cover -->

                                        <!-- card content -->
                                        <div class="col-12 col-sm-8 col-md-8 col-lg-9 col-xl-7">
                                            <div class="card__content">
                                                <div class="card__wrap">
                                                    <span class="card__rate"><i class="icon ion-ios-star"></i>
                                                    <?php
                                                          require_once "models/catalog/calculate_rating.php";
                                                          echo $zaokruzeno;

                                                        ?>
                                                    </span>

                                                    <ul class="card__list">
                                                        <li><?= $film->quality ?></li>
                                                        <li><?= $film->limit_age ?></li>
                                                    </ul>
                                                </div>

                                                <ul class="card__meta">
                                                    <li><span>Genre:</span> <a href="#"><?= $film->genres ?></a>
                                                    <a href="#">Triler</a></li>
                                                    <li><span>Release year:</span> <?= $film->release_year ?></li>
                                                    <li><span>Running time:</span> <?= $film->duration ?> min</li>
                                                    <li><span>Country:</span> <a href="#"><?= $film->country ?></a> </li>
                                                </ul>

                                                <div class="card__description card__description--details">
                                                <?= $film->description ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card content -->
                                    </div>
                                </div>
                            </div>
                            <!-- end content -->

                            <!-- player -->
                            <div class="col-12 col-xl-6">
                                <iframe id='video' class='h-100 w-75' width="560" height="315" src="<?= $film->trailer ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <!-- end player -->

                            <div class="col-12">
                                <div class="details__wrap">
                                    <!-- availables -->
                                    <div class="details__devices">
                                        <span class="details__devices-title">Available on devices:</span>
                                        <ul class="details__devices-list">
                                            <li><i class="icon ion-logo-apple"></i><span>IOS</span></li>
                                            <li><i class="icon ion-logo-android"></i><span>Android</span></li>
                                            <li><i class="icon ion-logo-windows"></i><span>Windows</span></li>
                                            <li><i class="icon ion-md-tv"></i><span>Smart TV</span></li>
                                            <li><i class="icon ion-md-desktop"></i><span>Desktop</span></li>
                                        </ul>
                                    </div>
                                    <!-- end availables -->

                                    <!-- share -->
                                    <div class="details__share">
                                        <span class="details__share-title">Share with friends:</span>

                                        <ul class="details__share-list">
                                        <?php 
                                            $mreze = dohvatiSocialMedia();
                                            foreach($mreze as $mreza):
                                                if($mreza->class != "twitch" && $mreza->class != "imdb"):
                                        ?>
                                        
                                        <li class="<?= $mreza->class?>">
                                            <a href="<?= $mreza->path?>" target="_blank">
                                                <?= $mreza->icon?>
                                            </a>
                                        </li>
                                                <?php endif;?>
                                        <?php endforeach;?>
                                        </ul>
                                    </div>
                                    <!-- end share -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end details content -->
                </section>
            <!-- section details -->
             
                <!-- content -->
				<section class="content">
					<div class="content__head">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<!-- content title -->
									<h2 class="content__title">Discover</h2>
									<!-- end content title -->

									<!-- content tabs nav -->
									<ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">

										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Reviews</a>
										</li>

									</ul>
									<!-- end content tabs nav -->

									<!-- content mobile tabs nav -->
									<div class="content__mobile-tabs" id="content__mobile-tabs">
										<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<input type="button" value="Reviews">
											<span></span>
										</div>

										<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
											<ul class="nav nav-tabs" role="tablist">

												<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Reviews</a></li>
											</ul>
										</div>
									</div>
									<!-- end content mobile tabs nav -->
								</div>
							</div>
						</div>
					</div>

					<div class="container">
						<div class="row">
							<div class="col-12 col-lg-8 col-xl-8">
								<!-- content tabs -->
								<div class="tab-content" id="myTabContent">
									

									<div  id="tab-1" role="tabpanel" aria-labelledby="1-tab">
										<div class="row">
											<!-- reviews -->
											<div class="col-12">
												<div class="reviews">
                                                <?php	if(isset($_SESSION['user']) && $_SESSION['user']->role === 'user'):?>
                                                    <button type="button" class="form__btn" id="btnAddReview" name="btnAddReview">Add</button>

													<form method="post" action="add_rating.php" class="form mt-4" id="formaReview" name="formaReview">
                                                        <input type="text" id="tbTitleReview" name="tbTitleReview" class="form__input" placeholder="Title">
                                                        <p class="text-danger" id="naslovGreska"></p>
                                                        <textarea id="taMessageReview" name="taMessageReview" class="form__textarea" placeholder="Review"></textarea>
                                                        <p class="text-danger" id="porukaGreska"></p>
														<button type="button" class="form__btn" id="btnSendReview" name="btnSendReview" data-movie="<?=$film->id_movie?>">Send</button>
													</form>
                                                 <?php endif; ?>	
													<ul class="reviews__list mt-5" id="reviews">
                                                        

                                                              <?php
                                                                require_once "models/reviews/functions.php";

                                                                $upit = "SELECT m.id_movie, r.title , r.message ,u.username, ur.date FROM user u INNER JOIN user_review ur ON u.id_user=ur.id_user INNER JOIN review r ON r.id_review=ur.id_review INNER JOIN movie m ON m.id_movie=ur.id_movie WHERE m.id_movie=:id ORDER BY r.id_review DESC";
                                                                $broj = brojReviews($id);
                                                                $priprema=$konekcija->prepare($upit);
                                                                $priprema->bindParam(":id",$id);

                                                                try{
                                                                    $test = $priprema->execute();
                                                                    $reviews=$priprema->fetchAll();
                                                                    if($reviews): 
                                                                        foreach($reviews as $item): 
                                                                            if($item->message != NULL || $item->username != NULL || $item->title != NULL || $item->date != NULL):
                                                                        ?> 
                                                                            <li class="reviews__item">
                                                                                <div class="reviews__autor">
                                                                                    <img class="reviews__avatar" src="assets/images/profileUser.png" alt="">
                                                                                                <span class="reviews__name"> <?=  $item->title ?> </span>
                                                                              
                                                                                    <span class="reviews__time">
                                                                                    <?php echo obradaDatuma($item->date) ?> 
                                                                                    <?php echo "by ".$item->username ?></span>
                                                                                </div>
                                                                                <p class="reviews__text"> <?= $item->message  ?> </p>
                                                                            </li>
                                                                            <hr /> 
                                                                           
                                                                            <?php else: ?> 
                                                                            <p class='text-white'>Currently don't have any review for this movie. If you watch this movie of have any reason to, write a review about it, but first you need to be logged in if you are not</p>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?> 
                                                                        <?php else: ?> 
                                                                            <p class='text-white'>Currently don't have any review for this movie. If you watch this movie of have any reason to, write a review about it., but first you need to be logged in if you are not</p>
                                                                            <?php endif; ?>

                                                              <?php  }catch(PDOException $e){
                                                                    $code=500;
                                                                    echo $e->getMessage() ."<br/>";
                                                                    upisGresaka($e->getMessage());
                                                                }

                                                            ?>
													</ul>
												</div>
											</div>
											<!-- end reviews -->
										</div>
									</div>


                    
								</div>
								<!-- end content tabs -->
							</div>

							
							<!-- pre ovog zatvorenog diva ide sidebar -->
						</div>
					</div>
				</section>
				<!-- end content -->





                <!-- Root element of PhotoSwipe. Must have class pswp. -->
	            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                    <!-- Background of PhotoSwipe. It's a separate element, as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>

                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">

                        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
                        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>

                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                        <div class="pswp__ui pswp__ui--hidden">
                            <div class="pswp__top-bar">

                                <!--  Controls are self-explanatory. Order can be changed. -->
                                <div class="pswp__counter"></div>
                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                                <!-- Preloader -->
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                        <div class="pswp__preloader__cut">
                                            <div class="pswp__preloader__donut"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end of PhotoSwipe -->
           
            <?php else: header("Location: index.php");  ?>
            <?php endif;?>
            <?php } catch (PDOException $e) { 
                echo $e->getMessage(); 
                header("Location: index.php"); 
            } 
        
}
?>
