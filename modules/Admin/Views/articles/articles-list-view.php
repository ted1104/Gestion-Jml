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
													 <h4>LISTE DE TOUS LES ARTICLE ET PRIX</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row ">
												<div :class="isShow ? 'col-md-8 col-lg-8 col-xl-8':'col-md-12 u-transition'">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
															<div class="row">
																<h5 class="card-title text-black col-md-8 col-lg-8 col-xl-8">TOUS LES ARTICLES ET LEUR PRIX ( {{totalData}} )</h5>
															</div>

                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">#</th>
																		<th scope="col">Code</th>
																		<th scope="col">Nom Article</th>
																		<th scope="col">Pièces</th>
																		<th scope="col">Qte virt</th>
																		<th scope="col">Config Prix</th>
																		<th scope="col">Config Faveur</th>
																		<th scope="col">Config Prix Transp</th>
																		<th scope="col">Rapport</th>
																		<th scope="col">Détail</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay" :class="currentLineSelectedInList==index?'bg-light':''">
																		<td>{{index+1}}</td>
																		<td>{{dt.code_article}}</td>
																		<td>{{dt.nom_article}}</td>
																		<td>{{dt.nombre_piece}}</td>
																		<td>{{dt.logic_qte_virtuel_dispo}}</td>
																		<td>
																			<button :class="dt.logic_detail_data.length > 0?'btn btn-round btn-success':'btn btn-round btn-light'" @click="_u_open_mod_form(dt,1)"><i class='mdi mdi-plus'></i> </button>
																		</td>
																		<td>
																			<button v-if="dt.logic_config_article_faveur.length < 1" class='btn btn-round btn-success' @click="_u_open_mod_form_config_faveur(dt,1)"><i class='mdi mdi-plus'></i> </button>
																			<button class="btn btn-round btn-light" v-if="dt.logic_config_article_faveur.length > 0" @click="_u_open_mod_form_config_faveur(dt,2)">
																				<i class="mdi mdi-circle-edit-outline"></i>
																			</button>
																		</td>
																		<td>
																			<button :class="dt.logic_detail_transport_price_zone.length > 0?'btn btn-round btn-info':'btn btn-round btn-light'" @click="_u_open_mod_form_transport(dt,1)"><i class='mdi mdi-plus'></i> </button>
																		</td>
																		<td>
																			<span :class="dt.is_show_on_rapport==1?'text-success':'text-danger'">{{dt.is_show_on_rapport==1 ? 'Oui':'Non'}}</span>
																		</td>
																		<td>
																			<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button>
																		</td>
																	</tr>
																</tbody>
															</table>
															<!-- LOAD FOR WAITING DATA -->
															<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
															</div>
															<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																<img src="<?=base_url() ?>/public/load/empty.png" >
																<h6 class="text-danger">Données vide!!</h6>
															</div>
															<!-- PAGINATION -->
															<nav aria-label="...">
                                  <ul class="pagination">
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_previous_page(get_article)">Previous</button>
                                    </li>
                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_article(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_next_page(get_article)">Next</button>
                                    </li>
                                  </ul>
                                </nav>
														</div>
                        </div>
												</div>

												<div v-if="isShow" :class="isShow ? 'col-md-4 col-lg-4 col-xl-4':''">
													<div class="card m-b-30 u-transition">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title text-center">DETAIL PRIX ARTICLES {{detailTab.nom_article}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>
															<!-- {{checkBoxArticles}} -->
															<div  class="">
																<div class="row">
																	<div class="table-responsive container">
																		<table class="table">
																			<thead>
																				<tr class="bg-secondary">
																					<th scope="col">Interval</th>
																					<th scope="col">Prix</th>
																					<th scope="col">Action</th>
																					<!-- <th scope="col">Qte Virtuelle</th>
																					<th scope="col">Etat</th> -->
																				</tr>
																			</thead>
																			<tbody>
																				<tr v-for="(det,i) in detailTab.logic_detail_data">
																					<td>{{det.qte_decideur_min+' - '+det.qte_decideur_max}}</td>
																					<td>{{det.prix_unitaire}} USD</td>
																					<td>
																						<span class="btn btn-round btn-light">
																							<i class="mdi mdi-circle-edit-outline" @click="_u_open_mod_form(det,2)"></i>
																						</span>
																						<button v-if = "+i+1 == detailTab.logic_detail_data.length" class="btn btn-round btn-danger" @click="_u_open_mod_form(det,3)"><i class="mdi mdi-delete-sweep" ></i></button>
																					</td>

																				</tr>
																			</tbody>
																		</table>
																		<div v-if="detailTab.logic_detail_data.length < 1" class="text-center">
																			<span >Aucune configuration des prix pour cet article </span><br>
																			<i class="mdi mdi-cancel" style="font-size:40px"></i>
																		</div>
																	</div>
																</div>

																<!-- CONFIGURATION FAVEURS -->
																<div class="row">
																	<h5 class="col-md-12 card-title text-center">DETAIL CONFIGURATION FAVEUR</h5>
																</div>
																<div class="row">
																	<div class="table-responsive container">
																	</div>
																</div>
																<table class="table">
																	<thead>
																		<tr class="bg-secondary">
																			<th scope="col">Qte Faveur</th>
																			<th scope="col">Interval</th>
																			<th scope="col">PU</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr v-for="(det,i) in detailTab.logic_config_article_faveur">
																			<td>{{det.qte_faveur}}</td>
																			<td>{{det.prix_id[0].qte_decideur_min+' - '+det.prix_id[0].qte_decideur_max}}</td>
																			<td>{{det.prix_id[0].prix_unitaire}} USD</td>

																		</tr>
																	</tbody>
																</table>
																<div v-if="detailTab.logic_config_article_faveur.length < 1" class="text-center">
																	<span >Aucune configuration faveur pour cet article </span><br>
																	<i class="mdi mdi-cancel" style="font-size:40px"></i>
																</div>
																<hr>
																<div class="row text-center">
																	<h5 class="col-md-12 card-title">VISIBILITE SUR RAPPORT</h5>
																</div>
																<div class="text-center">
																	<button v-if="!isLoadSaveMainButtonModal" @click="active_article_visibilite_sur_rapport(detailTab.id)" :class="detailTab.is_show_on_rapport==1?'btn btn-danger':'btn btn-success'">{{detailTab.is_show_on_rapport==1?'Désactiver':'Activer'}}</button>
																	<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																</div>

																<!-- CONFIGURATION PRIX PAR ZONE TRANSPORT  -->
																<hr>
																<div class="">
																	<div class="row text-center">
																		<h5 class="col-md-12 card-title">CONFIGURATION PRIX TRANSPORT</h5>
																	</div>
																	<div class="row">
																		<div class="table-responsive container">
																			<table class="table">
																				<thead>
																					<tr class="bg-secondary">
																						<th scope="col">Zone</th>
																						<th scope="col">Prix</th>
																						<th scope="col">Action</th>
																						<!-- <th scope="col">Qte Virtuelle</th>
																						<th scope="col">Etat</th> -->
																					</tr>
																				</thead>
																				<tbody>
																					<tr v-for="(det,i) in detailTab.logic_detail_transport_price_zone">
																						<td>{{det.zone_id[0].nom}}</td>
																						<td>{{det.prix}} USD</td>
																						<td>
																							<span class="btn btn-round btn-light">
																								<i class="mdi mdi-circle-edit-outline" @click="_u_open_mod_form_transport(det,3)"></i>
																							</span>
																							<button class="btn btn-round btn-danger" @click="_u_open_mod_form_transport(det,2)"><i class="mdi mdi-delete-sweep" ></i></button>
																						</td>

																					</tr>
																				</tbody>
																			</table>
																			<div v-if="detailTab.logic_detail_transport_price_zone.length < 1" class="text-center">
																				<span >Aucune configuration des prix de transport pour cet article </span><br>
																				<i class="mdi mdi-cancel" style="font-size:40px"></i>
																			</div>
																		</div>
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


		<!-- MODAL PRICE-->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
								<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body" v-if="!isWantBeDeleted">
							<div class="form-group" v-if="isAction">
								<label for="qte_decideur_min">Quantité Min Inclue*</label>
								<input type="text" class="form-control" id="qte_decideur_min" aria-describedby="qte_decideur_min" v-model="qte_decideur_min" disabled>
							</div>
							<div class="form-group" v-if="isAction">
								<label for="qte_decideur_max">Quantité Max Exclue*</label>
								<input type="text" class="form-control" id="qte_decideur_max" aria-describedby="qte_decideur_max" v-model="qte_decideur_max">
							</div>
							<div class="form-group">

								<label for="prix_unitaire">Prix Unitaire *</label>
								<input type="text" class="form-control" id="prix_unitaire" aria-describedby="prix_unitaire" v-model="prix_unitaire">
							</div>

							<div v-if="!isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="update_article_prix" class="btn btn-primary">Modifier</button>
							</div>
							<div v-if="isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="add_article_prix" class="btn btn-primary">Enregistrer</button>
							</div>
							<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
						</div>

						<div class="modal-body text-center" v-if="isWantBeDeleted">
							<span class=""><i class="mdi mdi-alert icon-size-1x"></i></span><br>
							<span class="text-danger">
								Vous êtes sur le point de supprimer definitivement cette configuration du prix, cette action est irreversible. Si vous l'executer sans connaissance de cause ça peut causer un dysfonctionnement du système surtout coté prix de l'article!
							</span>
							<div class="">
								<button v-if="!isLoadDelete" @click="delete_article_price" class="btn btn-danger">Supprimer</button>
								<img v-if="isLoadDelete" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>
						</div>

				</div>
		</div>
</div>

<!-- MODAL CONFIGURATION FAVEUR A APPLIQUER -->
<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModalFaveur}">
<div class="modal-dialog" role="document">
		<div class="modal-content">
				<div class="modal-header">
						<h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
						<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body" v-if="!isWantBeDeleted">
					<div class="form-group">
						<label for="depots_id">Type Interval prix</label>
						<select class="form-control" v-model="prix_id">
							<option v-for="(dtPrice, i) in ListPricesArticle" :value="dtPrice.id">{{'Interval : '+dtPrice.qte_decideur_min+' - '+dtPrice.qte_decideur_max+' : Montant : '+dtPrice.prix_unitaire+' USD'}}</option>
						</select>
					</div>
					<div class="form-group">
						<label for="prix_unitaire">Quantité conditionnelle *</label>
						<input type="text" class="form-control" id="qte_faveur" aria-describedby="qte_faveur" v-model="qte_faveur">
					</div>

					<div v-if="!isActionFaveur">
						<button v-if="!isLoadSaveMainButtonModal" @click="udpate_article_config_faveur" class="btn btn-primary">Modifier</button>
					</div>
					<div v-if="isActionFaveur">
						<button v-if="!isLoadSaveMainButtonModal" @click="add_article_config_faveur" class="btn btn-primary">Enregistrer</button>
					</div>
					<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
				</div>
		</div>
