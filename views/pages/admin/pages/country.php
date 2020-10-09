<?php
        require_once("../../models/country/functions.php"); 
        $upit = "SELECT COUNT(*) as broj from country";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 5;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT * FROM country LIMIT $od, $poStrani;";
        $drzave= $konekcija->query($upit)->fetchAll();
            
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Countries</h2>
                        <input type="button" value="add" id='dodajDrzavu' name="btnAddCountry" class='btnAdminUpdate btn-primary form__btn'>
					</div>
				</div>
				<!-- end main title -->

				<!-- users -->
				<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table">
							<thead>
								<tr>
									<th>#</th>
									<th>NAME</th>
									<th>EDIT</th>
								</tr>
							</thead>

							<tbody>
							<?php 
								foreach($drzave as $d) :?>
								<tr>
									<td>
										<div class="main__table-text rb"><?=$d->id_country?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$d->name?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$d->id_country?>"  class="podaciJednaDrzava main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
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
										<a href="admin.php?page=country&strana=<?=$i+1?>" class="pagee" >
											<?=$i+1 ?>
										</a>
									</li>
                            <?php endfor;?>
                        </ul>
                        <?php endif;?>
					</div>
				</div>
                <!-- end paginator -->

                <!-- Edit quality -->
                <div class="container">
                <div class="row">
                    <div class="col-6" id="podaciCountryEdit">
                        <h2>Update quality</h2>
                        <form method="POST" action="../../models/country/edit.php"  class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeDrzava" id="skrivenoPoljeDrzava" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivDrzava" id="tbNazivDrzava" placeholder='Resolution' class='mr-2 profile__input'>
                            </div>

                            <div class=" d-flex justify-content-center">    
                                <input type="submit" value="Update" name='btnIzmenaDrzava' id='btnIzmenaDrzava' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaDrzavu' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateCountry text-belaGreske">
                        <?php if(isset($_SESSION['poruka'])):
                            echo $_SESSION['poruka'];
                            unset($_SESSION['poruka']);

                            endif; ?>
                    </div>
                </div>
                </div>

	        <!-- Add quality -->
                <div class="container">
                <div class="row">
                    <div class="col-6 col-lg-6 col-sm-12" id="podaciCountryAdd">
                        <h2>Add new quality</h2>
                        <form method="POST" action="../../models/country/add.php" class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeBrenda" id="skrivenoPoljeBrenda" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivDrzave" id="tbNazivDrzave" placeholder='Country' class='mr-2 profile__input'>
                            </div>
                            <div class=" d-flex justify-content-center">      
                                <input type="submit" value="Add" name='btnDodajCountry' id='btnDodajCountry' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaDrzavuDodaj' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateCountry text-belaGreske">
                        <?php if(isset($_SESSION['poruka'])):
                            echo $_SESSION['poruka'];
                            unset($_SESSION['poruka']);

                                endif; ?>
                    </div>
                </div>
			</div>
			</div>
		</div>
	</main>
	<!-- end main content -->