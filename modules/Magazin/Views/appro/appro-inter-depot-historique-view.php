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
													 <h4>MON HISTORIQUE APPROVISIONNEMENT INTER-DEPOT</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div class="col-md-8 col-lg-8 col-xl-8">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">INFORMATIONS SUR LES APPROVISONNEMENT INTER-DEPOT</h5>

                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Date</th>
																		<th scope="col">Source</th>
																		<th scope="col">Destination</th>
																		<th scope="col">Fait par</th>
																		<th scope="col">Type</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in dataToDisplay">
																		<td>{{dt.date_approvisionnement}}</td>
																		<td>{{dt.depots_id_source[0].nom}}</td>
																		<td>{{dt.depots_id_dest[0].nom}}</td>
																		<td>{{dt.users_id.nom+' '+dt.users_id.prenom}}</td>
																		<td>
																			<span :class="dt.depots_id_source[0].id == dpot_id?'text-success':'text-danger'">
																				<i :class="dt.depots_id_source[0].id == dpot_id?'mdi mdi-arrow-right-thick':'mdi mdi-arrow-left-thick'"></i>
																			</span>
																	</td>
																		<td><button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt)"><i class="mdi mdi-eye-outline" ></i></button></td>
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
                                      <button class="page-link" @click="_u_previous_page(get_historique_approvisionnement_inter_depot_by_depot)">Previous</button>
                                    </li>
                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_historique_approvisionnement_inter_depot_by_depot(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_next_page(get_historique_approvisionnement_inter_depot_by_depot)">Next</button>
                                    </li>
                                  </ul>
                                </nav>
														</div>
                        </div>
												</div>

												<div class="col-md-4 col-lg-4 col-xl-4">
													<div class="card m-b-30 u-animation-FromRight" v-if="isShow">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">DETAIL APPROVISIONNEMENT DU {{detailTab.date_approvisionnement}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>

															<!-- {{checkBoxArticles}} -->
															<div  class="">
																<div class="row">
																	<div class="table-responsive container">
																		<!-- <div class="row">
																			<div class="col-md-6 col-lg-6 col-xl-6">
																				<span>Chauffeur : {{detailTab.nom_chauffeur}}</span><br>
																				<span>Téléphone : {{detailTab.telephone_chauffeur}}</span><br>
																			</div>
																			<div class="col-md-6 col-lg-6 col-xl-6">
																				<span>Plaque : {{detailTab.plaque_vehicule}}</span><br>
																				<span>Num Bordereau : {{detailTab.numero_bordereau}}</span><br>
																			</div>
																		</div> -->
																		<table class="table">
																			<thead>
																				<tr class="bg-secondary">
																					<th scope="col">code</th>
																					<th scope="col">Article</th>
																					<th scope="col">Qte</th>

																				</tr>
																			</thead>
																			<tbody>
																				<tr v-for="(det,i) in detailTab.logic_data_article">
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
<?=$this->endSection() ?>
