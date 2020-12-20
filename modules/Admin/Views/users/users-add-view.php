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
													 <h4>CREER UN NOUVEAU UTILISATEUR</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<!-- OPERATION ADD COMMANDE -->
											<div class="row">
												<div class="col-md-4 col-lg-4 col-xl-4 ">
														<div class="card m-b-30">
		                            <div class="card-header bg-white">
		                                <h5 class="card-title text-black">Information Générale</h5>
		                            </div>
		                            <div class="card-body">
		                                  <div class="form-group">
		                                    <label for="nom">Nom</label>
		                                    <input type="text" class="form-control" id="nom" aria-describedby="numero_commande" v-model="nom">
		                                  </div>
		                                  <div class="form-group">
		                                    <label for="prenom">Prénom</label>
		                                    <input type="text" class="form-control" id="prenom" v-model="prenom">
		                                  </div>
																			<div class="form-group">
																				<div class="custom-control custom-radio custom-control-inline">
																					<input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" value="M" v-model="RadioCheckedSexe"checked>
																					<label class="custom-control-label" for="customRadioInline1">Masculin</label>
																				</div>
																				<div class="custom-control custom-radio custom-control-inline">
																					<input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input" value="F" v-model="RadioCheckedSexe">
																					<label class="custom-control-label" for="customRadioInline2">Feminin</label>
																				</div>
																			</div>
																			<div class="form-group">
		                                    <label for="tel">Téléphone</label>
		                                    <input type="text" class="form-control" id="tel" v-model="tel">
		                                  </div>
																			<div class="form-group">
		                                    <label for="roles_id">Profile</label>
																				<select class="form-control" v-model="roles_id">
																					<option v-for="(dp, i) in profileList" :value="dp.id">{{dp.description}}</option>
																				</select>
		                                  </div>

		                            </div>
	                        		</div>
													</div>
													<div class="col-md-4 col-lg-4 col-xl-4 ">
															<div class="card m-b-30">
																	<div class="card-header bg-white">
																			<h5 class="card-title text-black">Informations sécondaires</h5>
																	</div>
																	<div class="card-body">
																		<div class="form-group">
																			<label for="dob">Date Naissance</label>
																			<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dob"></vuejs-datepicker>
																			<!-- {{dob}} -->
																		</div>
																		<div class="form-group">
																			<label for="depots_id">Lieu Affectation</label>
																			<select class="form-control" v-model="depot_id">
																				<option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																			</select>
																		</div>
																		<div class="form-group">
																			<label for="date_debut_service">Date début service</label>

																				<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="date_debut_service"></vuejs-datepicker>

																				<!-- {{date_debut_service}} -->
																		</div>

																		<div class="form-group">
																			<div class="custom-control custom-radio custom-control-inline">
																				<input type="radio" id="customRadioInline3" name="customRadioInline3" class="custom-control-input" value="1" v-model="RadioCheckedIsMain"checked>
																				<label class="custom-control-label" for="customRadioInline3">Principal</label>
																			</div>
																			<div class="custom-control custom-radio custom-control-inline">
																				<input type="radio" id="customRadioInline4" name="customRadioInline4" class="custom-control-input" value="0" v-model="RadioCheckedIsMain">
																				<label class="custom-control-label" for="customRadioInline4">Secondaire</label>
																			</div>
																		</div>
																		<div class="form-group">
																			<label for="username">Nom utilisateur</label>
																			<input type="text" class="form-control" id="username" v-model="username">
																		</div>
																	</div>
																</div>
														</div>
														<div class="col-md-4 col-lg-4 col-xl-4 ">
																<div class="card m-b-30">
																		<div class="card-header bg-white">
																				<h5 class="card-title text-black">Informations Sécurité</h5>
																		</div>
																		<div class="card-body">
																			<div class="form-group">
																				<label for="password_main">Mot de passe</label>
																				<input type="password" class="form-control" id="password_main" v-model="password_main">
																			</div>
																			<div class="form-group">
																				<label for="password_main_conf">Confirmer Mot de passe</label>
																				<input type="password" class="form-control" id="password_main_conf" v-model="password_main_conf">
																			</div>

																			<div class="form-group">
																				<label for="password_op">Mot de passe des operations</label>
																				<input type="password" class="form-control" id="password_op" v-model="password_op">
																			</div>

																			<div class="form-group">
																				<label for="password_op_conf">Confirmer Mot de passe des operations</label>
																				<input type="password" class="form-control" id="password_op_conf" v-model="password_op_conf">
																			</div>

																			<button v-if="!isLoadSaveMainButton" @click="add_users" class="btn btn-primary">Enregistrer</button>
																			<img v-if="isLoadSaveMainButton" src="<?=base_url() ?>/public/load/loader.gif" alt="">

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
