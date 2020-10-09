<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Edit movie</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- form -->
				<div class="col-12">
					<form action="#" class="form">
						<div class="row">
							<div class="col-12 col-md-5 form__cover">
								<div class="row">
									<div class="col-12 col-sm-6 col-md-12">
										<div class="form__img">
											<label for="form__img-upload">Upload cover (270 x 400)</label>
											<input id="form__img-upload" name="form__img-upload" type="file" accept=".png, .jpg, .jpeg">
											<img id="form__img" src="#" alt=" ">
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-md-7 form__content">
								<div class="row">
									<div class="col-12">
										<input type="text" class="form__input" placeholder="Title" id="titleEdit" name="titleEdit">
									</div>

									<div class="col-12">
										<textarea id="text" name="text" class="form__textarea" placeholder="Description" id="decAdd" name="descAdd"></textarea>
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<input type="text" class="form__input" placeholder="Release year" id="ryearAdd" name="ryearAdd">
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<input type="text" class="form__input" placeholder="Trailer" id="trailerAdd" name="trailerAdd">
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<input type="text" class="form__input" placeholder="Running timed in minutes" id="durationAdd" name="durationAdd">
									</div>

									<div class="col-12 col-sm-6 col-lg-3">
										<select class="js-example-basic-single" id="quality">
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
										<select class="js-example-basic-single" id="age">
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
										<select class="js-example-basic-multiple" id="country" multiple="multiple">
										<?php
											$drzave=dohvati_sve_drzave();

											foreach ($drzave as $d):?>
												<option value="<?=$d->id_country?>"><?=$d->name?></option>
											<?php endforeach;
										?>
										
										</select>
									</div>

									<div class="col-12 col-lg-6">
										<select class="js-example-basic-multiple" id="genre" multiple="multiple">
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
										<button type="submit" id="btnAddMovie" name="btnAddMovie" class="form__btn">publish</button>
									</div>
							</div>
							
							<div class="col-12">
								<div class="row">
									

									
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