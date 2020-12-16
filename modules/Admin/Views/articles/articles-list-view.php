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
													 <h4>LISTE DE TOUS LES ARTICLE</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div class="col-md-12 col-lg-12 col-xl-12">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <div class="row">
																<h5 class="card-title text-black col-md-8 col-lg-8 col-xl-8">Lite de tous les articles</h5>
																<div class="col-md-4 col-lg-4 col-xl-4 ">
																	<div class="custom-control custom-checkbox custom-control-inline">
																		<input type="checkbox" name="checkBoxArticles" id="1" class="custom-control-input" value="1" v-model="checkBoxArticles">
																		<label class="custom-control-label" for="1">Modifier</label>
																	</div>
																</div>
                              </div>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-secondary">
                                      <th scope="col">Code</th>
                                      <th scope="col">Nom</th>
																			<th scope="col">Prix Gros</th>
																			<th scope="col">Qte Gros</th>
                                      <th scope="col">Prix Détail</th>
																			<th scope="col">Qte Detail</th>
                                      <th scope="col">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in dataToDisplay">
                                      <th>{{dt.code_article}}</th>
                                      <td>{{dt.nom_article}}</td>

																			<td>
																				<button  v-if="dt.logic_detail_data.length < 1 || (dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix !=1)" class='btn btn-round btn-success' @click="_u_open_mod_form(dt,1)"><i class='mdi mdi-plus'></i> </button>

																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==2" >{{dt.logic_detail_data[0].type_prix==1 ?dt.logic_detail_data[0].prix_unitaire+' USD':dt.logic_detail_data[1].prix_unitaire+' USD'}} <i v-if="checkBoxArticles.length>0" class="mdi mdi-circle-edit-outline text-danger" @click="_u_open_mod_form(dt,1,1)"></i></span>

																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==1" >{{dt.logic_detail_data[0].prix_unitaire+' USD'}} <i v-if="checkBoxArticles.length>0" class="mdi mdi-circle-edit-outline text-danger" @click="_u_open_mod_form(dt,1,1)"></i></span>


																			</td>
																			<td>
																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==2" >{{dt.logic_detail_data[0].type_prix==1 ?' > '+dt.logic_detail_data[0].qte_decideur:' > '+dt.logic_detail_data[1].qte_decideur}}</span>
																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==1" >{{' > '+dt.logic_detail_data[0].qte_decideur}}</span>
																				<span v-if="dt.logic_detail_data.length < 1 || dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==2">-</span>
																			</td>
																			<td>
																				<button  v-if="dt.logic_detail_data.length < 1 || (dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix !=2)" class='btn btn-round btn-success' @click="_u_open_mod_form(dt,2)"><i class='mdi mdi-plus'></i> </button>

																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==2" >{{dt.logic_detail_data[0].type_prix==1 ?dt.logic_detail_data[1].prix_unitaire+' USD':dt.logic_detail_data[0].prix_unitaire +' USD'}} <i v-if="checkBoxArticles.length>0" class="mdi mdi-circle-edit-outline text-danger" @click="_u_open_mod_form(dt,2,1)"></i></span>

																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==2" >{{dt.logic_detail_data[0].prix_unitaire+' USD'}} <i v-if="checkBoxArticles.length>0" class="mdi mdi-circle-edit-outline text-danger" @click="_u_open_mod_form(dt,2,1)"></i></span>

																			</td>
																			<td>
																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==2" >{{dt.logic_detail_data[0].type_prix==1 ?'<= '+dt.logic_detail_data[1].qte_decideur:'<= '+dt.logic_detail_data[0].qte_decideur}}</span>

																				<span v-if="dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==2" >{{'<= '+dt.logic_detail_data[0].qte_decideur}}</span>

																				<span v-if="dt.logic_detail_data.length < 1 || dt.logic_detail_data.length > 0 && dt.logic_detail_data.length==1 && dt.logic_detail_data[0].type_prix ==1">-</span>
																			</td>
                                      <td>
																				<a href="#"  class='btn btn-round btn-secondary' ><i class='mdi mdi-eye-outline'></i></a>
																				<a href="#" v-if="checkBoxArticles.length>0"  class='btn btn-round btn-info' ><i class="mdi mdi-circle-edit-outline text-white"></i></a>
																			</td>

                                    </tr>
                                  </tbody>
                                </table>
																<div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
																	<img src="<?=base_url() ?>/load/load-tab.gif" alt="">
																</div>
																<div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
																	<img src="<?=base_url() ?>/load/empty.png" >
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
							<div class="form-group">
								<label for="prix_unitaire">Prix Unitaire *</label>
								<input type="text" class="form-control" id="prix_unitaire" aria-describedby="prix_unitaire" v-model="prix_unitaire">
							</div>
							<div class="form-group">
								<label for="qte_decideur">Quantité *</label>
								<input type="text" class="form-control" id="qte_decideur" aria-describedby="qte_decideur" v-model="qte_decideur">
							</div>
							<div v-if="!isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="update_article_prix" class="btn btn-primary">Modifier</button>
							</div>
							<div v-if="isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="add_article_prix" class="btn btn-primary">Enregistrer</button>
							</div>
							<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/load/loader.gif" alt="">
            </div>

        </div>
    </div>
</div>
<?=$this->endSection() ?>
