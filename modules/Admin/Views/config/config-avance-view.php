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
                              		<button v-if="!isLoadSaveMainButton" @click="_u_open_mod_popup_systeme(1)" class="btn btn-primary">Valider</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
	                            </div>
	                        </div>
												</div>
												<div class="col-md-3 col-lg-3 col-xl-3 ">
													<div class="card m-b-30">
	                            <div class="card-header bg-white text-center">
	                                <h5 class="card-title text-black">CLOTURE CAISSE</h5>
	                            </div>
	                            <div class="card-body text-center">
                              		<button v-if="!isLoadSaveMainButton" @click="_u_open_mod_popup_systeme(2)" class="btn btn-primary">Valider</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
	                            </div>
	                        </div>
												</div>
												<div class="col-md-3 col-lg-3 col-xl-3 ">
													<div class="card m-b-30">
	                            <div class="card-header bg-white text-center">
	                                <h6 class="text-black">BLOQUER LES COMPTES</h6>
	                            </div>
	                            <div class="card-body text-center">
                              		<button v-if="!isLoadSaveMainButton" @click="_u_open_mod_popup_systeme(3)" class="btn btn-primary">Valider</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
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
							</div>
							<br>
							<button @click="add_article_prix" class="btn btn-danger">Je confirme</button>
            </div>

        </div>
    </div>
</div>
<?=$this->endSection() ?>
