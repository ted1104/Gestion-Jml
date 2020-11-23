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
													 <h4>LISTE DES ACHATS</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div class="col-md-9 col-lg-9 col-xl-9">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">INFORMATIONS SUR LES ACHATS {{stateStatus==1?'EN ATTENTE':(stateStatus==2?'PAYE(S)':(stateStatus==3?'LIVRE(S)':'ANNULE(S)'))}} {{dateFilterDisplay}}</h5>
																<div class="">
																	<div @click="get_commande_caissier(1)" class="btn badge-warning padding-4">
                                      En attente <span class="badge badge-pill badge-light">{{ListFiltreData.attente==undefined?'0':ListFiltreData.attente}}</span>
                                  </div>
																	<div @click="get_commande_caissier(2)" class="btn btn-info padding-4">
                                      Payée <span class="badge badge-pill badge-light">{{ListFiltreData.payer==undefined?'0':ListFiltreData.payer}}</span>
                                  </div>
																	<div @click="get_commande_caissier(3)" class="btn btn-success padding-4">
                                      Livrée <span class="badge badge-pill badge-light">{{ListFiltreData.livrer==undefined?'0':ListFiltreData.livrer}}</span>
                                  </div>
																	<div @click="get_commande_caissier(4)" class="btn btn-danger padding-4">
                                      Annulée <span class="badge badge-pill badge-light">{{ListFiltreData.annuler==undefined?'0':ListFiltreData.annuler}}</span>
                                  </div>
																	<div class="pull-right row">
																		<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
																		<button class="btn btn-round btn-info margin-left-4" @click="_u_formatDateFilter(get_commande_caissier)"><i class="mdi mdi-search-web"></i> </button>
																	</div>
																</div>
																<div class="margin-top-4">
																	<span>Rechercher par </span>

																	<div class="custom-control custom-radio custom-control-inline">
	                                  <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" value="1" v-model="RadioCheckedValue"checked>
	                                  <label class="custom-control-label" for="customRadioInline1">Code Facture</label>
	                                </div>
	                                <div class="custom-control custom-radio custom-control-inline">
	                                  <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="2" v-model="RadioCheckedValue">
	                                  <label class="custom-control-label" for="customRadioInline2">Nom client</label>
	                                </div>
																	<div class="">
																		<input type="text" class="form-control input-width" placeholder="Recherche ici...." v-model="dataToSearch" @keyup="_searchDataCaissier">
																	</div>
																</div>
                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr>
																		<th scope="col">Facture</th>
																		<th scope="col">Nom client</th>
																		<th scope="col">Date commande</th>
																		<th scope="col">Depot</th>
																		<th scope="col">Montant</th>
																		<th scope="col">Status</th>
																		<th scope="col">{{stateStatus==3?'Livrer par':'Valider'}}</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay">
																		<th>{{dt.numero_commande}}</th>
																		<td>{{dt.nom_client}}</td>
																		<td>
																			{{dt.date_vente}}
																		</td>
																		<td>{{dt.depots_id[0].nom}}</td>
																		<td>{{dt.logic_somme}} USD</td>
																		<td>
																			<span v-if="dt.status_vente_id.id==1" class="badge badge-warning">{{dt.status_vente_id.description}}</span>
																			<span v-if="dt.status_vente_id.id==2" class="badge badge-info">{{dt.status_vente_id.description}}</span>
																			<span v-if="dt.status_vente_id.id==3" class="badge badge-success">{{dt.status_vente_id.description}}</span>
																			<span v-if="dt.status_vente_id.id==4" class="badge badge-danger">{{dt.status_vente_id.description}}</span>
																		</td>
																		<th scope="col">
																			<button v-if="dt.status_vente_id.id==1" class='btn btn-round btn-success' @click="_u_open_mod_popup_caisse(dt,2)"><i class='mdi mdi-checkbox-marked-circle-outline'></i> </button>
																			<i v-if="dt.status_vente_id.id==2" class='mdi mdi-checkbox-marked-circle-outline'></i>
																			<span>{{dt.logic_status_histo[2].livre_par.user}}</span>
																		</th>
																		<td>
																			<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt)"><i class="mdi mdi-eye-outline" ></i></button>
																		</td>
																	</tr>
																</tbody>
															</table>
															<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																<img src="<?=base_url() ?>/load/load-tab.gif" alt="">
															</div>
															<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																<img src="<?=base_url() ?>/load/empty.png" >
																<h6 class="text-danger">Données vide!!</h6>
															</div>
														</div>
                        </div>
												</div>

												<div class="col-md-3 col-lg-3 col-xl-3">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">DETAIL FACTURE {{detailTab.numero_commande}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>
															<div v-for="(det,i) in detailTab.logic_article" class="">
																<div class="row">
																	<span class="col-md-4">{{det.articles_id[0].code_article}}</span>
																	<span class="col-md-8">{{det.articles_id[0].nom_article}}</span>
																</div>
																<br>
																<div class="row">
																	<span class="col-md-12">Achat Normal</span>
																	<span class="col-md-4">Qte: <br> {{det.qte_vendue}}</span>
																	<span :class="det.is_negotiate==2?'col-md-4 price-bare':'col-md-4'">Prix: <br> {{det.prix_unitaire}} USD</span>
																	<span :class="det.is_negotiate==2?'col-md-4 price-bare':'col-md-4'">Total: <br> {{parseInt(det.qte_vendue)* parseInt(det.prix_unitaire)}} USD</span>
																</div>
																<br>
																<div class="row">
																	<span class="col-md-12">Avec Négociation
																		<span v-if="detailTab.status_vente_id.id==1" :class="det.is_negotiate==0?'badge badge-info':(det.is_negotiate==1?'badge badge-warning':'badge badge-success')">{{det.is_negotiate==0?'Non':(det.is_negotiate==1?'En attente':'Valider')}}</span>
																		<span v-if="detailTab.status_vente_id.id !=1 && det.is_negotiate==2" class="badge badge-success">valider</span>
																	</span>
																	<span class="col-md-4 margin-top-3">Prix: <br> {{det.prix_negociation?det.prix_negociation+' USD':'-'}}</span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3"></span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3">Total: <br> {{parseFloat(det.qte_vendue)* parseFloat(det.prix_negociation)}} USD</span>
																</div>
																<hr>
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


		<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
			<div class="modal-dialog" role="document">
					<div class="modal-content">
							<div class="modal-header">
									<h6 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h6>
									<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
											<span aria-hidden="true">&times;</span>
									</button>
							</div>
							<div class="modal-body">
								<div class="text-center">
									<span>Vous êtes sur le point de faire la validation du payement,</span>
									<span>êtes vous le(la) caissier(e) <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?></span>
									<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
									<div class="form-group col-md-12 text-center">
										<label for="password_op">Mot de passe *</label>
										<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
									</div>
									<button @click="add_validation_payement" class="btn btn-primary">Confirmer</button>
								</div>
							</div>

					</div>
			</div>
	</div>
<?=$this->endSection() ?>
