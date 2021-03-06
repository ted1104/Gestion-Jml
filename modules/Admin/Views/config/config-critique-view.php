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
													 <h4>CONFIGURATION ETAT CRITIQUE STOCK & MOTIF DECAISSEMENT</h4>

											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative aux critiques</h5>
                            </div>
                            <div class="card-body">
                                  <div class="form-group">
                                    <label for="codeArt">Nombre Minimum *</label>
                                    <input type="text" class="form-control" id="nom" aria-describedby="nom" v-model="montant_min">
                                  </div>
                                  <div class="form-group">
                                    <label for="nom_article">Nombre Maximum </label>
                                    <input type="text" class="form-control" id="adresse" v-model="montant_max">
                                  </div>
                              		<button v-if="!isLoadSaveMainButton" @click="update_etat_critique_config" class="btn btn-primary">Modifier</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>

												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
														<div class="card-header bg-white">
																<h5 class="card-title text-black">Ajouter Motif Destination decaissement</h5>
														</div>
														<div class="card-body">
																	<div class="form-group">
																		<label for="nom_motif_decaissement">Nom destination *</label>
																		<input type="text" class="form-control" id="nom_motif_decaissement" aria-describedby="nom_motif_decaissement" v-model="nom_motif_decaissement">
																	</div>

																	<div class="" v-if="!this.wantToUpdate">
																		<button v-if="!isLoadSaveMainButtonModal" @click="add_motif_destination_decaissement" class="btn btn-primary">Enregistrer</button>
																		<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																	</div>

																	<div class="row" v-if="this.wantToUpdate">
																		<div class="col-6">
																			<button v-if="!isLoadSaveMainButtonModal" @click="update_motif_decaissement_externe" class="btn btn-primary">Modifier</button>
																			<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																		</div>
																		<div class="col-6">
																			<button v-if="!isLoadSaveMainButtonSecond" @click="desable_activated_status_motif_decaissement_externe" :class="this.MotifDecaissementStatus==1?'btn btn-danger pull-right':'btn btn-success pull-right'">{{this.MotifDecaissementStatus==1?'Désactiver':'Activer'}}</button>
																			<img v-if="isLoadSaveMainButtonSecond" src="<?=base_url() ?>/public/load/loader.gif" alt="" class="pull-right">
																		</div>
																	</div>

														</div>
												</div>
												</div>
												<div class="col-md-4 col-lg-4 col-xl-4">
													<!-- {{checkBoxArticles}} -->
													<div class="card m-b-30">
														<div class="card-body">

															<div class="table-responsive">
																	<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Destination Type</th>
																		<th scope="col">Status</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in ListMotifDecaissement">
																		<th>{{dt.description}}</th>
																		<td>
																			<span :class="dt.is_active==0?'badge badge-danger':'badge badge-success'">{{dt.is_active==0 ?'Desactiver':'Activer'}}</span>
																		</td>
																		<!-- <td>{{dt.responsable_id}}</td> -->
																		<!-- <td>{{dt.is_central ==1 ?'Oui':'Non'}}</td>-->
																		<td>
																			<div v-if="indexTopUpdate!=index">
																				<button type="button" class='btn btn-round btn-secondary' name="button" @click="_u_update_motif(dt,index)" :disabled="indexTopUpdate"><i class='mdi mdi-circle-edit-outline text-white'></i></button>
																			</div>
																			<div v-if="indexTopUpdate==index">
																				<button type="button" class='btn btn-round btn-info' name="button" @click="_u_update_motif(dt,index)"><i class='mdi mdi-close'></i></button>
																			</div>
																		</td>

																	</tr>
																</tbody>
															</table>
																	<!-- LOAD FOR WAITING DATA -->
																	<div class="text-center" v-if="ListMotifDecaissement.length < 1 && !isNoReturnedData">
																		<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
																	</div>
																	<div class="text-center" alt="" v-if="ListMotifDecaissement.length < 1 && isNoReturnedData">
																		<img src="<?=base_url() ?>/public/load/empty.png" >
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
