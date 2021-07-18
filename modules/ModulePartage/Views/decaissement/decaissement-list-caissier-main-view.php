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
													 <h4>LISTE DEMANDE DE DECAISSEMENT CAISSIER ET DECAISSEMENT EXTERNE</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Informations relatives au decaissement Externe</h5>
                            </div>
                            <div class="card-body">
																	<div class="form-group">
																		<label for="destination">Destination</label>
																		<select class="form-control" v-model="destination">
																			<option value="" disabled>--Choisir Destination--</option>
																			<option v-for="(det, i) in ListMotifDecaissement" :value="det.id" v-if="det.is_active==1">{{det.description}}</option>
																			<!-- <option value="1">BANQUE</option>
																			<option value="2">ACHAT PRODUITS</option>
																			<option value="3">AUTRES</option> -->
																		</select>
																	</div>
                                  <div class="form-group">
                                    <label for="nom_article">Montant *</label>
                                    <input type="text" class="form-control" v-model="montant">
                                  </div>

																	<div class="form-group">
                                    <label for="description">Note *</label>
                                    <textarea class="form-control" name="inputTextarea" id="description" rows="3" v-model="note"></textarea>
                                  </div>
                              		<button v-if="!isLoadSaveMainButton" @click="add_decaissement_externe" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-8 col-lg-8 col-xl-8">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <!-- <h5 class="card-title text-black"></h5>
															DECAISSEMENT EXTERNE {{dateFilterDisplay}} {{checkBoxArticles.length > 0 ? 'AU '+dateFilterEnd : ''}} -->

															<div class="row">
																<h5 class="card-title text-black col-md-9">
																	{{isDecaissementExterne?'DECAISSEMENT EXTERNE '+dateFilterDisplay:'DECAISSEMENT INTERNE'}}
																</h5>
																<h5 class="col-md-3 text-right text-secondary">{{montantTotatAllDecaissement}} USD</h5>
															</div>
															<div class="">
																<?php if(session('users')['info'][0]->roles_id == 3): ?>
																<div @click="get_decaisssement_caissier_principale(2)" class="btn badge-warning padding-4" :id="!isDecaissementExterne?'border-menu':''">
																		Decaissement Interne
																</div>
																<?php endif; ?>
																<div @click="get_decaisssement_externe" class="btn btn-info padding-4" :id="isDecaissementExterne?'border-menu':''">
																		Decaissement Externe
																</div>
																<div class="pull-right row">
																	<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
																	<!-- BOUTTON DECAISSEMENT INTERNTE -->
																	<button v-if="!isDecaissementExterne" class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilter(get_decaisssement_caissier_principale)"><i class="mdi mdi-search-web"></i></button>

																	<!-- BOUTTON DECAISSEMENT EXTERNE -->
																	<button v-if="isDecaissementExterne" class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilter(get_decaisssement_externe)"><i class="mdi mdi-search-web"></i> </button>
																</div>
															</div>
                          </div>

                          <div class="card-body">
                              <div class="table-responsive" v-if="!isDecaissementExterne">
                                <table class="table" >
                                  <thead>
                                    <tr class="bg-secondary">
                                      <th scope="col">Date</th>
                                      <th scope="col">Caissier</th>
																			<th scope="col">Caissier Principal</th>
                                      <th scope="col">Montant</th>
                                      <th scope="col">Status</th>
																			<th scope="col">Valider</th>
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
																			<td>
																				<button v-if="dt.status_operation==0" class='btn btn-round btn-success' @click="_u_open_mod_popup_caissier_principal_validation_decaissement(dt)"><i class='mdi mdi-checkbox-marked-circle-outline'></i> </button>
																				<i v-if="dt.status_operation==1" class='mdi mdi-checkbox-marked-circle-outline'>
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
															<div class="table-responsive" v-if="isDecaissementExterne">
																<!-- DECAISSEMENT EXTERNE TABLE -->

																<table class="table" >
                                  <thead>
                                    <tr class="bg-secondary">
                                      <th scope="col">Date</th>
                                      <th scope="col">Caissier Principal</th>
																			<th scope="col">Destination</th>
                                      <th scope="col">Montant</th>
                                      <th scope="col">Note</th>
																			<th scope="col">Valider</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in tabListData">
                                      <td>{{dt.date_decaissement}}</td>
																			<td>{{dt.users_id_from.nom+' '+dt.users_id_from.prenom}}</td>
																			<td>{{dt.destination}}</td>
																			<td>{{dt.montant}} USD</td>
																			<td>{{dt.note}}</td>
																			<td><i class='mdi mdi-checkbox-marked-circle-outline'></td>
																		</tr>
																	</tbody>
																</table>
																<div class="text-center" v-if="tabListData.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
																</div>
																<div class="text-center" alt="" v-if="tabListData.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
																</div>
																<!-- PAGINATION -->
																<nav aria-label="...">
																	<ul class="pagination">
																		<li class="page-item">
																			<button class="page-link" @click="_u_previous_page_decaissement_externe(get_decaisssement_externe)">Previous</button>
																		</li>
																		<li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_decaisssement_externe(null,pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
																		<li class="page-item">
																			<button class="page-link" @click="_u_next_page_decaissement_externe(get_decaisssement_externe)">Next</button>
																		</li>
																	</ul>
																	</nav>
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
                <h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
                <button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
							<div class="text-center">
								<span>Vous êtes sur le point de valider la récéption du decaissement,</span>
								<span>êtes vous le(la) caissier(e) principal(e) <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?> ?</span>
								<span>Acceptez vous avoir reçu physiquement cette somme d'argent ?</span>
								<span> Si Oui, renseigner votre mot de passe de validation des opérations</span><br>
								<div class="form-group col-md-12 text-center">
									<label for="password_op">Mot de passe *</label>
									<input type="password" class="form-control" id="password_op" aria-describedby="password_op" v-model="password_op">
								</div>
								<button v-if="!isLoadSaveMainButtonModal" @click="add_validation_decaissement" class="btn btn-primary">Confirmer</button>
								<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>
            </div>
        </div>
    </div>
</div>
<?=$this->endSection() ?>
