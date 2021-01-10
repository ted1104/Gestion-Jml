<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>


    <!-- Start XP Container -->
    <div id="xp-container">
        <!-- Start XP Leftbar -->
        <div class="xp-leftbar">
          <?=$this->include('partials/_menu_main') ?>
        </div>
        <!-- End XP Leftbar -->
        <!-- Start XP Rightbar -->
        <div class="xp-rightbar">
          <?=$this->include('partials/_header_main') ?>
            <!-- Start XP Breadcrumbbar -->
            <?=$this->include('partials/_page_title') ?>
            <!-- End XP Breadcrumbbar -->
            <!-- Start XP Contentbar -->
            <div class="xp-contentbar">
                <!-- Write page content code here -->
                <!-- Start XP Row -->
                <div class="row">
									<!-- Start XP Col -->
									 <div class="col-md-12 col-lg-12 col-xl-12">
											 <div class="text-center mt-3 mb-5">
													 <h4>MON COMPTE</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<!-- OPERATION ADD COMMANDE -->
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
														<div class="card m-b-30">
		                            <div class="card-header bg-white">
		                                <h5 class="card-title text-black">PHOTO PROFILE</h5>
		                            </div>
		                            <div class="card-body">


		                            </div>
	                        		</div>
													</div>
													<div class="col-md-4 col-lg-4 col-xl-4 ">
															<div class="card m-b-30">
																	<div class="card-header bg-white">
																			<h5 class="card-title text-black">MOT DE PASSE DE CONNEXION</h5>
																	</div>
																	<div class="card-body">
																		<div class="form-group">
																			<label for="ancien_password_main">Ancien Mot de passe</label>
																			<input type="password" class="form-control" id="ancien_password_main" v-model="ancien_password_main">
																		</div>
																		<div class="form-group">
																			<label for="password_main">Nouveau Mot de passe</label>
																			<input type="password" class="form-control" id="password_main" v-model="password_main">
																		</div>
																		<div class="form-group">
																			<label for="password_main_conf">Confirmer Nouveau Mot de passe</label>
																			<input type="password" class="form-control" id="password_main_conf" v-model="password_main_conf">
																		</div>
																		<button v-if="!isLoadSaveMainButton" @click="change_password_account_users_connexion" class="btn btn-primary">Enregistrer</button>
																		<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																	</div>
																</div>
														</div>
														<div class="col-md-4 col-lg-4 col-xl-4 ">
																<div class="card m-b-30">
																		<div class="card-header bg-white">
																				<h5 class="card-title text-black">MOT DE PASSE DES OPERATIONS</h5>
																		</div>
																		<div class="card-body">
																			<div class="form-group">
																				<label for="ancien_password_op">Ancien Mot de passe</label>
																				<input type="password" class="form-control" id="ancien_password_op" v-model="ancien_password_op">
																			</div>
																			<div class="form-group">
																				<label for="password_op">Nouveau Mot de passe</label>
																				<input type="password" class="form-control" id="password_op" v-model="password_op">
																			</div>

																			<div class="form-group">
																				<label for="password_op_conf">Confirmer Nouveau Mot de passe</label>
																				<input type="password" class="form-control" id="password_op_conf" v-model="password_op_conf">
																			</div>

																			<button v-if="!isLoadSaveMainButtonModal" @click="change_password_account_users_operations" class="btn btn-primary">Enregistrer</button>
																			<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">

																		</div>
																	</div>
															</div>
											</div>

										</div>
                    <!-- End XP Col -->
                </div>
                <!-- End XP Row -->
            </div>
            <!-- End XP Contentbar -->
            <!-- Start XP Footerbar -->
          <?=$this->include('partials/_footer_main') ?>
            <!-- End XP Footerbar -->
        </div>
        <!-- End XP Rightbar -->
    </div>
    <!-- End XP Container -->
<?=$this->endSection() ?>
