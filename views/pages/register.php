<?php zabeleziPristupStranici();?>
<div class="sign section--bg" data-bg="assets/images/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="sign__content">
						<!-- registration form -->
						<form action="/models/register.php" method="POST" enctype="multipart/form-data" class="sign__group">
							<a href="index.html" class="sign__logo">
								<img src="assets/images/logo.svg" alt="">
							</a>

							<div class="form-group sign__group">
								<input type="text" id="ime" name="ime" class="sign__input" placeholder="Name">
								<p class='text-danger' id="imeGreskaRegister"> </p>
								
							</div>

							<div class="form-group sign__group">
								<input type="text" id="prezime" name="prezime" class="sign__input" placeholder="Surname">
									<p class='text-danger' id="prezimeGreskaRegister"> </p>
							</div>

							<div class="form-group sign__group">
								<input type="text"  id="username" name="username" class="sign__input" placeholder="Username">
								<p class='text-danger' id="usernameGreskaRegister"> </p>
							</div>

							<div class="form-group sign__group">
								<input type="email"  id="email" name="email" class="sign__input" placeholder="Email">
								<p class='text-danger' id="emailGreskaRegister"></p>
							</div>

							<div class="form-group sign__group">
								<input type="password" id="lozinka" name="lozinka" class="sign__input" placeholder="Password">
								<p class='text-danger' id="lozinkaGreskaRegister"></p>
							</div>


							<div class="form-group">
								<label class="label_dateofbirth" for="dateofbirth">Date Of Birth</label>
								<input type="date" name="dateofbirth" id="dateofbirth" value="" min="1950-01-01" max="2018-12-31"> 
								<p class='text-danger' id="datumGreskaRegister"> </p>
							</div> 
							
							
							<input class="sign__btn" id="btnRegistracija" name="btnRegistracija" type="button" value="register"/>

							<span class="sign__text">Already have an account? <a href="index.php?page=login">Login!</a></span>

							<div id="poruka"></div>
						</form>
						<!-- registration form -->
					
					</div>
				</div>
			</div>
		</div>
	</div>