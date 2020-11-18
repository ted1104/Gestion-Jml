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
													 <h4>CREER UNE COMMANDE D'UN CLIENT</h4>
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
                                  <div class="form-group">
                                    <label for="numero_commande">Numéro Facture</label>
                                    <input type="text" class="form-control" id="numero_commande" aria-describedby="numero_commande" v-model="numero_commande" disabled>
                                  </div>
                                  <div class="form-group">
                                    <label for="nom_client">Nom du client</label>
                                    <input type="text" class="form-control" id="nom_client" v-model="nom_client">
                                  </div>
																	<div class="form-group">
                                    <label for="depots_id">Dépôt Traiteur</label>
																		<select class="form-control" v-model="depots_id">
																			<option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																		</select>
                                  </div>
																	<div class="form-group">
                                    <label for="payer_a">Payer à</label>
																		<select class="form-control" v-model="payer_a">
																			<option v-for="(c, i) in caissierList" :value="c.id">{{c.nom+' '+c.prenom}}</option>
																		</select>
                                  </div>
																	<div class="form-group">
                                    <label for="date_vente">Date commande</label>
                                    <input type="text" class="form-control" id="date_vente" v-model="date_vente" disabled>
                                  </div>
                                	<button @click="add_commande" class="btn btn-primary">Enregistrer</button>
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
	                                  <input type="text" class="form-control" id="qte" v-model="qte">
	                                </div>
																	<div class="form-group col-md-4 col-lg-4 col-xl-4">
	                                   <button class="btn btn-round btn-success" @click="_u_create_line_article"><i class="mdi mdi-plus"></i> </button>

	                                </div>
                                </div>
                            </div>
														<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th scope="col">Code</th>
																		<th scope="col">Nom</th>
																		<th scope="col">Qte</th>
																		<th scope="col">PU</th>
																		<th scope="col">Type</th>
																		<th scope="col">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(dt, index) in tabListData">
																		<th>{{dt.code}}</th>
																		<td>{{dt.nom_article}}</td>
																		<td>{{dt.qte}}</td>
																		<td>{{dt.prix_unit}}</td>
																		<td>{{dt.type_prix}}</td>
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
