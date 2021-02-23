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
													 <h4>CONFIGURATION AVANCEE</h4>

											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-3 col-lg-3 col-xl-3 ">
													<div class="card m-b-30">
	                            <div class="card-header bg-white text-center">
	                                <h5 class="card-title text-black">CLOTURE STOCK DEPOT</h5>
	                            </div>
	                            <div class="card-body text-center">
                              		<button @click="_u_open_mod_popup_systeme(1)" class="btn btn-primary">clôturer</button>
																	<!-- <img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt=""> -->
	                            </div>
	                        </div>
												</div>
												<div class="col-md-3 col-lg-3 col-xl-3 ">
													<div class="card m-b-30">
	                            <div class="card-header bg-white text-center">
	                                <h5 class="card-title text-black">CLOTURE CAISSE</h5>
	                            </div>
	                            <div class="card-body text-center">
                              		<button @click="_u_open_mod_popup_systeme(2)" class="btn btn-primary">clôturer</button>
																	<!-- <img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt=""> -->
	                            </div>
	                        </div>
												</div>
												<div class="col-md-3 col-lg-3 col-xl-3 ">
													<div class="card m-b-30">
	                            <div class="card-header bg-white text-center">
	                                <h6 class="text-black">OPERATION SUR LES COMPTES</h6>
	                            </div>
	                            <div class="card-body text-center">
                              		<button @click="_u_open_mod_popup_systeme(3)" class="btn btn-success">Activer</button>
																	<button @click="_u_open_mod_popup_systeme(4)" class="btn btn-danger">Desactiver</button>
																	<!-- <img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt=""> -->
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

		<!-- MODAL -->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
                <button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
							<div class="text-center">
								<span class="text-center"><i class="mdi mdi-alert icon-size-1x"></i></span><br>
								<span class="text-danger">
									{{textDescriptif}}
								</span>
								<br>
								<div class="form-group col-md-12 text-center">
									<label for="password_op">Renseigner votre Mot de passe des operations *</label>
									<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
								</div>
							</div>
							<div v-if="!passIsCorrectCanProcceed">
								<button v-if="!isLoadSaveMainButton"  @click="_u_check_if_password_op_is_correct" class="btn btn-info">Vérifier Mot de passe</button>
							</div>
							<div v-if="passIsCorrectCanProcceed">
								<span class="text-success">Mot de passe des operations correctes pour finaliser avec le processus veuillez cliquer sur le bouton ci-dessous</span>
								<button v-if="!isLoadSaveMainButton"  @click="operation_systeme_config(typeAction)" class="btn btn-danger">Je confirme</button>
							</div>
							<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
            </div>

        </div>
    </div>
</div>
<?=$this->endSection() ?>
