<?php
        require_once("../../models/quality/functions.php"); 
        $upit = "SELECT COUNT(*) as broj from quality";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 5;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT * FROM quality LIMIT $od, $poStrani;";
        $rezolucije= $konekcija->query($upit)->fetchAll();
            
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Resolutions</h2>
                        <input type="button" value="add" id='dodajRezoluciju' name="btnAddQuality" class='btnAdminUpdate btn-primary form__btn'>
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
								foreach($rezolucije as $r) :?>
								<tr>
									<td>
										<div class="main__table-text rb"><?=$rb++?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$r->value?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$r->id_quality?>"  class="podaciJedanQuality main__table-btn main__table-btn--edit">
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
										<a href="admin.php?page=quality&strana=<?=$i+1?>" class="pagee" >
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
                    <div class="col-6" id="podaciQualityEdit">
                        <h2>Update quality</h2>
                        <form method="POST" action="../../models/quality/edit.php"  class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeRezolucija" id="skrivenoPoljeRezolucija" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivRezolucija" id="tbNazivRezolucija" placeholder='Resolution' class='mr-2 profile__input'>
                            </div>

                            <div class=" d-flex justify-content-center">    
                                <input type="submit" value="Update" name='btnIzmenaRezolucija' id='btnIzmenaRezolucija' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaRezolucije' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorUpdateQuality text-belaGreske text-center ml-5">
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
                    <div class="col-6 col-lg-6 col-sm-12" id="podaciQualityAdd">
                        <h2>Add new quality</h2>
                        <form method="POST" action="../../models/quality/add.php" class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeBrenda" id="skrivenoPoljeBrenda" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNazivRezolucije" id="tbNazivRezolucije" placeholder='Resolution' class='mr-2 profile__input'>
                            </div>
                            <div class=" d-flex justify-content-center">      
                                <input type="submit" value="Add" name='btnDodajQuality' id='btnDodajQuality' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaRezolucijeDodaj' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorAddQuality text-belaGreske">
                    <?php if(isset($_SESSION['porukaAdd'])):
                            echo $_SESSION['porukaAdd'];
                            unset($_SESSION['porukaAdd']);

                            endif; ?>
                    </div>
                </div>
			</div>
			</div>
		</div>
	</main>
	<!-- end main content -->