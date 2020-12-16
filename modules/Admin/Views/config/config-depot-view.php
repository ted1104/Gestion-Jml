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
													 <h4>CONFIGURATION DEPOT</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative au dépôt</h5>
                            </div>
                            <div class="card-body">
                                  <div class="form-group">
                                    <label for="codeArt">Nom *</label>
                                    <input type="text" class="form-control" id="nom" aria-describedby="nom" v-model="nom">
                                  </div>
                                  <div class="form-group">
                                    <label for="nom_article">Adresse </label>
                                    <input type="text" class="form-control" id="adresse" v-model="adresse">
                                  </div>
                              		<button v-if="!isLoadSaveMainButton" @click="add_depot" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-8 col-lg-8 col-xl-8">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <h5 class="card-title text-black">Dépôts Recemment ajoutés</h5>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-secondary">
                                      <th scope="col">Nom dépôt</th>
                                      <th scope="col">Adresse</th>
                                      <th scope="col">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in dataToDisplay">
                                      <th>{{dt.nom}}</th>
                                      <td>{{dt.adresse}}</td>
                                      <td><a href="#"  class='btn btn-round btn-light' ><i class='mdi mdi-circle-edit-outline text-danger'></i> </a></td>

                                    </tr>
                                  </tbody>
                                </table>
																<!-- LOAD FOR WAITING DATA -->
																<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/load/load-tab.gif" alt="">
																</div>
																<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
																</div>
																<!-- PAGINATION -->
                              </div>
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
            <div class="modal-body">

							<div class="form-group">
								<label for="prix_unitaire">Prix Unitaire *</label>
								<input type="text" class="form-control" id="prix_unitaire" aria-describedby="prix_unitaire" v-model="prix_unitaire">
							</div>
							<div class="form-group">
								<label for="qte_decideur">Quantité *</label>
								<input type="text" class="form-control" id="qte_decideur" aria-describedby="qte_decideur" v-model="qte_decideur">
							</div>
							<button @click="add_article_prix" class="btn btn-primary">Enregistrer</button>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Ok</button>
            </div> -->
        </div>
    </div>
</div>
<?=$this->endSection() ?>
