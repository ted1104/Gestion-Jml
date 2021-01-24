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
													 <h4>LISTE DE TOUS LES CAISSIERS</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div :class="isShow ? 'col-md-8 col-lg-8 col-xl-8':'col-md-12'">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
														<div class="row">
															<h5 class="card-title text-black col-md-9">CAISSE</h5>
															<h5 class="col-md-3 text-right text-secondary">{{montantTotalAllCommandeParTypeVente}} USD</h5>
														</div>

                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
																<table class="table">
																	<thead>
																		<tr class="bg-secondary">
																			<th scope="col">Nom</th>
																			<th scope="col">Prenom</th>
																			<th scope="col">Sexe</th>
																			<th scope="col">Type</th>
																			<th scope="col">Montant Reste</th>
																			<th scope="col">Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr v-for="(dt, index) in caissierList" :class="currentLineSelectedInList==index?'bg-light':''">
																			<th>{{dt.nom}}</th>
																			<td>{{dt.prenom}}</td>
																			<td>{{dt.sexe}}</td>
																			<td>CAISSIER {{dt.is_main==1?'PRINCIPAL':'SECONDAIRE'}}</td>
																			<td>{{dt.logic_montant_caisse}} USD</td>
																			<td>
																				<!-- <a href="#"  class='btn btn-round btn-secondary' ><i class='mdi mdi-eye-outline'></i></a>
																				<a href="#" v-if="checkBoxArticles.length>0"  class='btn btn-round btn-info' ><i class="mdi mdi-circle-edit-outline text-white"></i></a> -->

																				<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<div class="text-center" v-if="caissierList.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="" >
																</div>
																<div class="text-center" alt="" v-if="caissierList.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
																</div>
                              </div>
                          </div>
                        </div>
												</div>


												<div v-if="isShow" :class="isShow ? 'col-md-4 col-lg-4 col-xl-4':''">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container" v-if="!isShowBlocHistoFactureStatus">
															<div class="row">
																<div class="col-md-10">
																	<h5 class="card-title">DETAIL OPERATIONS AUJORD'HUI</h5>
																	<div class="text-center">
																		<p>{{detailTab.nom+' '+detailTab.prenom}}</p>
																	</div>
																</div>
																<div class="col-md-2">
																	<i class="mdi mdi-close-circle  text-right text-danger cursor" @click="isShow=!isShow"></i>
																</div>
																<div class="table-responsive">
																	<div class="container">
																		<table class="table">
																			<thead>
																				<tr class="bg-secondary">
																					<th scope="col">Operation</th>
																					<th scope="col">Montant</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>
																					<td>Achats</td>
																					<td>{{detailTab.logic_operation_finance.achat}} USD</td>
																				</tr>
																				<tr v-if="detailTab.is_main==1">
																					<td>Encaissement Interne</td>
																					<td>{{detailTab.logic_operation_finance.encaissementInterne}} USD</td>
																				</tr>
																				<tr v-if="detailTab.is_main==1">
																					<td>Encaissement Externe</td>
																					<td>{{detailTab.logic_operation_finance.encaissementExterne}} USD</td>
																				</tr>
																				<tr v-if="detailTab.is_main==0">
																					<td>Decaissement Interne</td>
																					<td>{{detailTab.logic_operation_finance.decaissementInterne}} USD</td>
																				</tr>
																				<tr v-if="detailTab.is_main==1">
																					<td>Decaissement Externe</td>
																					<td>{{detailTab.logic_operation_finance.decaissementExterne}} USD</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
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
                <h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
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
							<button v-if="!isLoadSaveMainButtonModal" @click="update_article_prix" class="btn btn-primary">Enregistrer</button>
							<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
            </div>

        </div>
    </div>
</div> -->
<?=$this->endSection() ?>
