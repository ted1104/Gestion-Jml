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
											 <div class="text-center mt-3 mb-2">
													 <h4>CREER UN ACHAT D'UN CLIENT</h4>
													 <!-- {{depot_central_id}} -->
													 <!-- lastFactureEncodede -->

													 <div class="">

														 <button  class="btn btn-round btn-danger pull-right" @click="isStockIndicator=!isStockIndicator"><i class="mdi mdi-shopping"></i></button>
														 <a :href="'<?=base_url()?>/print-code/'+lastFactureEncodede.code+'/code'" target="_blank" class='btn btn-info pull-right'><i class='mdi mdi-printer'></i> Imprimer Facture : {{lastFactureEncodede.numero}} </a>
													 </div>

											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12 margin-top-5">
											<!-- OPERATION ADD COMMANDE -->
											<div class="row" v-show="!isStockIndicator">
												<div class="col-md-5 col-lg-5 col-xl-5 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative à l'achat</h5>
																<!-- {{checkIsFaveur}}
																{{ListIdArticleFaveur}} -->
                            </div>
                            <div class="card-body">
                                  <div class="form-group">
                                    <label for="numero_commande">Numéro Facture</label>
																		<div class="row">
																			<div class="col-md-10 col-lg-10 col-xl-10 ">
																				<input type="text" class="form-control" id="numero_commande" aria-describedby="numero_commande" v-model="numero_commande" disabled>
																			</div>
																			<div class="col-md-2 col-lg-2 col-xl-2">
																				<button class="btn btn-round btn-outline-info" @click="_u_get_code_facture"><i class="mdi mdi-restart"></i> </button>
																			</div>
																		</div>
                                  </div>
																	<div class="form-group">
																		<label for="depots_id">Dépôt Traiteur</label>
																		<select class="form-control" v-model="depots_id">
																			<option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																		</select>
																	</div>
																	<div class="form-group bg-light">
																		<div class="container" style="padding-bottom:-200px!important">
																				<div class="row bg-secondary">
																					<div class="col-md-4 col-lg-4 col-xl-4">
																						<span>Code Art</span>
																					</div>
																					<div class="col-md-4 col-lg-4 col-xl-4">
																						<span>Qte Art</span>
																					</div>
																					<div class="col-md-2 col-lg-2 col-xl-2">
																						<span>Faveur</span>
																					</div>
																					<div class="col-md-2 col-lg-2 col-xl-2">
																						<span>Action</span>
																					</div>
																				</div>
																		</div>
				                            <div class="margin-top-7 container">
				                                <div class="row">
																					<div class="form-group col-md-4 col-lg-4 col-xl-4">
																						<input type="text" class="form-control" v-model="codeArticle">
					                                </div>
					                                <div class="form-group col-md-4 col-lg-4 col-xl-4">
					                                  <input type="text" class="form-control" id="qte" v-model="qte">
					                                </div>
																					<div class="col-md-2 col-lg-2 col-xl-2">
																						<div class="custom-control custom-checkbox custom-control-inline ">
																							<input type="checkbox" name="checkIsFaveur" :id="1" class="custom-control-input" :value="1" v-model="checkIsFaveur">
																							<label class="custom-control-label" :for="1"></label>
																						</div>
																					</div>

																					<div class="form-group col-md-2 col-lg-2 col-xl-2">
					                                   <button class="btn btn-round btn-success" v-if="!isLoadSaveMainButtonModal" @click="_u_create_line_article"><i class="mdi mdi-plus"></i> </button>
																						 <img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
					                                </div>
				                                </div>
				                            </div>
																	</div>

                                  <div class="form-group">
                                    <label for="nom_client">Nom du client</label>
                                    <input type="text" class="form-control" id="nom_client" v-model="nom_client">
                                  </div>
																	<div class="form-group">
                                    <label for="telephone_client">Nom Téléphone client</label>
                                    <input type="text" class="form-control" id="telephone_client" v-model="telephone_client">
                                  </div>

																	<div class="form-group">
                                    <label for="payer_a">Payer à</label>
																		<select class="form-control" v-model="payer_a">
																			<option v-for="(c, i) in caissierList" :value="c.id">{{c.nom+' '+c.prenom}}</option>
																		</select>
                                  </div>
																	<div class="form-group">
                                    <label for="date_vente">Date commande</label>
                                    <input type="text" class="form-control" id="date_vente" v-model="date_vente" disabled>
                                  </div>
																	<div class="row">
																		<div class="col-md-6">
																			<button v-if="!isLoadSaveMainButton" @click="add_commande" class="btn btn-primary">Enregistrer</button>
																			<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																		</div>
																		<div class="col-md-6">
																			<a :href="'<?=base_url()?>/print-code/'+lastFactureEncodede.code+'/code'" target="_blank" class='btn btn-info pull-right'><i class='mdi mdi-printer'></i> Imprimer : {{lastFactureEncodede.numero}} </a>
																		</div>
																	</div>

                            </div>
                        </div>
												</div>
												<div class="col-md-7 col-lg-7 col-xl-7">
													<div class="card m-b-30">
														<div class="container">
															<div class="row margin-top-8">
																<h5 class="card-title text-black col-md-9">PANNIER DES ARTICLES</h5>
																<h5 class="col-md-3 text-right text-secondary">{{montantTotalAchat}} USD</h5>
															</div>
														</div>

														<div class="table-responsive">
															<div class="container">
																<table class="table">
																	<thead>
																		<tr class="bg-secondary">
																			<th scope="col">Code</th>
																			<th scope="col">Nom</th>
																			<th scope="col">Qte</th>
																			<th scope="col">PU</th>
																			<th scope="col">PT</th>
																			<th scope="col">Faveur</th>
																			<th scope="col">Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr v-for="(dt, index) in tabListData">
																			<th>{{dt.code}}</th>
																			<td>{{dt.nom_article}}</td>
																			<td>{{dt.qte}}</td>
																			<td>{{dt.prix_unit}}</td>
																			<!-- <td>{{dt.interval}}</td> -->
																			<td>{{parseFloat(dt.prix_unit) * dt.qte}}</td>
																			<td><span :class="dt.isfaveur == 1?'text-success':'text-danger'">{{dt.isfaveur == 1?'Oui':'Non'}}</span></td>
																			<td><button  class="btn btn-round btn-danger" @click="_u_remove_line_list_art(index)"><i class="mdi mdi-delete-sweep" ></i></button></td>
																		</tr>
																	</tbody>
																</table>
																<div v-if="tabListData.length < 1" class="text-center">
																	<span >Aucun article dans le pannier</span><br>
																	<i class="mdi mdi-cancel" style="font-size:40px"></i>
																</div>
															</div>
														</div>
                        </div>
												</div>
											</div>
											<div class="row" v-show="isStockIndicator">

												<div class="col-md-8 col-lg-8 col-xl-8">
													<div class="card m-b-30">
                            <div class="card-header row bg-white">
                                <h5 class="card-title text-black col-md-6">INFORMATIONS LE STOCK DANS LE DEPOT</h5>
																<div class="col-md-6">
																	<div class="row text-center" v-if="CritiqueDataTab.length >0">
																		<div class="col-md-4" >
																			<span class="badge badge-pill badge-danger">N</span><br> Qte <= {{CritiqueDataTab[0].montant_min}}
																		</div>
																		<div class="col-md-4">
																			<span class="badge badge-pill badge-warning">N</span><br> {{CritiqueDataTab[0].montant_min}} < Qte < {{CritiqueDataTab[0].montant_max}}
																		</div>
																		<div class="col-md-4">
																			<span class="badge badge-pill badge-success">N</span><br> {{CritiqueDataTab[0].montant_max}} <= Qte
																		</div>
																	</div>
																</div>
                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Dépôt</th>
																		<th scope="col">Adresse</th>
																		<th scope="col">Responsable</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay">
																		<td>{{dt.nom}}</td>
																		<td>{{dt.adresse}}</td>
																		<td>{{dt.responsable_id}}</td>
																		<td><button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt)"><i class="mdi mdi-eye-outline" ></i></button></td>
																	</tr>
																</tbody>
															</table>
															<!-- LOAD FOR WAITING DATA -->
															<div class="text-center" v-if="dataToDisplay.length < 1">
																<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
															</div>
															<!-- PAGINATION -->
															<!-- <nav aria-label="...">
                                  <ul class="pagination">
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_previous_page(get_historique_approvisionnement)">Previous</button>
                                    </li>
                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_historique_approvisionnement(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_next_page(get_historique_approvisionnement)">Next</button>
                                    </li>
                                  </ul>
                                </nav> -->
														</div>
                        </div>
												</div>

												<div class="col-md-4 col-lg-4 col-xl-4">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">DETAIL ARTICLES {{detailTab.nom}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>

															<!-- {{checkBoxArticles}} -->
															<div  class="">
																<div class="row">
																	<table class="table">
																		<thead>
																			<tr>
																				<th scope="col">code</th>
																				<th scope="col">Article</th>
																				<!-- <th scope="col">Qte</th> -->
																				<th scope="col">Etat</th>

																			</tr>
																		</thead>
																		<tbody>
																			<tr v-for="(det,i) in detailTab.logic_article_stock">
																				<td>{{det.articles_id[0].code_article}}</td>
																				<td>{{det.articles_id[0].nom_article}}</td>
																				<!-- <td>{{det.qte_stock}}</td> -->
																				<td>
																					<span :class="det.logic_etat_critique==1?'badge badge-pill badge-danger':(det.logic_etat_critique==2?'badge badge-pill badge-warning':'badge badge-pill badge-success')">N</span>
																				</td>

																			</tr>
																		</tbody>
																	</table>


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
