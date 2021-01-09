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
													 <h4>AJOUT D'UN ARTICLE</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
													<div class="card m-b-30">
                            <div class="card-header bg-white">
                                <h5 class="card-title text-black">Information relative à l'article</h5>
                            </div>
                            <div class="card-body">
                                  <div class="form-group">
                                    <label for="codeArt">Code Article *</label>
                                    <input type="text" class="form-control" id="codeArt" aria-describedby="codeArt" v-model="code_article">
                                  </div>
                                  <div class="form-group">
                                    <label for="nom_article">Nom de l'article *</label>
                                    <input type="text" class="form-control" id="nom_article" v-model="nom_article">
                                  </div>
																	<div class="form-group">
                                    <label for="poids">Poids en Kg</label>
                                    <input type="text" class="form-control" id="poids" v-model="poids">
                                  </div>
																	<div class="form-group">
                                    <label for="nombre_piece">Nombre Piece dans Boite</label>
                                    <input type="text" class="form-control" id="nombre_piece" v-model="nombre_piece">
                                  </div>
																	<div class="form-group">
                                    <label for="description">Descrition *</label>
                                    <textarea class="form-control" name="inputTextarea" id="description" rows="3" v-model="description"></textarea>
                                  </div>
                              		<button v-if="!isLoadSaveMainButtonModal" @click="add_article" class="btn btn-primary">Enregistrer</button>
																	<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
                            </div>
                        </div>
												</div>
												<div class="col-md-8 col-lg-8 col-xl-8">
												<div class="card m-b-30">
                          <div class="card-header bg-white">
                              <h5 class="card-title text-black">Articles Recemment ajoutés</h5>
                          </div>
                          <div class="card-body">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-secondary">
																			<th>#</th>
                                      <th>Code</th>
																			<th>Nom</th>
                                      <th>Pièces</th>
																			<th>Description</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(dt, index) in dataToDisplay">
																			<th>{{+index+1}}</th>
                                      <th>{{dt.code_article}}</th>
																			<td>{{dt.nom_article}}</td>
																			<td>{{dt.nombre_piece}}</td>
                                      <td>{{dt.description}}</td>
																			<td>
																				<button class='btn btn-round btn-success' @click="_u_open_mod_form(dt,1)"><i class='mdi mdi-plus'></i> </button>
																			</td>
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
						<div class="modal-body" v-if="!isWantBeDeleted">
							<div class="form-group" v-if="isAction">
								<label for="qte_decideur_min">Quantité Min *</label>
								<input type="text" class="form-control" id="qte_decideur_min" aria-describedby="qte_decideur_min" v-model="qte_decideur_min">
							</div>
							<div class="form-group" v-if="isAction">
								<label for="qte_decideur_max">Quantité Max *</label>
								<input type="text" class="form-control" id="qte_decideur_max" aria-describedby="qte_decideur_max" v-model="qte_decideur_max">
							</div>
							<div class="form-group">
								<label for="prix_unitaire">Prix Unitaire *</label>
								<input type="text" class="form-control" id="prix_unitaire" aria-describedby="prix_unitaire" v-model="prix_unitaire">
							</div>

							<div v-if="!isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="update_article_prix" class="btn btn-primary">Modifier</button>
							</div>
							<div v-if="isAction">
								<button v-if="!isLoadSaveMainButtonModal" @click="add_article_prix" class="btn btn-primary">Enregistrer</button>
							</div>
							<img v-if="isLoadSaveMainButtonModal" src="<?=base_url() ?>/public/load/loader.gif" alt="">
						</div>

						<div class="modal-body text-center" v-if="isWantBeDeleted">
							<span class=""><i class="mdi mdi-alert icon-size-1x"></i></span><br>
							<span class="text-danger">
								Vous êtes sur le point de supprimer definitivement cette configuration du prix, cette action est irreversible. Si vous l'executer sans connaissance de cause ça peut causer un dysfonctionnement du système surtout coté prix de l'article!
							</span>
							<div class="">
								<button v-if="!isLoadDelete" @click="delete_article_price" class="btn btn-danger">Supprimer</button>
								<img v-if="isLoadDelete" src="<?=base_url() ?>/public/load/loader.gif" alt="">
							</div>
						</div>

				</div>
		</div>
</div>
<?=$this->endSection() ?>
