<?php
        require_once("../../models/genres/functions.php"); 
        $upit = "SELECT COUNT(*) as broj from genre";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 4;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT * FROM genre LIMIT $od, $poStrani;";
        $zanrovi= $konekcija->query($upit)->fetchAll();
            
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Genres</h2>
                        <input type="button" value="add" id='dodajZanr' name="btnAddZanr" class='btnAdminUpdate btn-primary form__btn'>
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
							$rb=1;
								foreach($zanrovi as $z) :?>
								<tr>
									<td>
										<div class="main__table-text rb"><?=$z->id_genre?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$z->name?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$z->id_genre?>" class="podaciJedanZanr main__table-btn main__table-btn--edit  ">
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
										<a href="admin.php?page=genres&strana=<?=$i+1?>" class="pagee" >
											<?=$i+1 ?>
										</a>
									</li>
                            <?php endfor;?>   
                        </ul>
                        <?php endif;?>
					</div>
				</div>
                <!-- end paginator -->

                <!-- Edit genre -->
                <div class="container">
                <div class="row">
                    <div class="col-6" id="podaciGenresEdit">
                        <h2>Update genre</h2>
                        <form  method="POST"action="../../models/genres/edit.php"  class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeZanr" id="skrivenoPoljeZanr" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivZanr" id="tbNazivZanr" placeholder='Genre' class='mr-2 profile__input'>
                            </div>

                            <div class=" d-flex justify-content-center">    
                                <input type="submit" value="Update" name='btnIzmenaZanr' id='btnIzmenaZanr' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaZanrove' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateZanr text-belaGreske">
                        <?php if(isset($_SESSION['poruka'])):
                            echo $_SESSION['poruka'];
                            unset($_SESSION['poruka']);

                            endif; ?>
                    </div>
               
                </div>
                </div>

	        <!-- Add genre -->
                <div class="container">
                <div class="row">
                    <div class="col-6 col-lg-6 col-sm-12" id="podaciGenresAdd">
                        <h2>Add new genre</h2>
                        <form method="POST" action="../../models/genres/add.php" class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeZanra" id="skrivenoPoljeZanra" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivZanra" id="tbNazivZanra" placeholder='Genre' class='mr-2 profile__input'>
                            </div>
                            <div class=" d-flex justify-content-center">      
                                <input type="submit" value="Add" name='btnDodajGenre' id='btnDodajGenre' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaZanroveDodaj' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorAddZanr text-belaGreske">
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