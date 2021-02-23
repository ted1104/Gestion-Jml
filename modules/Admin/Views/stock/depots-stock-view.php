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
													 <h4>DEPOTS STOCK</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row ">
												<div :class="isShow ? 'col-md-6 col-lg-6 col-xl-6':'col-md-12 u-transition'">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
															<div class="row">
																<h5 class="card-title text-black col-md-4">STOCK EN DEPOT</h5>
																<div class="col-md-8">
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
																	<tr v-for="(dt, index) in dataToDisplay" :class="currentLineSelectedInList==index?'bg-light':''">
																		<td>{{dt.nom}}</td>
																		<td>{{dt.adresse}}</td>
																		<td>{{dt.responsable_id}}</td>
																		<td><button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button></td>
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
														<div class="card m-b-30 u-transition">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">DETAIL ARTICLES {{detailTab.nom}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>
															<!-- {{checkBoxArticles}} -->
															<div  class="">
																<div class="row">
																	<div class="table-responsive container">
																		<table class="table">
																			<thead>
																				<tr class="bg-secondary">
																					<th scope="col">code</th>
																					<th scope="col">Article</th>
																					<th scope="col">Qte Réelle</th>
																					<th scope="col">Qte Virtuelle</th>
																					<th scope="col">Etat</th>
																					<th scope="col">Edit</th>

																				</tr>
																			</thead>
																			<tbody>
																				<tr v-for="(det,i) in detailTab.logic_article_stock">
																					<td>{{det.articles_id[0].code_article}}</td>
																					<td>{{det.articles_id[0].nom_article}}</td>
																					<td>{{det.qte_stock}}</td>
																					<td>{{det.qte_stock_virtuel}}</td>
																					<td>
																						<span :class="det.logic_etat_critique==1?'badge badge-pill badge-danger':(det.logic_etat_critique==2?'badge badge-pill badge-warning':'badge badge-pill badge-success')">N</span>
																					</td>
																					<td>
																						<span @click="_u_open_mod_popup_edit_qte_stock(detailTab, det)" class="cursor"><i class="mdi mdi-circle-edit-outline"></i></span>
																					</td>

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

		<!-- MODAL -->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
		<div class="modal-dialog" role="document">
				<div class="modal-content">
						<div class="modal-header">
								<h6 class="modal-title text-center">{{modalTitle}}</h6>
								<button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="qte_reelle">Qte Réelle *</label>
								<input type="text" class="form-control" id="qte_reelle" aria-describedby="qte_reelle" v-model="qte_reelle">
							</div>
							<div class="form-group">
								<label for="qte_virtuelle">Qte Virtuelle *</label>
								<input type="text" class="form-control" id="qte_virtuelle" aria-describedby="qte_virtuelle" v-model="qte_virtuelle">
							</div>
							<button @click="add_article_prix" class="btn btn-primary">Ajuster Quantité</button>
						</div>
						<!-- <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary">Ok</button>
						</div> -->
				</div>
		</div>
</div>
<?=$this->endSection() ?>
