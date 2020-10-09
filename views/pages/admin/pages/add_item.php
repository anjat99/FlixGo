<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Add new movie</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- form -->
				<div class="col-12">
					<form action="../../models/movies/add.php" method="post" class="form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-12 col-md-5 form__cover">
								<div class="row">
									<div class="col-12 col-sm-6 col-md-12">
										<div class="form__img">
											<label for="form__img-upload">Upload cover </label>
											<input id="form__img-upload" name="form__img-upload" type="file" accept=".png, .jpg, .jpeg">
											<img id="form__img" src="#" alt=" ">
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-md-7 form__content">
								<div class="row">
									<div class="col-12">
										<input type="text" class="form__input" placeholder="Title" id="titleAdd" name="titleAdd">
									</div>

									<div class="col-12">
										<textarea id="text" name="text" class="form__textarea" placeholder="Description"></textarea>
									</div>

								
									<div class="form-group">
								<label class="label_dateofbirth" for="dateofbirth">Release Year</label>
								<input type="date" name="releaseY" id="releaseY" value="" min="2005-01-01"> 
								<p class='text-danger' id="datumGreskaAdd"> </p>
							</div> 

									<div class="col-12 col-sm-6 col-lg-3">
										<input type="text" class="form__input" placeholder="Trailer" id="trailerAdd" name="trailerAdd">
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<input type="text" class="form__input" placeholder="Running timed in minutes" id="durationAdd" name="durationAdd">
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<select class="js-example-basic-single" id="quality" name="quality">
										<option value="0" selected disabled>Choose the quality</option>
											<?php
											$kvalitet=dohvati_sve_quality();

											foreach ($kvalitet as $k):?>
												<option value="<?=$k->id_quality?>"><?=$k->value?></option>
											<?php endforeach;
										?>
										
										</select>
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<select class="js-example-basic-single" id="age" name="age">
												<option value="0" selected disabled>Choose the limit age</option>
											<?php
											$godine=dohvati_sve_limitage();

											foreach ($godine as $g):?>
												<option value="<?=$g->id_limit_age?>"><?=$g->value?></option>
											<?php endforeach;
										?>
										
										</select>
									</div>

									<div class="col-12 col-lg-6">
										<select class="js-example-basic-single" name="country" id="country">
										<option value="0" selected disabled>Choose the country</option>
										<?php
											$drzave=dohvati_sve_drzave();

											foreach ($drzave as $d):?>
												<option value="<?=$d->id_country?>"><?=$d->name?></option>
											<?php endforeach;
										?>
										
										</select>
									</div>

									<div class="col-12 col-lg-6">
										<select class="js-example-basic-single" name="genre" id="genre">
										<option value="0" selected disabled>Choose the genre</option>
										<?php
											$zanrovi=dohvati_sve_zanrove();

											foreach ($zanrovi as $z):?>
												<option value="<?=$z->id_genre?>"><?=$z->name?></option>
											<?php endforeach;
										?>
										
										
										</select>
									</div>

								</div>
								<div class="col-12">
										<input type="submit" id="btnAddMovie" name="btnAddMovie" class="form__btn" value="PUBLISH"/>
									</div>
							</div>
							
							<div class="col-12">
								<div class="row">
								<div class="odgovorUpdateMovie text-belaGreske text-center ml-5">
                        <?php if(isset($_SESSION['poruka'])):
                            echo $_SESSION['poruka'];
                            unset($_SESSION['poruka']);

                            endif; ?>
                    </div>

									
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- end form -->
			</div>
		</div>
	</main>
	<!-- end main content -->