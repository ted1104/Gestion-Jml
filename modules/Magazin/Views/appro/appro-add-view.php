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
													 <h4>APPROVISIONNEMENT DU STOCK</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-5 col-lg-5 col-xl-5 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative à la commande</h5>
                            </div>
                            <div class="card-body">
                                  <!-- <div class="form-group">
                                    <label for="depots_id">Dépôt</label>
																		<select class="form-control" v-model="depots_id">
																			<option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																		</select>
                                  </div> -->
																	<div class="form-group">
                                    <label for="plaque">Plaque vehicule</label>
                                    <input type="text" class="form-control" id="plaque" v-model="plaque">
                                  </div>
																	<div class="form-group">
                                    <label for="nom_chauffeur">Nom chauffeur</label>
                                    <input type="text" class="form-control" id="nom_chauffeur" v-model="nom_chauffeur">
                                  </div>
																	<div class="form-group">
                                    <label for="num_chauffeur">Numéro téléphone chauffeur</label>
                                    <input type="text" class="form-control" id="num_chauffeur" v-model="num_chauffeur">
                                  </div>
																	<div class="form-group">
                                    <label for="num_bordereau">Numéro bordereau</label>
                                    <input type="text" class="form-control" id="num_bordereau" v-model="num_bordereau">
                                  </div>
																	<div class="form-group">
                                    <label for="date_approvisionnement">Date</label>
                                    <input type="text" class="form-control" id="date_approvisionnement" v-model="date_approvisionnement" disabled>
                                  </div>
                                	<button v-if="!isLoadSaveMainButton" @click="add_approvision" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-7 col-lg-7 col-xl-7">
													<div class="card m-b-30 container">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative aux articles</h5>
                            </div>
														<div class="card-body row" style="padding-bottom:-200px!important">
																<div class="form-group col-md-3 col-lg-3 col-xl-3">
																	<span>Code Art</span>
																</div>
																<div class="form-group col-md-2 col-lg-2 col-xl-2">
																	<span>Qte Total</span>
																</div>
																<div class="form-group col-md-2 col-lg-2 col-xl-2">
																	<span>Qte Bonne</span>
																</div>
																<div class="form-group col-md-2 col-lg-2 col-xl-2">
																	<span>Qte PV</span>
																</div>
																<div class="form-group col-md-3 col-lg-3 col-xl-3">
																	<span>Action</span>
																</div>


														</div>
                            <div class="card-body">
                                <div class="row">
																	<div class="form-group col-md-3 col-lg-3 col-xl-3">
																		<input type="text" class="form-control" v-model="codeArticle">
	                                </div>
																	<div class="form-group col-md-2 col-lg-2 col-xl-2">
	                                  <input type="text" class="form-control" id="exampleInputPassword1" v-model="qteTotal">
	                                </div>
	                                <div class="form-group col-md-2 col-lg-2 col-xl-2">
	                                  <input type="text" class="form-control" id="exampleInputPassword1" v-model="qte">
	                                </div>
																	<div class="form-group col-md-2 col-lg-2 col-xl-2">
	                                  <input type="text" class="form-control" id="exampleInputPassword1" v-model="qtePv">
	                                </div>
																	<div class="form-group col-md-3 col-lg-3 col-xl-3">
	                                   <button v-if="!isLoadSaveMainButtonModal" class="btn btn-round btn-success" @click="_u_create_line_article_appro"><i class="mdi mdi-plus"></i> </button>
																		 <img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">

	                                </div>
                                </div>
                            </div>
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Code</th>
																		<th scope="col">Nom</th>
																		<th scope="col">Qte Total</th>
																		<th scope="col">Qte Bonne</th>
																		<th scope="col">Qte Pv</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in tabListData">
																		<th>{{dt.info[0].code_article}}</th>
																		<td>{{dt.info[0].nom_article}}</td>
																		<td>{{dt.qteTotal}}</td>
																		<td>{{dt.qtea}}</td>
																		<td>{{dt.qtePv}}</td>
																		<td><button  class="btn btn-round btn-danger" @click="_u_remove_line_list_art(index)"><i class="mdi mdi-delete-sweep" ></i></button></td>
																	</tr>
																</tbody>
															</table>
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
