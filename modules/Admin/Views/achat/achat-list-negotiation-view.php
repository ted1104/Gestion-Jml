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
													 <h4>LISTE DES ACHATS EN NEGOTIATION</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div class="col-md-9 col-lg-9 col-xl-9">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">INFORMATIONS SUR LES ACHATS NEGOCIE(S) {{stateStatus==1?'EN ATTENTE':'VALIDEE(S)'}}</h5>
																<div class="">
																	<div @click="get_commande_attente_negotiation(1)" class="btn badge-warning padding-4">
                                      En attente <span class="badge badge-pill badge-light">{{ListFiltreData.negotiation_attente==undefined?'0':ListFiltreData.negotiation_attente}}</span>
                                  </div>
																	<div @click="get_commande_attente_negotiation(2)" class="btn btn-info padding-4">
                                      Validé(e)s <span class="badge badge-pill badge-light">{{ListFiltreData.negotiation_valide==undefined?'0':ListFiltreData.negotiation_valide}}</span>
                                  </div>
																	

																</div>
                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Facture</th>
																		<th scope="col">Nom client</th>
																		<th scope="col">Date</th>
																		<th scope="col">Depot</th>
																		<th scope="col">Par</th>
																		<th scope="col">Montant</th>
																		<th scope="col">Négotiation</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay">
																		<th>{{dt.numero_commande}}</th>
																		<td>{{dt.nom_client}}</td>
																		<td>{{dt.date_vente}}</td>
																		<td>{{dt.depots_id[0].nom}}</td>
																		<td>
																			{{dt.logic_status_histo[0].attente.user}}
																		</td>

																		<td>{{dt.logic_somme}} USD</td>
																		<td>
																			<span :class="dt.is_negotiate==1?'badge badge-warning':'badge badge-success'">{{dt.is_negotiate==1?'EN ATTENTE':'VALIDEE'}}</span>
																		</td>
																		<td><button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt)"><i class="mdi mdi-eye-outline" ></i></button></td>
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
															<div class="col-md-12 u-animation-FromTop">
																<div class="row">
																	<div class="col-md-6">
																		<button v-if="!isLoadNego" type="button" class="btn btn-rounded btn-success padding-4-l-g font-size-2" @click="add_validate_negotiation(detailTab.id)"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Valider</button>
																		<img v-if="isLoadNego" src="<?=base_url() ?>/load/loader.gif" alt="">
																	</div>
																	<div class="col-md-6 text-right">
																		<button type="button" v-if="!isLoadNegoAnnuler && checkBoxArticles.length < 1" @click="add_annuler_tout_validate_negotiation(detailTab.id)" class="btn btn-rounded btn-danger padding-4-l-g font-size-2"><i class="mdi mdi-delete mr-2"></i>Annuler Tout</button>
																		<button type="button" v-if="!isLoadNegoAnnuler && checkBoxArticles.length > 0" @click="add_annuler_validate_negotiation_selectionneer(detailTab.id)" class="btn btn-rounded btn-danger padding-4-l-g font-size-2"><i class="mdi mdi-delete mr-2"></i>Annuler({{checkBoxArticles.length}})</button>
																		<img v-if="isLoadNegoAnnuler" src="<?=base_url() ?>/load/loader.gif" alt="">
																	</div>
																</div>
																<hr>
															</div>
															<!-- {{checkBoxArticles}} -->
															<div v-for="(det,i) in detailTab.logic_article" class="">
																<div class="row">
																	<span class="col-md-4">{{det.articles_id[0].code_article}}</span>
																	<span :class="detailTab.is_negotiate==2?'col-md-6':'col-md-8'">{{det.articles_id[0].nom_article}}</span>
																	<div class="col-md-2" v-if="detailTab.is_negotiate==2">
																		<div class="custom-control custom-checkbox custom-control-inline">
																			<input type="checkbox" name="checkBoxArticles" :id="det.articles_id[0].id" class="custom-control-input" :value="det.articles_id[0].id" v-model="checkBoxArticles">
		                                  <label class="custom-control-label" :for="det.articles_id[0].id"></label>
																		</div>
	                                </div>

																</div>
																<br>
																<div class="row">
																	<span class="col-md-12">Achat Normal</span>
																	<span class="col-md-4">Qte: <br> {{det.qte_vendue}}</span>
																	<span :class="det.is_negotiate==2?'col-md-4 price-bare':'col-md-4'">Prix: <br> {{det.prix_unitaire}} USD</span>
																	<span :class="det.is_negotiate==2?'col-md-4 price-bare':'col-md-4'">Total: <br> {{parseFloat(det.qte_vendue)* parseFloat(det.prix_unitaire)}} USD</span>
																</div>
																<br>
																<div class="row">
																	<span class="col-md-12">Avec Négociation <span :class="det.is_negotiate==0?'badge badge-info':(det.is_negotiate==1?'badge badge-warning':'badge badge-success')">{{det.is_negotiate==0?'Non':(det.is_negotiate==1?'En attente':'Valider')}}</span></span>
																	<span class="col-md-4 margin-top-3">Prix: <br> {{det.prix_negociation?det.prix_negociation+' USD':'-'}}</span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3"></span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3">Total: <br> {{parseFloat(det.qte_vendue)* parseFloat(det.prix_negociation)}} USD</span>
                                  <input v-if="det.is_negotiate==1" type="text" class="col-md-4 form-control margin-top-3" placeholder="Prix" @change="_u_fx_create_tab_prod_validate_nego(det.articles_id[0].id, $event.target.value)">
                                  <!-- <div v-if="det.is_negotiate==1" class="col-md-4">
                                    <button class='btn btn-round btn-success'><i class='mdi mdi-checkbox-marked-circle-outline'></i> </button>
                                  </div> -->
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
<?=$this->endSection() ?>
