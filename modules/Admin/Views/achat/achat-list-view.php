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

												<div :class="isShow ? 'col-md-9 col-lg-9 col-xl-9':'col-md-12 u-transition'">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
															<div class="row">
																<h5 class="card-title text-black col-md-9">INFORMATIONS SUR LES ACHATS {{stateStatus==1?'EN ATTENTE':(stateStatus==2?'PAYER':(stateStatus==3?'LIVREE':'ANNULEE'))}} {{dateFilterDisplay}}</h5>
																<h5 class="col-md-3 text-right text-secondary">{{montantTotalAllCommandeParTypeVente}} USD</h5>
															</div>
																<div class="">
																	<div @click="get_commande_admin(1)" class="btn badge-warning padding-4" :id="stateStatus==1?'border-menu':''">
                                      En attente <span class="badge badge-pill badge-light">{{ListFiltreData.attente==undefined?'0':ListFiltreData.attente}}</span>
                                  </div>
																	<div @click="get_commande_admin(2)" class="btn btn-info padding-4" :id="stateStatus==2?'border-menu':''">
                                      Payée <span class="badge badge-pill badge-light">{{ListFiltreData.payer==undefined?'0':ListFiltreData.payer}}</span>
                                  </div>
																	<div @click="get_commande_admin(3)" class="btn btn-success padding-4" :id="stateStatus==3?'border-menu':''">
                                      Livrée <span class="badge badge-pill badge-light">{{ListFiltreData.livrer==undefined?'0':ListFiltreData.livrer}}</span>
                                  </div>
																	<div @click="get_commande_admin(4)" class="btn btn-danger padding-4" :id="stateStatus==4?'border-menu':''">
                                      Annulée <span class="badge badge-pill badge-light">{{ListFiltreData.annuler==undefined?'0':ListFiltreData.annuler}}</span>
                                  </div>
																	<div @click="get_commande_admin(6)" class="btn btn-secondary padding-4" :id="stateStatus==6?'border-menu':''">
                                      Tout <span class="badge badge-pill badge-light">{{parseInt(ListFiltreData.attente)+parseInt(ListFiltreData.payer)+parseInt(ListFiltreData.livrer)+parseInt(ListFiltreData.annuler)}}</span>
                                  </div>
																	<div @click="get_commande_admin(5)" class="btn btn-danger padding-4" :id="stateStatus==5?'border-menu':''">
                                      Supprimée <span class="badge badge-pill badge-light">{{ListFiltreData.delete==undefined?'0':ListFiltreData.delete}}</span>
                                  </div>
																	<div class="padding-4 btn">
																			<button class="btn btn-round btn-outline-secondary margin-left-4" @click="showAdvancedSearch=!showAdvancedSearch"><i class="mdi mdi-search-web"></i> </button>

																			<button class="btn btn-round btn-outline-danger margin-left-4" @click="_refrechData(get_commande_admin)"><i class="mdi mdi-restore"></i> </button>
																	</div>
																	<div class="pull-right row">
																		<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
																		<button class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilter(get_commande_admin)"><i class="mdi mdi-search-web"></i> </button>
																	</div>

																</div>
																<div v-if="showAdvancedSearch" class="margin-top-4 u-animation-FromTop">
																	<span>Les Options de recherche </span><br>
																	<!-- {{checkBoxArticles}} -->
																	<div class="margin-top-7">
																		<div class="custom-control custom-radio custom-control-inline">
																			<input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" value="1" v-model="RadioCheckedValue"checked>
																			<label class="custom-control-label" for="customRadioInline1">Code Facture</label>
																		</div>
																		<div class="custom-control custom-radio custom-control-inline">
																			<input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="2" v-model="RadioCheckedValue">
																			<label class="custom-control-label" for="customRadioInline2">Nom client</label>
																		</div>
																		<div class="custom-control custom-checkbox custom-control-inline">
																			<input type="checkbox" name="checkBoxArticles" id="1" class="custom-control-input" value="1" v-model="checkBoxArticles">
																			<label class="custom-control-label" for="1">Date</label>
																		</div>
																		<div class="custom-control custom-checkbox custom-control-inline">
																			<input type="checkbox" name="checkBoxArticles" id="2" class="custom-control-input" value="2" v-model="checkBoxArticles">
																			<label class="custom-control-label" for="2">Status</label>
																		</div>
																	</div>

																	<div class="margin-top-7">
																		<input type="text" class="form-control input-width" placeholder="Recherche ici...." v-model="dataToSearch" @keyup="_searchDataAdmin">
																	</div>
																</div>
                            </div>
														<div class="table-responsive card-body">
															<!-- {{stateStatus}} -->
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Facture</th>
																		<th scope="col">Nom client</th>
																		<th scope="col">Date commande</th>
																		<th scope="col">{{stateStatus==1?'Commander par':(stateStatus==2?'Payer à':(stateStatus==3?'Livrer par':(stateStatus==4?'Annuler par':'Utilisateur')))}}</th>
																		<th scope="col">Montant</th>
																		<th scope="col">Status</th>
																		<th scope="col">{{stateStatus !=3?'Valider':'Print'}}</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay" :class="currentLineSelectedInList==index?'bg-light':''">
																		<th>
																			<span :class="dt.container_faveur==1?'text-danger font-bold':''" title="Cette facture passsed">{{dt.numero_commande}} <br> <i v-if="dt.is_transported ==1" class="text-success mdi mdi-car-side"></i></span>
																		</th>
																		<td>{{dt.nom_client}} <br><span class="font-size-3">{{dt.telephone_client}}</span></td>
																		<td>{{dt.date_vente}}</td>
																		<!-- LOGIQUE HISTORIQUE  -->
																		<td v-if="stateStatus==1">{{dt.logic_status_histo.tab[0].attente.user}}</td>
																		<td v-if="stateStatus==2">{{dt.payer_a[0].nom+' '+dt.payer_a[0].prenom}}</td>
																		<td v-if="stateStatus==3">{{dt.logic_status_histo.tab[2].livre_par.user}}</td>
																		<td v-if="stateStatus==4">{{dt.logic_status_histo.tab[3].annuler_par.user}}</td>
																		<td v-if="stateStatus==5">{{dt.status_vente_id.id==1?dt.logic_status_histo.tab[0].attente.user:(dt.status_vente_id.id==2?dt.payer_a[0].nom+' '+dt.payer_a[0].prenom:(dt.status_vente_id.id==3?dt.logic_status_histo.tab[2].livre_par.user:dt.logic_status_histo.tab[3].annuler_par.user))}}</td>
																		<!--  -->
																		<td>{{dt.logic_somme}} USD</td>
																		<td>
																			<div class="">
																				<span v-if="dt.status_vente_id.id==1" class="badge badge-warning">{{dt.status_vente_id.description}}</span>
																				<span v-if="dt.status_vente_id.id==2" class="badge badge-info">{{dt.status_vente_id.description}}</span>
																				<span v-if="dt.status_vente_id.id==3" class="badge badge-success">{{dt.status_vente_id.description}}</span>
																				<span v-if="dt.status_vente_id.id==4" class="badge badge-danger">{{dt.status_vente_id.description}}</span>
																				<span v-if="dt.status_vente_id.id==5" class="badge badge-danger">{{dt.status_vente_id.description}}</span>
																			</div>
																			<span v-if="dt.status_vente_id.id==3 && dt.is_livrer_all ==1" class="badge badge-warning">PARTIEL</span>
																			<span v-if="dt.logic_have_oper_a_retirer" class="badge badge-info">A RETIRER</span>
																		</td>
																		<th scope="col">
																			<button v-if="dt.status_vente_id.id==2" class='btn btn-round btn-success' @click="_u_open_mod_popup_magaz(dt,2)"><i class='mdi mdi-checkbox-marked-circle-outline'></i> </button>
																			<i v-if="dt.status_vente_id.id==1" class='mdi mdi-checkbox-marked-circle-outline'></i>
																			<!-- <button v-if="dt.status_vente_id.id==3" class='btn btn-round btn-info'><i class='mdi mdi-printer'></i> </button> -->

																			<a :href="'<?=base_url()?>/print-facture/'+dt.id+'/code'" target="_blank" v-if="dt.status_vente_id.id==3" class='btn btn-round btn-info'><i class='mdi mdi-printer text-white'></i> </a>

																		</th>
																		<td>
																			<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button>
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
															<!-- PAGINATION LISTE NORMALE -->
															<!-- PAGINATION -->
															<nav aria-label="..." v-if="!isResearchPagination">
																	<ul class="pagination">
																		<li class="page-item">
																			<button class="page-link" @click="_u_previous_page_for_list_achat(get_commande_admin)">Previous</button>
																		</li>
																		<li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_commande_admin(stateStatus,pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
																		<li class="page-item">
																			<button class="page-link" @click="_u_next_page_for_list_achat(get_commande_admin)">Next</button>
																		</li>
																	</ul>
																</nav>
																<!-- FIN PAGINATION LISTE NORMALE -->


															<!-- PAGINATION LORS DE LA RECHERRCHE -->
															<nav aria-label="..." v-if="isResearchPagination">
																	<ul class="pagination">
																		<li class="page-item">
																			<button class="page-link" @click="_u_previous_page(_searchDataAdmin)">Previous</button>
																		</li>
																		<li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="_searchDataAdmin(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
																		<li class="page-item">
																			<button class="page-link" @click="_u_next_page(_searchDataAdmin)">Next</button>
																		</li>
																	</ul>
																</nav>
																<!-- FIN PAGINATION LORS DE LA RECHERRCHE -->
														</div>
                        </div>
												</div>

												<div v-if="isShow" :class="isShow ? 'col-md-3 col-lg-3 col-xl-3':''">
													<div class="card m-b-30 u-transition">
														<div class="container" v-if="!isShowBlocHistoFactureStatus">
															<div class="row">
																<div class="col-md-1">
																	<i class="mdi mdi-eye  text-right text-success cursor" @click="isShowBlocHistoFactureStatus=!isShowBlocHistoFactureStatus"></i>
																</div>
																<div class="col-md-9">
																	<h5 class="card-title">DETAIL FACTURE {{detailTab.numero_commande}}</h5>
																</div>
																<div class="col-md-1">
																	<i class="mdi mdi-close-circle  text-right text-danger cursor" @click="isShow=!isShow"></i>
																</div>
															</div>
															<div v-for="(det,i) in detailTab.logic_article" class="">
																<div class="row">
																	<div class="col-md-4">
																		<!-- <span :class="det.is_faveur==1?'text-danger font-bold':''">{{det.articles_id[0].code_article}}</span> -->
																		<span>Qte: </span><br>
																		<span v-if="det.qte_vendue >1 || det.qte_vendue ==1">{{det.qte_vendue}}</span>
																		<span v-if="det.qte_vendue <1" class="text-danger">

																			{{(det.articles_id[0].nombre_piece * det.qte_vendue)+'/'+det.articles_id[0].nombre_piece}}
																		</span>
																	</div>
																	<div class="col-md-8">
																		<span>Produit</span><br>
																		<span :class="det.is_faveur==1?'text-danger font-bold':''">{{det.articles_id[0].nom_article}}</span>
																	</div>
																</div>
																<br>
																<div class="row">
																	<span class="col-md-12">Achat Normal <span v-if="det.is_faveur==1" class="text-success">avec faveur</span></span>

																	<span :class="det.is_negotiate==2?'col-md-6 price-bare':'col-md-6'">Prix: <br> {{det.prix_unitaire}} USD</span>
																	<span :class="det.is_negotiate==2?'col-md-6 price-bare':'col-md-6'">Total: <br> {{parseFloat(det.qte_vendue)* parseFloat(det.prix_unitaire)}} USD</span>
																</div>
																<br>
																<div class="row" v-if="detailTab.status_vente_id.id==3">
																	<div class="col-md-12">
																		<label for="" class="margin-top-3">Qte rétiréé</label>
																	</div>
																	<div class="col-md-6">
																		<button  class="btn btn-round btn-info" @click="_u_open_mod_popup_detail(det,detailTab.numero_commande,det.qte_vendue)"><i class="mdi mdi-eye-outline" ></i></button>
																	</div>
																</div>
																<!-- <div class="row">
																	<span class="col-md-12">Avec Négociation
																		<span v-if="detailTab.status_vente_id.id==1" :class="det.is_negotiate==0?'badge badge-info':(det.is_negotiate==1?'badge badge-warning':'badge badge-success')">{{det.is_negotiate==0?'Non':(det.is_negotiate==1?'En attente':'Valider')}}</span>
																		<span v-if="detailTab.status_vente_id.id !=1 && det.is_negotiate==2" class="badge badge-success">valider</span>
																	</span>
																	<span class="col-md-4 margin-top-3">Prix: <br> {{det.prix_negociation?det.prix_negociation+' USD':'-'}}</span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3"></span>
																	<span v-if="det.is_negotiate==2" class="col-md-4 margin-top-3">Total: <br> {{parseFloat(det.qte_vendue)* parseFloat(det.prix_negociation)}} USD</span>
																</div> -->
																<hr>
															</div>
															<!-- OPERATION AVANCEE SUR FACTURE -->
															<div class="" v-if="detailTab.status_vente_id.id ==3 || detailTab.status_vente_id.id ==2">
																<div class="row" >
																	<h5 class="col-md-12 card-title">OPERATION AVANCEE FACTURE</h5>
																</div>
																<div class="col-md-12">
																	<div class="text-center">
																		<button v-if="!isLoadSaveMainButtonModal" @click="_u_open_mod_popup_supprimer(detailTab)" class="btn btn-danger">SUPPRIMER</button>
																		<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																	</div>
																</div>
															</div>
														</div>
														<div class="container" v-if="isShowBlocHistoFactureStatus">
															<div class="row">
																<div class="col-md-1">
																	<i class="mdi mdi-eye  text-right text-success cursor" @click="isShowBlocHistoFactureStatus=!isShowBlocHistoFactureStatus"></i>
																</div>
																<div class="col-md-9">
																	<h5 class="card-title">HISTORIQUE STATUS FACTURE {{detailTab.numero_commande}}</h5>
																</div>
																<div class="col-md-1">
																	<i class="mdi mdi-close-circle  text-right text-danger cursor" @click="isShow=!isShow"></i>
																</div>
															</div>
															<div class="row">
																<div class="container" v-for="(ds,i) in detailTab.logic_status_histo.status">
																	<!-- {{ds}} -->
																	<span>Status : <span :class="ds[Object.keys(ds)[0]].class">{{ds[Object.keys(ds)[0]].name}}</span></span><br>

																	<span>Fait par : {{ds[Object.keys(ds)[0]].user}}</span><br>
																	<span>Date : {{ds[Object.keys(ds)[0]].date}}</span><br>
																	<hr>
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
									<span>Vous êtes sur le point d'approuver la livraison de la commande,</span>
									<span>êtes vous le(la) magasinier(e) <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?></span>
									<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
									<div class="form-group col-md-12 text-center">
										<label for="password_op">Mot de passe *</label>
										<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
									</div>
									<button @click="add_validation_livraison" class="btn btn-primary">Confirmer</button>
								</div>
							</div>

					</div>
			</div>
	</div>


	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModalDetail}">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h6 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h6>
								<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<span>Quantités Rétirées : {{QteTotalOperationDejaRetirer}}</span><br>
								</div>
								<div class="col-md-6">
									<span>Quantités Non Rétirées : {{QteTotalOperationNonRetirer}}</span><br>
								</div>
							</div>
							<table class="table">
								<thead>
									<tr class="bg-secondary">
										<th scope="col">Date</th>
										<th scope="col">Quantité</th>
										<th scope="col">Livré par</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(deet, index) in detailOperationAretirer">
										<td>{{deet.created_at.date.split('.')[0]}}</td>
										<td>{{deet.qte_retirer}}</td>
										<td>{{deet.users_id[0].nom+' '+deet.users_id[0].prenom}}</td>
									</tr>
									<!-- {{detailOperationAretirer}} -->
								</tbody>

							</table>
						</div>

				</div>
		</div>
	</div>


	<!-- SUPRESSION FACTURE -->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModalShow}">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h6 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h6>
								<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
							<div v-if="!isNoQuantity" class="text-center">
								<span>Vous êtes sur le point de supprimer definitivement une facture,</span>
								<span>saches bien que cette opération est irreversible,</span>
								<span>êtes vous l'administrateur <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?> ? </span>
								<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
								<div class="form-group col-md-12 text-center">
									<label for="password_op">Mot de passe *</label>
									<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
								</div>
								<button v-if="!isLoadSaveMainButtonModal" @click="supprimer_facture()" class="btn btn-primary">Confirmer</button>
								<!-- <button v-if="!isLoadSaveMainButtonModal && isPartielle" @click="add_validation_livraison_partielle()" class="btn btn-primary">Confirmer</button> -->
								<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>

						</div>
						<!-- <div class="modal-body text-center" v-if="Object.keys(ArticleValidateNego).length < 1">
							<span class="text-danger">
							Impossibile de valider cette opération car aucun article n'a été renseigner à rétirer après!!
							</span>
						</div> -->
				</div>
		</div>
	</div>
<?=$this->endSection() ?>
