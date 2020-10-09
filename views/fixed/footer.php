	<!-- footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-3 d-flex flex-column align-items-center justify-content-around text-center">
					<h6 class="footer__title">Usefull links:</h6>
					<ul class="footer__list">
						<li><a href="dokumentacijaPPHP.pdf">Documentation</a></li>
						<li><a href="sitemap.xml">Sitemap</a></li>
						<li>
							<a id="autor" data-modal="modalAutor">Author</a>
								<div id="modal0"class="modal0">
									<div class="sadrzajModala0">
										<a id="zatvori0">&times;</a>
										<figure id="autorImg">
											<img src="assets/images/autor.png" alt="autor"/>
										</figure>
										<h2>Fullname: Anja Tomić</h2>
										<p>Number of index: 7/18</p>
										<p>Birthdate: 31.08.1999</p>
										<a id="otvoriNoviTab">Portfolio</a><br>
										<p>
										Hello! My name is Anja Tomic and I come from Pancevo. This website is made for the course of Practicum of PHP. If you want to know something more about me you can click on link of my portfolio and contact me anytime....
										</p>
										<form method="POST" enctype="multipart/form-data" action="models/files/word_file_author.php">
											<input type="submit" name="author-to-word" id="author-to-word" value="EXPORT TO WORD">
										</form>

									</div>
								</div>
						</li>
						<li><a href="models/files/export_movies_to_excel.php" class="btn btninfo">Export movies</a></li>
					</ul>
				</div>

				<!-- footer list -->
				<div class="col-6 col-sm-4 col-md-3 col-lg-4 d-flex flex-column align-items-center justify-content-between">
					<h6 class="footer__title">Contact</h6>
					<ul class="footer__list">
						<li><a href="tel:+18002345678">+1 (800) 234-5678</a></li>
						<li><a href="mailto:flixgo4movies@gmail.com">flixgo4movies@gmail.com</a></li>
					</ul>
					<ul class="footer__social">
						<?php 
							$mreze = dohvatiSocialMedia();
							foreach($mreze as $mreza): 
						?>
						<li class="<?= $mreza->class?>">
							<a href="<?= $mreza->path?>" target="_blank">
								<?= $mreza->icon?>
							</a>
						</li>
                    	<?php endforeach;?>
					</ul>
				</div>
				<!-- end footer list -->

				<!-- footer list -->
				<div class="col-12 col-sm-6 col-md-4 col-lg-5 d-flex flex-column justify-content-between align-items-center text-center">
					<h4 class="footer__title">Newsletter</h4>
					<p class="subsc">Subscribe to our newsletter system now <br> to get latest news from us.</p>
					<form action="#">
						<input id="notification" type="text" placeholder="Enter your email...">
						<span class="emailVestigreska">*Email nije validan. Mora da bude ispisan sve malim slovima u formatu: nesto@gmail.com</span><br>
						<input type="button" class="btn" id="btnSubscribe" value="Subscribe now"/>
					</form>
					<!-- <a href="#" class="btn" id="btnSubscribe">Subscribe now <i class="ion-ios-arrow-forward"></i></a> -->
				</div>
				<!-- end footer list -->

				<!-- footer copyright -->
				<div class="col-12">
					<div class="footer__copyright">
						<small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

						<ul>
							<li><a href="#">Terms of Use</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
				<!-- end footer copyright -->
			</div>
		</div>
	</footer>
	<!-- end footer -->

	<!-- JS -->
	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/jquery.mousewheel.min.js"></script>
	<script src="assets/js/jquery.mCustomScrollbar.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
	<script src="assets/js/wNumb.js"></script>
	<script src="assets/js/nouislider.min.js"></script>
	<script src="assets/js/plyr.min.js"></script>
	<script src="assets/js/jquery.morelines.min.js"></script>
	<script src="assets/js/photoswipe.min.js"></script>
	<script src="assets/js/photoswipe-ui-default.min.js"></script>
	<script src="assets/js/main.js"></script>

	<script src="assets/js/myJs.js"></script>
</body>

</html>