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
													 <h4>LISTE DE TOUS LES UTILISATEURS</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div :class="isShow ? 'col-md-8 col-lg-8 col-xl-8':'col-md-12 u-transition'">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
														<div class="row">
															<h5 class="card-title text-black col-md-9">UTILISATEURS</h5>
															<!-- <h5 class="col-md-3 text-right text-secondary">{{montantTotalAllCommandeParTypeVente}} USD</h5> -->
														</div>

                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
														<!-- {{dataToDisplay}} -->
																<table class="table">
																	<thead>
																		<tr class="bg-secondary">
																			<th scope="col">Nom</th>
																			<th scope="col">Prenom</th>
																			<th scope="col">Tél</th>
																			<th scope="col">Sexe</th>
																			<th scope="col">Role</th>
																			<th scope="col">Affectation</th>
																			<th scope="col">Status</th>
																			<th scope="col">Action</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr v-for="(dt, index) in dataToDisplay" :class="currentLineSelectedInList==index?'bg-light':''">
																			<th>{{dt.nom}}</th>
																			<td>{{dt.prenom}}</td>
																			<td>{{dt.tel}}</td>
																			<td>{{dt.sexe}}</td>
																			<td>{{dt.logic_role_depot.role[0].description}}</td>
																			<td>{{dt.logic_role_depot.depot.nom}}</td>
																			<td>
																				<span :class="dt.logic_auth.status_users_id==1?'badge badge-success':'badge badge-danger'">{{dt.logic_auth.status_users_id==1?'ACTIF':'BLOQUER'}}</span>
																			</td>
																			<td>
																				<button  class="btn btn-round btn-secondary" @click="_u_see_detail_tab(dt,index)"><i class="mdi mdi-eye-outline" ></i></button>
																			</td>
																		</tr>
																	</tbody>
																</table>
																<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="" >
																</div>
																<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
																</div>
																<!-- PAGINATION -->
																<nav aria-label="...">
	                                  <ul class="pagination">
	                                    <li class="page-item">
	                                      <button class="page-link" @click="_u_previous_page(get_users_admin)">Previous</button>
	                                    </li>
	                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_users_admin(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
	                                    <li class="page-item">
	                                      <button class="page-link" @click="_u_next_page(get_users_admin)">Next</button>
	                                    </li>
	                                  </ul>
	                                </nav>
                              </div>
                          </div>
                        </div>
												</div>

												<div v-if="isShow" :class="isShow ? 'col-md-4 col-lg-4 col-xl-4':''">
													<div class="card m-b-30 u-transition">
														<div class="container">
															<div class="row">
																<h5 class="col-md-9 card-title">PROFILE DE {{detailTab.nom}} {{detailTab.prenom}}</h5>
																<i class="mdi mdi-close-circle col-md-3 text-right text-danger cursor" @click="isShow=!isShow"></i>
															</div>
															<div class="container">
																<div class="row">
																	<div class="col-md-4">
																		<label for="input-file">
																			<img :src="'<?=base_url() ?>/public/uploads/profiles/'+detailTab.photo" alt="Logo ByOseMarket" class="rounded-circle" style="width:100px !important; height:100px !important">
																		</label>
																		<input type="file" ref="file" id="input-file" accept="image/*" @change="_u_DisplayImageToUpload">
																	</div>
																	<div class="col-md-8">
																		<span>Nom : {{detailTab.nom}} {{detailTab.prenom}}</span><br>
																		<span>Tél : {{detailTab.tel}}</span><br>
																		<span>Profile : {{detailTab.logic_role_depot.role[0].description}} {{detailTab.is_main==1?'PRINCIPAL':'SECONDAIRE'}}</span><br>

																		<span>Username : {{detailTab.logic_auth.username}}</span><br>
																		<span>Lieu : {{detailTab.logic_role_depot.depot.nom}}</span><br>
																		<span>Naissance : {{detailTab.dob}}</span><br>
																		<span>Debut service : {{detailTab.date_debut_service}}</span><br>
																	</div>
																</div>
																<hr>
																<div class="row text-center">
																	<div class="col-md-6">
																		<p>Status Compte</p>
																		<p :class="detailTab.logic_auth.status_users_id==1?'badge badge-success':'badge badge-danger'">{{detailTab.logic_auth.status_users_id==1?'ACTIF':'BLOQUER'}}</p>
																		<p>
																			<button  :class="detailTab.logic_auth.status_users_id==1?'btn btn-round btn-danger':'btn btn-round btn-info'" class="" @click="update_status_account_users(detailTab.id)"><i :class="detailTab.logic_auth.status_users_id==1?'mdi mdi-lock':'mdi mdi-lock-open'"></i></button>
																		</p>
																	</div>
																	<div class="col-md-6">
																		<p>Mot de passe</p>
																		<p class='badge badge-success'>***********</p><br>
																		<p>
																			<button  class="btn btn-round btn-secondary" @click="reset_password_account_users(detailTab.id)"><i class="mdi mdi-lock-reset"></i></button>
																		</p>
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

		<!-- MODAL -->
	<div class="modal fade show u-animation-FromTop" tabindex="-1" role="dialog" aria-hidden="true" :style="{display: styleModal}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLongTitle-1">{{modalTitle}}</h5>
                <button type="button" class="close" @click="_u_close_mod_form" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
							<div>
								<img :src="avatarMain" alt="Logo ByOseMarket" class="rounded-circle mx-auto d-block" style="width:200px !important; height:200px !important">
							</div>
							<br>
							<div class="text-center">
								<button v-if="!isLoadSaveMainButtonModal" @click="update_image_profile" class="btn btn-secondary">Mettre à jour le profile </button>
								<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>
            </div>

        </div>
    </div>
</div>
<?=$this->endSection() ?>