</div>
</div>



<!-- MODAL CONFIGURATION FAVEUR A APPLIQUER -->
<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModalDetail}">
<div class="modal-dialog" role="document">
		<div class="modal-content">
				<div class="modal-header">
						<h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
						<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
								<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body" v-if="!isWantBeDeleted">
					<!-- <div class="form-group">
						<label for="zone_destination">Zone de destination *</label>
						<select class="form-control" v-model="zone_destination">
							<option v-for="(dtZone, i) in depotList" :value="dtZone.id" :selected="zone_destination==dtZone.id">{{dtZone.nom}}</option>
						</select>
					</div> -->
					<div class="form-group">
						<label for="prix_unitaire">Prix *</label>
						<input type="text" class="form-control" id="prix_transport" aria-describedby="prix_transport" v-model="prix_transport">
					</div>

					<div v-if="isWantBeModified">
						<button v-if="!isLoadSaveMainButtonModal" @click="udpate_article_price_transport" class="btn btn-primary">Modifier</button>
					</div>
					<div v-if="!isWantBeModified">
						<button v-if="!isLoadSaveMainButtonModal" @click="add_price_transport_article_zone" class="btn btn-primary">Enregistrer</button>
					</div>
					<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
				</div>
				<div class="modal-body text-center" v-if="isWantBeDeleted">
					<span class=""><i class="mdi mdi-alert icon-size-1x"></i></span><br>
					<span class="text-danger">
						Vous êtes sur le point de supprimer definitivement cette configuration du prix, cette action est irreversible. Si vous l'executer sans connaissance de cause ça peut causer un dysfonctionnement du système surtout coté prix de l'article!
					</span>
					<div class="">
						<button v-if="!isLoadDelete" @click="delete_article_price_transport" class="btn btn-danger">Supprimer</button>
						<img v-if="isLoadDelete" src="<?=base_url() ?>/public/load/loader.gif" alt="">
					</div>
				</div>
		</div>
</div>
</div>
</div>



<?=$this->endSection() ?>
