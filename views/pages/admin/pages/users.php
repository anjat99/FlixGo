<?php
        require_once("../../models/users/functions.php");
        $upit = "SELECT COUNT(*) as broj from user";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 5;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT COUNT(r.id_review)as broj, u.id_user as id_user, u.username as username, u.email as email, u.dateReg as datumReg, p.name as ime, p.surname as prezime, rol.name as uloga FROM user u INNER JOIN person_role pr on u.id_person_role=pr.id_person_role INNER JOIN role rol ON rol.id_role=pr.id_role INNER JOIN person p ON p.id_person=pr.id_person LEFT OUTER JOIN user_review ur ON ur.id_user=u.id_user LEFT OUTER JOIN review r ON r.id_review=ur.id_review GROUP BY u.id_user ORDER BY datumReg DESC LIMIT $od, $poStrani;";
        $korisnici= $konekcija->query($upit)->fetchAll(); 
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Users</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- users -->
				<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table">
							<thead>
								<tr>
									<th>ID</th>
									<th>BASIC INFO</th>
									<th>USERNAME</th>
									<th>NO.REVIEWS</th>
									<th>ROLE</th>
									<th>DATE OF REG</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach($korisnici as $k) :?>
								<tr>
									<td>
										<div class="main__table-text"><?=$k->id_user?></div>
									</td>
									<td>
										<div class="main__user">
											<div class="main__meta">
												<h3><?=$k->ime?> <?=$k->prezime?></h3>
												<span><?=$k->email?></span>
											</div>
										</div>
									</td>
									<td>
										<div class="main__table-text"><?=$k->username?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$k->broj?></div>
									</td>
									<td>
										<div class="main__table-text main__table-text--green"><?=$k->uloga?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$k->datumReg?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$k->id_user?>" class="podaciJedanKorisnik main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
											</a>
											<a href="#" data-id="<?=$k->id_user?>" class="obrisi main__table-btn main__table-btn--delete">
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
						<span> <?php echo $obj->broj ?> Total</span>
						<?php  if(($obj->broj)>$poStrani): ?>
							<ul class="paginator">
								<?php
									for($i=0;$i<$brojLink;$i++):?>
										<li class="paginator__item" >
											<a href="admin.php?page=users&strana=<?=$i+1?>" class="pagee" >
												<?=$i+1 ?>
											</a>
										</li>
								<?php endfor;?>
							</ul>
							<?php endif;?>
					</div>
				</div>
				<!-- end paginator -->


	<!-- details form -->
	<div class="col-12 col-lg-12"  id="podaci">
		<form method="POST" action="../../models/users/update.php" class="profile__form">
			<div class="row">
				<div class="col-12">
					<h4 class="profile__title">Profile details</h4>
				</div>
				<div class="form-group">
					<input type="hidden" name="skrivenoPolje" id="skrivenoPolje" class=form-control>
				</div>

				<div class="col-12 col-md-6 col-lg-12 col-xl-6">
					<div class="profile__group">
						<label class="profile__label" for="firstname">First Name</label>
						<input id="tbIme" type="text" name="tbIme" class="profile__input" placeholder="John">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-12 col-xl-6">
					<div class="profile__group">
						<label class="profile__label" for="lastname">Last Name</label>
						<input id="tbPrezime" type="text" name="tbPrezime" class="profile__input" placeholder="Doe">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-12 col-xl-6">
					<div class="profile__group">
						<label class="profile__label" for="username">Username</label>
						<input id="tbUsername" type="text" name="tbUsername" class="profile__input" placeholder="user5715">
					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-12 col-xl-6">
					<div class="profile__group">
						<label class="profile__label" for="email">Email</label>
						<input id="tbEmail" type="text" name="tbEmail" class="profile__input" placeholder="example@gmail.com">
					</div>
				</div>


				<div class="col-12 col-md-6 col-lg-12 col-xl-6">
					<div class="profile__group form-group">
						<label class="profile__label" for="ddlUloga">Rights</label>
						<select class="js-example-basic-single form-control" name='ddlUloga' id='ddlUloga'>
							<?php
									$upitZaUloge=get_roles();

									foreach ($upitZaUloge as $u):?>
										<option value="<?=$u->id_role?>"><?=$u->name?></option>
									<?php endforeach;
								?>
						</select>
					</div>
				</div>

				<div class=" d-flex justify-content-center">    
					<input type="submit" value="Update" name='btnIzmena' id='btnIzmena' class='btnAdmin btnIzmenaStyle form__btn'>
					<input type="button" value="Cancel" id='sakrijFormu' class='btnAdmin btnIzmenaStyle form__btn'>
				</div>
			</div>
		</form>
	</div>

	
	<!-- end details form -->
	<div class="odgovorUpdate  text-belaGreske">
		<?php if(isset($_SESSION['poruka'])):
			echo $_SESSION['poruka'];
			unset($_SESSION['poruka']);

			endif; ?>
	</div>

				<!-- END --->
			</div>
		</div>
	</main>
	<!-- end main content -->