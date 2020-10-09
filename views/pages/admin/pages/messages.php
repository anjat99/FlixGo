<?php
         require_once("../../models/contact/functions.php");
		 $upit = "SELECT COUNT(*) as broj from contact_info";
		 $obj = $konekcija->query($upit)->fetch();
		 $poStrani = 5;
		 $brojLink = ceil($obj->broj/$poStrani);
		 $strana = isset($_GET['strana']) ? $_GET['strana'] : 1;
		 $od = $poStrani*($strana-1);
		 $upit = "SELECT * FROM contact_info ORDER BY date DESC LIMIT $od, $poStrani;";
		 $poruke= $konekcija->query($upit)->fetchAll(); 
?>
<!-- main content -->
<main class="main">
		<div class="container-fluid">
			<div class="row">
				<!-- main title -->
				<div class="col-12">
					<div class="main__title">
						<h2>Messages</h2>
					</div>
				</div>
				<!-- end main title -->

				<!-- users -->
				<div class="col-12">
					<div class="main__table-wrap">
						<table class="main__table">
							<thead>
								<tr>
									<th>RB</th>
									<th>EMAIL</th>
									<th>TITLE</th>
									<th>MESSAGE</th>
									<th>DATE OF SENT</th>
									<th>ACTIONS</th>
								</tr>
							</thead>

							<tbody>
							<?php 
							 	$rb=1;
								foreach($poruke as $p) :?>
								<tr>
									<td>
										<div class="main__table-text"><?=$rb++?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$p->email?></div>
									</td>
									<td>
										<div class="main__table-text"><?=$p->title?></div>
									</td>
									<td>
										<div class="main__table-text main__table-text--green">
										<?php
													if(strlen($p->message)<=30)
													{
													  echo $p->message;
													}
													else
													{
														$p->message=substr($p->message,0,30) . '...';
													  echo $p->message;
													}
											?>
										</div>
									</td>
									<td>
										<div class="main__table-text"><?=$p->date?></div>
									</td>
									<td>
										<div class="main__table-btns">
											<a href="#" data-id="<?=$p->id_contact?>" class="detalji-poruke main__table-btn main__table-btn--edit">
												<i class="icon ion-ios-create"></i>
											</a>
											<a href="#" data-id="<?=$p->id_contact?>" class="obrisi-poruku main__table-btn main__table-btn--delete">
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
											<a href="admin.php?page=messages&strana=<?=$i+1?>" class="pagee" >
												<?=$i+1 ?>
											</a>
										</li>
								<?php endfor;?>
							</ul>
							<?php endif;?>
					</div>
				</div>
				<!-- end paginator -->

				 <!-- Details of message -->
				 <div class="container">
					<div class="row">
                    	<div class="col-12 col-sm-12 col-lg-12" id="detalji-poruke">
                        	
                    	</div>
                	</div>
				</div>
			

			</div>
		</div>
	</main>
	<!-- end main content -->

	