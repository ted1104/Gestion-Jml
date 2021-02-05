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
													 <h4>DEPOTS PV</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div :class="isShow ? 'col-md-6 col-lg-6 col-xl-6 u-transition':'col-md-12 u-transition'">
                        <!-- <div class=""> -->
                          <div class="card">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black col-md-6">INFORMATIONS DU STOCK PV</h5>
                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">code</th>
																		<th scope="col">Article</th>
																		<th scope="col" v-if="!isShow">Description</th>
																		<!-- <th scope="col">Qte Réelle</th>
																		<th scope="col">Qte Virtuelle</th> -->
																		<th scope="col">Qte PV</th>
                                    <th scope="col">Restaurer</th>
                                    <th scope="col">Historique</th>

																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(det,i) in dataToDisplay" :class="currentLineSelectedInList==i?'bg-light':''">
																		<td>{{det.code_article}}</td>
																		<td>{{det.nom_article}}</td>
																		<td v-if="!isShow">{{det.description}}</td>
																		<!-- <td>{{det.qte_stock}}</td>
																		<td>{{det.qte_stock_virtuel}}</td> -->
																		<!-- <td>
																			<span :class="det.logic_etat_critique==1?'badge badge-pill badge-danger':(det.logic_etat_critique==2?'badge badge-pill badge-warning':'badge badge-pill badge-success')">N</span>
																		</td> -->
                                    <td>{{det.qte_stock_pv}}</td>
                                    <td>
                                      <button class='btn btn-round btn-success' @click="_u_open_mod_popup_magaz_restaure_pv(det,2)"><i class='mdi mdi-restore'></i> </button>
                                    </td>
                                    <td>
                                      <button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(det,i)"><i class="mdi mdi-eye-outline" ></i></button>
                                    </td>

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

												<div v-if="isShow" :class="isShow ? 'col-md-6 col-lg-6 col-xl-6':''">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container" v-if="!isShowBlocHistoFactureStatus">
															<div class="row">
																<div class="col-md-10">
																	<h5 class="card-title">DETAIL APPROVISIONNEMENT PV RESTAURE </h5>
																	<!-- <div class="text-center">
																		<p>{{detailTab.nom+' '+detailTab.prenom}}</p>
																	</div> -->
																</div>
																<div class="col-md-2">
																	<i class="mdi mdi-close-circle  text-right text-danger cursor" @click="isShow=!isShow"></i>
																</div>
																<div class="table-responsive">
																	<div class="container">
																		<table class="table">
                                      <thead>
      																	<tr class="bg-secondary">
                                          <th scope="col">Date</th>
																					<th scope="col">Qte Restauré</th>
      																		<th scope="col">Qte Perdue</th>
																					<th scope="col">Dépôt</th>
      																		<th scope="col">Par</th>
      																	</tr>
      																</thead>
																				<tbody>
                                          <tr v-for="(dt,i) in detailTab.logic_operation_pv_restaurer">
                                            <td>{{dt.date_restaurer}}</td>
																						<td>{{dt.qte_restaure}}</td>
                                            <td>{{dt.qte_perdue}}</td>
                                            <td>{{dt.depots_id_dest[0].nom}}</td>
																						<td>{{dt.users_id.nom+' '+dt.users_id.prenom}}</td>
                                          </tr>
                                        </tbody>
																		</table>
                                    <div v-if="detailTab.logic_operation_pv_restaurer.length < 1" class="text-center">
                                      <span >Aucune restauration</span><br>
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
    						<h5 class="modal-title text-center" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
    						<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
    								<span aria-hidden="true">&times;</span>
    						</button>
    				</div>
    				<div class="modal-body" v-if="!isWantBeDeleted">
              <div class="form-group">
                <label for="depots_id">Dépôt Destination</label>
                <select class="form-control" v-model="depots_id">
                  <option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
                </select>
              </div>
    					<div class="form-group">
    						<label for="qte_restaurer">Quantité Restaurée *</label>
    						<input type="text" class="form-control" id="qte_restaurer" aria-describedby="qte_restaurer" v-model="qte_restaurer">
								<!-- {{checkBoxAchatSelected}} -->
    					</div>
							<div class="form-group">
								<span>Avez vous terminer la restauration de tous les PVs ?</span><br>
								<div class="custom-control custom-checkbox custom-control-inline">
									<input type="checkbox" name="checkBoxAchatSelected" id="ch" class="custom-control-input" value="1" v-model="checkBoxAchatSelected">
									<label class="custom-control-label" for="ch"></label>
									<label for="ch"> Oui j'ai terminé</label>
								</div>
							</div>
							<div class="form-group" v-if="checkBoxAchatSelected.length > 0">
    						<label for="qte_perdue">Quantité Perdue *</label>
    						<input type="text" class="form-control" id="qte_perdue" aria-describedby="qte_perdue" v-model="qte_perdue">
    					</div>
              <div class="form-group">
                <label for="date_approvisionnement">Date</label>
                <input type="text" class="form-control" id="date_approvisionnement" v-model="date_approvisionnement" disabled>
              </div>
    					<div>
    						<button v-if="!isLoadSaveMainButton" @click="add_approvision_pv_restaure" class="btn btn-primary">Enregistrer</button>
    					</div>
    					<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
    				</div>
    		</div>
    </div>
    </div>
<?=$this->endSection() ?>
