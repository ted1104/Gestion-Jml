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
													 <h4>MON HISTORIQUE TRANSERT STOCK</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div :class="isShow ? 'col-md-8 col-lg-8 col-xl-8':'col-md-12 u-transition'">
													<div class="card m-b-30">
														<div class="card-header bg-white">
															<div class="row">
																<h5 class="card-title text-black col-md-7">HISTORQUE DE TRANSFERT {{dateFilterDisplay}}</h5>
																<div class="col-md-5">
																	<div class="pull-right row">
																		<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
																		<button class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilterWithoutStatus(get_historique_transfert_magaz_by_magaz)"><i class="mdi mdi-search-web"></i> </button>
																	</div>
																</div>
															</div>
														</div>
														<div class="table-responsive card-body">
															<!-- {{checkBoxAchatSelected}} -->
															<div v-if="checkBoxAchatSelected.length > 0" class=" pull-right u-animation-FromTop">
																<button type="button" class="btn btn-rounded btn-danger padding-4-l-g font-size-2" @click="_u_open_mod_popup_transfert()"><i class="mdi mdi-delete"></i>Annuler transfert</button>
															</div>
															<table class="table margin-top-8">
																<thead>
																	<tr class="bg-secondary">
																		<th>#</th>
																		<th scope="col">Date</th>
																		<th scope="col">Magasinier Source</th>
																		<th scope="col">Magasinier Destination</th>
																		<th scope="col">Type</th>
																		<th scope="col">Status</th>
																		<th scope="col">Valider</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>

																	<tr v-for="(dt, index) in dataToDisplay" :class="currentLineSelectedInList==index?'bg-light':''">
																		<td>
																			<div class="custom-control custom-checkbox custom-control-inline">
																				<input type="checkbox" name="checkBoxAchatSelected" :id="dt.id+'ch'" class="custom-control-input" :value="dt.id" v-model="checkBoxAchatSelected" :disabled="dt.status_operation != 0">
																				<label class="custom-control-label" :for="dt.id+'ch'"></label>
																			</div>
																		</td>
																		<td>{{dt.date_transfert}}</td>
																		<td>{{dt.users_id_source[0].nom+' '+dt.users_id_source[0].prenom}}</td>
																		<td>{{dt.users_id_dest[0].nom+' '+dt.users_id_dest[0].prenom}}</td>
																		<!-- <td>{{dt.users_id.nom+' '+dt.users_id.prenom}}</td> -->
																		<td>
																			<span :class="dt.users_id_source[0].id == users_id?'text-success':'text-danger'">
																				<i :class="dt.users_id_source[0].id == users_id?'mdi mdi-arrow-right-thick':'mdi mdi-arrow-left-thick'"></i>
																			</span>
																		</td>
																		<td>
																			<span v-if="dt.status_operation==0" class="badge badge-warning">EN ATTENTE</span>
																			<span v-if="dt.status_operation==1" class="badge badge-info">PARTIEL</span>
																			<span v-if="dt.status_operation==2" class="badge badge-success">VALIDER</span>
																			<span v-if="dt.status_operation==3" class="badge badge-danger">ANNULER</span>
																		</td>
																		<td>
																			<button v-if="dt.users_id_dest[0].id == users_id && (dt.status_operation ==0 || dt.status_operation == 1)" class='btn btn-round btn-success' @click="_u_open_mod_popup_magaz_transfert(dt)"><i class='mdi mdi-checkbox-marked-circle-outline'></i></button>

																			<i v-if="dt.users_id_source[0].id == users_id || (dt.status_operation !=0 && dt.status_operation !=1)" class='mdi mdi-checkbox-marked-circle-outline'></i>
																		</td>
																		<td>
																			<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button>
																		</td>
																	</tr>
																</tbody>
															</table>
															<!-- LOAD FOR WAITING DATA AND SHOW EMPTY ICON IF NO DATA-->
															<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
															</div>
															<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																<img src="<?=base_url() ?>/public/load/empty.png" >
																<h6 class="text-danger">Données vide!!</h6>
															</div>
															<!-- FIN LOAD FOR WAITING DATA AND SHOW EMPTY ICON IF NO DATA-->
															<!-- PAGINATION -->
															<nav aria-label="...">
                                  <ul class="pagination">
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_previous_page(get_historique_transfert_magaz_by_magaz)">Previous</button>
                                    </li>
                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_historique_transfert_magaz_by_magaz(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_next_page(get_historique_transfert_magaz_by_magaz)">Next</button>
                                    </li>
                                  </ul>
                                </nav>
														</div>
                        </div>
												</div>

												<div v-if="isShow" :class="isShow ? 'col-md-4 col-lg-4 col-xl-4 u-transition':''">
												 <div class="card m-b-30">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">DETAIL TRANSFERT DU {{detailTab.date_transfert}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>
															<div v-show="checkBoxArticles.length > 0" class="col-md-12 u-animation-FromTop">
																<div class="row">
																	<div class="col-md-12">
																		<div class="row">
																			<div class="col-md-6 text-left">
																				<div v-if="detailTab.users_id_dest[0].id == users_id">
																					<button v-if="!isLoadNego" type="button" class="btn btn-rounded btn-success padding-4-l-g font-size-2" @click="validate_partiel_article_transfert(detailTab.id)"><i class="mdi mdi-checkbox-marked-circle-outline"></i> Valider</button>
																					<img v-if="isLoadNego" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																				</div>
																			</div>
																			<div class="col-md-6 text-right">
																				<button v-if="!isLoadDelete" type="button" class="btn btn-rounded btn-danger padding-4-l-g font-size-2" @click="delete_article_transfert(detailTab.id)"><i class="mdi mdi-delete mr-2"></i> Supprimer</button>
																				<img v-if="isLoadDelete" src="<?=base_url() ?>/public/load/loader.gif" alt="">
																			</div>
																		</div>
																	</div>
																</div>
															</div>


															<div  class="margin-top-4">
																<div class="row">
																	<div class="table-responsive container">

																		<table class="table">
																			<thead>
																				<tr class="bg-secondary">
																					<th>#</th>
																					<th scope="col">code</th>
																					<th scope="col">Article</th>
																					<th scope="col">Qte</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr v-for="(det,i) in detailTab.logic_data_article">
																					<td>
																							<div class="custom-control custom-checkbox custom-control-inline">
																								<input type="checkbox" name="checkBoxArticles" :id="det.articles_id[0].id" class="custom-control-input" :value="det.articles_id[0].id" v-model="checkBoxArticles" :disabled="(detailTab.status_operation != 0 && detailTab.status_operation != 1) || det.is_validate == 1">
							                                  <label class="custom-control-label" :for="det.articles_id[0].id"></label>
																							</div>
																					</td>
																					<td>{{det.articles_id[0].code_article}}</td>
																					<td>{{det.articles_id[0].nom_article}}</td>
																					<td>{{det.qte}}</td>
																				</tr>
																			</tbody>
																		</table>
																</div>
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
									<span>Vous êtes sur le point d'approuver un transfert,</span>
									<span>êtes vous le(la) magasinier(e) <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?></span>
									<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
									<div class="form-group col-md-12 text-center">
										<label for="password_op">Mot de passe *</label>
										<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
									</div>
									<button v-if="!isLoadSaveMainButtonModal" @click="add_validation_transfert()" class="btn btn-primary">Confirmer</button>
									<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
								</div>
								<!-- <div v-if="isNoQuantity" class="text-center">
									<span class=""><i class="mdi mdi-alert icon-size-1x"></i></span><br>
									<span class="text-danger">
										Impossible de valider cette commande, car il y a un ou plusieurs articles dont leur quantité ne se trouve pas de votre stock! Veuillez svp consulter le détail de la commande pour plus de precision.
									</span>
								</div> -->
							</div>

					</div>
			</div>
	</div>


	<!-- ANNULER APPRO POPUP CONFIRMATOION -->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModalFaveur}">
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
								<span>Attention!! Vous êtes sur le point d'annuler un ou plusieurs transfert(s),</span>
								<span>êtes vous le(la) magasinier(e) <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?></span>
								<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
								<div class="form-group col-md-12 text-center">
									<label for="password_op">Mot de passe *</label>
									<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
								</div>
								<button v-if="!isLoadSaveMainButtonModal" @click="add_annuler_transfert" class="btn btn-primary">Confirmer</button>
								<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>
						</div>

				</div>
		</div>
</div>
<?=$this->endSection() ?>
