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
													 <h4>AJOUT D'UN CLIENT</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative aux clients</h5>
                            </div>
                            <div class="card-body">
                                  <div class="form-group" v-if="!this.wantToUpdate">
                                    <label for="nom_client_ab">Nom du client *</label>
                                    <input type="text" class="form-control" id="nom_client_ab" aria-describedby="nom_client_ab" v-model="nom_client_ab">
                                  </div>
                                  <div class="form-group">
                                    <label for="prenom_client_ab">Prénom du client *</label>
                                    <input type="text" class="form-control" id="prenom_client_ab" v-model="prenom_client_ab">
                                  </div>
																	<div class="form-group">
                                    <label for="tel_client_ab">Téléphone du client *</label>
                                    <input type="text" class="form-control" id="tel_client_ab" v-model="tel_client_ab">
                                  </div>
																	<div class="form-group">
                                    <label for="adresse_client_ab">adresse</label>
                                    <input type="text" class="form-control" id="adresse_client_ab" v-model="adresse_client_ab">
                                  </div>
                              		<button v-if="!isLoadSaveMainButton && !this.wantToUpdate" @click="add_client_abonne" class="btn btn-primary">Enregistrer</button>
																	<button v-if="!isLoadSaveMainButton && this.wantToUpdate" @click="update_article_data" class="btn btn-primary">Modifier</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-8 col-lg-8 col-xl-8">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <h5 class="card-title text-black">Listes de clients Recemment ajoutés</h5>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-secondary">
																			<th>#</th>
                                      <th>Nom & Prénom</th>
																			<th>Téléphone</th>
                                      <th>Adresse</th>
																			<th>Montant</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in dataToDisplay">
																			<th>{{+index+1}}</th>
                                      <th>{{dt.nom_client+' '+dt.prenom_client}}</th>
																			<td>{{dt.telephone_client}}</td>
																			<td>{{dt.addresse}}</td>
                                      <td>{{dt.montant}}</td>
																			<td>
																				<!-- <button class='btn btn-round btn-success' @click="_u_open_mod_form(dt,1)"><i class='mdi mdi-plus'></i> </button> -->
																				<div v-if="indexTopUpdate!=index">
																					<button type="button" class='btn btn-round btn-secondary' name="button" @click="_u_update_article(dt,index)" :disabled="indexTopUpdate"><i class='mdi mdi-circle-edit-outline text-white'></i></button>

																				</div>
																				<div v-if="indexTopUpdate==index">
																					<button type="button" class='btn btn-round btn-info' name="button" @click="_u_update_article(dt,index)"><i class='mdi mdi-close'></i></button>
																				</div>
																			</td>
																			</td>

                                    </tr>
                                  </tbody>
                                </table>

																<!-- PAGINATION -->
																<nav aria-label="...">
	                                  <ul class="pagination">
	                                    <li class="page-item">
	                                      <button class="page-link" @click="_u_previous_page(get_client_abonne)">Previous</button>
	                                    </li>
	                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_client_abonne(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
	                                    <li class="page-item">
	                                      <button class="page-link" @click="_u_next_page(get_client_abonne)">Next</button>
	                                    </li>
	                                  </ul>
	                                </nav>
																<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
																</div>
																<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/public/load/empty.png" >
																	<h6 class="text-danger">Données vide!!</h6>
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
<?=$this->endSection() ?>
