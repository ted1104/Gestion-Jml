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
													 <h4>DECAISSEMENT DU SOLDE</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Informations relatives au decaissement</h5>
                            </div>
                            <div class="card-body">
																	<div class="form-group">
																		<label for="payer_a">Caissier</label>
																		<select class="form-control" v-model="caissier">
																			<option v-for="(c, i) in caissierList" :value="c.id">{{c.nom+' '+c.prenom}}</option>
																		</select>
																	</div>
                                  <div class="form-group">
                                    <label for="nom_article">Montant *</label>
                                    <input type="text" class="form-control" v-model="montant_decaisse">
                                  </div>

																	<div class="form-group">
                                    <label for="description">Note *</label>
                                    <textarea class="form-control" name="inputTextarea" id="description" rows="3" v-model="note"></textarea>
                                  </div>
                              		<button v-if="!isLoadSaveMainButton" @click="add_decaissement_demande" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-8 col-lg-8 col-xl-8">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <h5 class="card-title text-black">Historique décaissement</h5>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-secondary">
                                      <th scope="col">Date</th>
                                      <th scope="col">Caissier</th>
																			<th scope="col">Caissier Principal</th>
                                      <th scope="col">Montant</th>
                                      <th scope="col">Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in dataToDisplay">
                                      <td>{{dt.date_decaissement}}</td>
                                      <td>{{dt.users_id_from.nom+' '+dt.users_id_from.prenom}}</td>
																			<td>{{dt.users_id_dest.nom+' '+dt.users_id_dest.prenom}}</td>
																			<td>{{dt.montant}} USD</td>
																			<td>
																					<span :class="dt.status_operation==0?'badge badge-warning':'badge badge-success'">{{dt.status_operation==0?'EN ATTENTE':'VALIDEE'}}</span>
																			</td>


                                    </tr>
                                  </tbody>
                                </table>
																<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
																</div>
																<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
																</div>
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
	<!-- <div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div> -->
<?=$this->endSection() ?>
