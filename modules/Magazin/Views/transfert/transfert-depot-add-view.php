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
													 <h4>TRANSFERT STOCK INTER-MAGASINIER</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-5 col-lg-5 col-xl-5 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative à l'approvisionnement</h5>
                            </div>
                            <div class="card-body">
																	<div class="form-group">
																		<label for="userssource">Magasinier Source</label>
																		<input type="text" class="form-control" value="<?=session('users')['info'][0]->prenom.' '.session('users')['info'][0]->nom ?>" disabled>
																	</div>
                                  <div class="form-group">
                                    <label for="depots_id">Magasinier Destination</label>
																		<select class="form-control" v-model="usersDestTransfert">
																			<option v-for="(u, i) in usersListParDepot" :value="u.id" v-if="u.id != users_id">{{u.nom+' '+u.prenom}}</option>
																		</select>

                                  </div>
																	<div class="form-group">
                                    <label for="date_transfert">Date</label>
                                    <input type="text" class="form-control" id="date_transfert" v-model="date_transfert" disabled>
                                  </div>
                                	<button v-if="!isLoadSaveMainButton" @click="add_transfert" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-7 col-lg-7 col-xl-7">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative aux articles</h5>
                            </div>
														<div class="card-body row" style="padding-bottom:-200px!important">
																<div class="form-group col-md-4 col-lg-4 col-xl-4">
																	<span>Code Art</span>
																</div>
																<div class="form-group col-md-4 col-lg-4 col-xl-4">
																	<span>Qte Art</span>
																</div>
																<div class="form-group col-md-4 col-lg-4 col-xl-4">
																	<span>Action</span>
																</div>
														</div>
                            <div class="card-body">
                                <div class="row">
																	<div class="form-group col-md-4 col-lg-4 col-xl-4">
																		<input type="text" class="form-control" v-model="codeArticle">

	                                </div>
	                                <div class="form-group col-md-4 col-lg-4 col-xl-4">
	                                  <input type="text" class="form-control" id="exampleInputPassword1" v-model="qte">
	                                </div>
																	<div class="form-group col-md-4 col-lg-4 col-xl-4">
	                                   <button v-if="!isLoadSaveMainButtonModal" class="btn btn-round btn-success" @click="_u_create_line_article_transfert"><i class="mdi mdi-plus"></i> </button>
																		 <img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">

	                                </div>
                                </div>
                            </div>
														<div class="table-responsive container">
															<!-- {{tabListData}} -->
															<table class="table">
																<thead>
																	<tr class="bg-secondary">
																		<th scope="col">Code</th>
																		<th scope="col">Nom</th>
																		<th scope="col">Qte</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in tabListData">
																		<th>{{dt.code}}</th>
																		<td>{{dt.nom_article }}</td>
																		<td>{{dt.qte}}</td>
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
