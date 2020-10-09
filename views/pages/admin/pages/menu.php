<?php
        require_once("../../models/functions.php"); 
        $upit = "SELECT COUNT(*) as broj from menu";
        $obj = $konekcija->query($upit)->fetch();
        $poStrani = 5;
        $brojLink = ceil($obj->broj/$poStrani);
        $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
        $od = $poStrani*($strana-1);
        $upit = "SELECT * FROM menu LIMIT $od, $poStrani;";
        $menu= $konekcija->query($upit)->fetchAll();
            
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>NAVIGATION MENU LINKS</h2>
                        <input type="button" value="add" id='dodajNavLink' name="btnAddNavLink" class='btnAdminUpdate btn-primary form__btn'>
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
									<th>PATH</th>
									<th>EDIT</th>
								</tr>
							</thead>

							<tbody>
							<?php 
							$rb=1;
								foreach($menu as $m) :?>
								<tr>
									<td>
										<div class="main__table-text rb"><?=$rb++?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$m->name?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$m->path?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$m->id_menu?>"  class="podaciJedanLink main__table-btn main__table-btn--edit">
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
										<a href="admin.php?page=menu&strana=<?=$i+1?>" class="pagee" >
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
                    <div class="col-6" id="podaciNavEdit">
                        <h2>Update navlink</h2>
                        <form method="POST" action="../../models/menu/edit.php"  class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeNavs" id="skrivenoPoljeNavs" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbNameNav" id="tbNameNav" placeholder='Name of navlink' class='mr-2 profile__input'>
                            </div>

                            <div class=" d-flex justify-content-center">    
                                <input type="submit" value="Update" name='btnIzmenaNav' id='btnIzmenaNav' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaNav' class='btnAdmin btnIzmenaStyle form__btn'>
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
                    <div class="col-6 col-lg-6 col-sm-12" id="podaciNavAdd">
                        <h2>Add new nav-link</h2>
                        <form method="POST" action="../../models/menu/add.php" class="profile__form">
                            <div class="form-group">
                                <input type="hidden" name="skrivenoPoljeNavLinka" id="skrivenoPoljeNavLinka" class=form-control>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbName" id="tbName" placeholder='Name of navlink' class='mr-2 profile__input'>
                            </div>
                            <div class="form-group">
                                <input type="text" name="tbPath" id="tbPath" placeholder='Path' class='mr-2 profile__input'>
                            </div>
                            <div class=" d-flex justify-content-center">      
                                <input type="submit" value="Add" name='btnDodajNavLink' id='btnDodajNavLink' class='btnAdmin btnIzmenaStyle form__btn'>
                                <input type="button" value="Cancel" id='sakrijFormuZaNavDodaj' class='btnAdmin btnIzmenaStyle form__btn'>
                            </div>
                        </form>
                    </div>

                    <div class="odgovorAddNavLink text-belaGreske">
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