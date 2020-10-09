<?php zabeleziPristupStranici();?>
<div class="sign section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<!-- authorization form -->
						<form action="models/login.php" method="POST" class="sign__form">
							<a href="index.php" class="sign__logo">
								<img src="assets/images/logo.svg" alt="logo">
							</a>

							<div class="sign__group">
								<input type="text" name="tbEmail" id="tbEmail" class="sign__input" placeholder="Email">
								<p class="text-danger" id="emailGreskaLogin"></p>
							</div>

							<div class="sign__group">
								<input type="password" name="tbLozinka" id="tbLozinka"  class="sign__input" placeholder="Password">
								<p class="text-danger" id="lozinkaGreskaLogin"></p>
							</div>

							
							<button class="sign__btn" name="btnLogin" id="btnLogin" type="button">Login</button>

							<span class="sign__text">Don't have an account? <a href="index.php?page=register">Register!</a></span>

							<div id="porukaGreskeLogin"></div>
						</form>
						<!-- end authorization form -->
					</div>
				</div>
			</div>
		</div>
	</div>