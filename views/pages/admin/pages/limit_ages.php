<?php
        require_once("../../models/limit-ages/functions.php"); 
        $upit = "SELECT COUNT(*) as broj from limit_age";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 5;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT * FROM limit_age LIMIT $od, $poStrani;";
        $limitGodine= $konekcija->query($upit)->fetchAll();
            
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Limit of age</h2>
                        <input type="button" value="add" id='dodajLimitGodina' name="btnAddLimit" class='btnAdminUpdate btn-primary form__btn'>
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
								foreach($limitGodine as $lg) :?>
								<tr>
									<td>
										<div class="main__table-text rb"><?=$lg->id_limit_age?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$lg->value?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$lg->id_limit_age?>"  class="podaciJednoOgranicenjeGodina main__table-btn main__table-btn--edit">
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
										<a href="admin.php?page=limit_ages&strana=<?=$i+1?>" class="pagee" >
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
                    <div class="col-6" id="podaciLimitAgeEdit">
                        <h2>Update quality</h2>
                        <form method="POST" action="../../models/limit-ages/edit.php"  class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeLimit" id="skrivenoPoljeLimit" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivLimit" id="tbNazivLimit" placeholder='Resolution' class='mr-2 profile__input'>
                            </div>

                            <div class=" d-flex justify-content-center">    
                                <input type="submit" value="Update" name='btnIzmenaAge' id='btnIzmenaAge' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaLimit' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateAge text-belaGreske">
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
                    <div class="col-6 col-lg-6 col-sm-12" id="podaciLimitAgeAdd">
                        <h2>Add new quality</h2>
                        <form method="POST" action="../../models/limit-ages/add.php" class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeOgranicenjaGodina" id="skrivenoPoljeOgranicenjaGodina" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivOgranicenjaGodina" id="tbNazivOgranicenjaGodina" placeholder='Limit age' class='mr-2 profile__input'>
                            </div>
                            <div class=" d-flex justify-content-center">      
                                <input type="submit" value="Add" name='btnDodajLimitAge' id='btnDodajLimitAge' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaLimitDodaj' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateAge text-belaGreske">
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