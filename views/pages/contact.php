<!-- page title -->
<?php zabeleziPristupStranici();?>
<section class="section section--first section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Popunite ovaj formular ukoliko želite da kontaktirate administratora ili pitati nesto sto vas zanima...</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="index.php?page=home">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">INFO</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- end page title -->
    
    <div class="container">
			<div class="row">
				<div class="col-12">
                    <main id="mainContact" class="col-lg-7 ml-auto">
                            <article id="forma">
                                <form name="formaKontakt" id="formaKontakt" novalidate>

                                    <label>Email:</label>
                                    <input type="text" name="email" id="email" placeholder="petar.petrovic@gmail.com"/><br/>
                                    <p class="text-danger" id="emailGreska"></p>

                                    <label>Subject:</label>
                                    <input type="text" name="subj" id="subj" placeholder="Naslov"/>
                                    <p class="text-danger" id="subjGreska"></p>

                                    <label>Message:</label>
                                    <textarea cols="225" rows="10" placeholder="Vaše sugestije ili neko pitanje, ukoliko ih imate..." id="message" name="message"></textarea>
                                    <p class="text-danger podebljaj" id="pitanjaGreska"></p>

                                    <button type="button" name="btnKontakt" id="btnKontakt"><i class="fab fa-telegram-plane"></i></button>
                                </form>
                            
                            </article>
                            <br>
                            <div class="ml-auto">
                                <div id="success">

                                </div>
                            </div>
                    </main>
                </div>
            </div>
    </div>