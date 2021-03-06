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
                    <div class="col-md-12 col-lg-12 col-xl-12">
                      <div class="row">
												<?php if(session('accessDroit')['g_rapport_sorti_depot_journalier_detail'] == 1): ?>
												<div class="col-md-4 col-lg-4 col-xl-4 ">
	                          <div class="card m-b-30">
	                              <div class="card-header bg-white">
	                                  <h5 class="card-title text-black">RAPPORT JOURNAL DE SORTI DEPOT JOURNALIER</h5>
	                              </div>
	                              <div class="card-body margin-bottom-8">
	                                <div class="form-group">
	                                  <label for="dateRapport">Date</label>
	                                  <vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapport"></vuejs-datepicker>
	                                </div>
	                                <div class="form-group">
	                                  <label for="depots_id">Dépôt</label>
	                                  <select class="form-control" v-model="depot_id">
	                                    <option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
	                                  </select>
	                                </div>
	                                <a target="_blank" :href="'<?=base_url() ?>/rapport-journal-de-sorti-par-depot/'+depot_id+'/'+dateRapport+''" class="btn btn-primary">Généré</a>
	                              </div>
	                            </div>
	                        </div>
													<?php endif; ?>
													<?php if(session('accessDroit')['g_rapport_financier'] == 1): ?>
													<div class="col-md-4 col-lg-4 col-xl-4 ">
		                          <div class="card m-b-30">
		                              <div class="card-header bg-white">
		                                  <h5 class="card-title text-black">RAPPORT FINANCIER JOURNALIER</h5>
		                              </div>
		                              <div class="card-body margin-bottom-8">
		                                <div class="form-group">
		                                  <label for="dateRapportFin">Date</label>
		                                  <vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportFin"></vuejs-datepicker>
		                                </div>
		                                <a target="_blank" :href="'<?=base_url() ?>/rapport-financier-journalier/'+dateRapportFin+''" class="btn btn-primary">Généré</a>
		                              </div>
		                            </div>
		                        </div>
														<?php endif; ?>
														<?php if(session('accessDroit')['g_rapport_stock_general'] == 1): ?>
														<div class="col-md-4 col-lg-4 col-xl-4 ">
			                          <div class="card m-b-30">
		                              <div class="card-header bg-white">
		                                  <h5 class="card-title text-black">RAPPORT STOCK GENERAL</h5>
		                              </div>
		                              <div class="card-body margin-bottom-8">
		                                <div class="form-group">
		                                  <label for="dateRapportGen">Date</label>
		                                  <vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportGen"></vuejs-datepicker>
		                                </div>
		                                <a target="_blank" :href="'<?=base_url() ?>/rapport-stock-general/'+dateRapportGen+''" class="btn btn-primary">Généré</a>
		                              </div>
		                            </div>
		                        </div>
														<?php endif; ?>
														<?php if(session('accessDroit')['g_rapport_sorti_entree'] == 1): ?>
														<div class="col-md-4 col-lg-4 col-xl-4 ">
																<div class="card m-b-30">
																		<div class="card-header bg-white">
																				<h5 class="card-title text-black">RAPPORT STOCK ENTREE ET SORTI</h5>
																		</div>
																		<div class="card-body margin-bottom-8">
																			<div class="form-group">
																			 <label for="depots_id">Dépôt</label>
																			 <select class="form-control" v-model="depot_id_in">
																				 <option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																			 </select>
																		 </div>
																			<div class="form-group">
																				<!-- {{dateRapportDebut}} -->
																				<label for="dateRapportDebut">Date Début</label>
																				<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportDebut"></vuejs-datepicker>
																			</div>
																			<div class="form-group">
																				<!-- {{dateRapportEnd}} -->
																				<label for="dateRapportEnd">Date Fin</label>
																				<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportEnd"></vuejs-datepicker>
																			</div>
																			<!-- {{dateRapportDebut < dateRapportEnd}} -->
																			<a v-if="dateRapportDebut <= dateRapportEnd && depot_id_in > 0" target="_blank" :href="'<?=base_url() ?>/rapport-stock-entree-sortie/'+depot_id_in+'/'+dateRapportDebut+'/'+dateRapportEnd" class="btn btn-primary">Généré</a>

																			<button v-if="dateRapportEnd < dateRapportDebut || !depot_id_in" type="button" disabled name="button" class="btn btn-primary">Généré</button>
																		</div>
																	</div>
															</div>
															<?php endif; ?>
															<?php if(session('accessDroit')['g_rapport_approvisionnement'] == 1): ?>
															<div class="col-md-4 col-lg-4 col-xl-4 ">
																	<div class="card m-b-30">
																			<div class="card-header bg-white">
																					<h5 class="card-title text-black">RAPPORT APPROVISIONNEMENT</h5>
																			</div>
																			<div class="card-body margin-bottom-8">
																				<div class="form-group">
																				 <label for="depots_id">Dépôt</label>
																				 <select class="form-control" v-model="depot_id_in_app">
																					 <option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																				 </select>
																			 </div>
																				<div class="form-group">
																					<!-- {{dateRapportDebut}} -->
																					<label for="dateRapportDebutAppro">Date Début</label>
																					<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportDebutAppro"></vuejs-datepicker>
																				</div>
																				<div class="form-group">
																					<!-- {{dateRapportEnd}} -->
																					<label for="dateRapportEndAppro">Date Fin</label>
																					<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportEndAppro"></vuejs-datepicker>
																				</div>
																				<!-- {{dateRapportDebut < dateRapportEnd}} -->
																				<a v-if="dateRapportDebutAppro <= dateRapportEndAppro && depot_id_in_app > 0" target="_blank" :href="'<?=base_url() ?>/rapport-stock-approvisionnement/'+depot_id_in_app+'/'+dateRapportDebutAppro+'/'+dateRapportEndAppro" class="btn btn-primary">Généré</a>

																				<button v-if="dateRapportEndAppro < dateRapportDebutAppro || !depot_id_in_app" type="button" disabled name="button" class="btn btn-primary">Généré</button>
																			</div>
																		</div>
																</div>
																<?php endif; ?>
																<?php if(session('accessDroit')['g_rapport_sorti_magasinier_journalier_detail'] == 1): ?>
																<div class="col-md-4 col-lg-4 col-xl-4 ">
																		<div class="card m-b-30">
																				<div class="card-header bg-white">
																						<h5 class="card-title text-black">RAPPORT JOURNAL DE SORTI JOURNALIER DEPOT PERSONNEL </h5>
																				</div>
																				<div class="card-body margin-bottom-8">
																					<div class="form-group">
																						<label for="dateRapportPersonnel">Date</label>
																						<vuejs-datepicker input-class="form-control" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateRapportPersonnel"></vuejs-datepicker>
																					</div>
																					<div class="form-group">
																						<label for="depots_id_perso">Dépôt</label>
																						<select class="form-control" v-model="depots_id_perso" @change="get_magasinier_by_depot(depots_id_perso)">
																							<option v-for="(dp, i) in depotList" :value="dp.id">{{dp.nom}}</option>
																						</select>
																					</div>
																					<div class="form-group">
				                                    <label for="depots_id">Magasinier Destination</label>
																						<select class="form-control" v-model="usersDestTransfert">
																							<option v-for="(u, i) in usersListParDepot" :value="u.id" v-if="u.id != users_id">{{u.nom+' '+u.prenom}}</option>
																						</select>
				                                  </div>
																					<a target="_blank" :href="'<?=base_url() ?>/rapport-journal-de-sorti-par-magazinier/'+usersDestTransfert+'/'+dateRapportPersonnel+''" class="btn btn-primary">Généré</a>
																				</div>
																			</div>
																	</div>
																		<?php endif; ?>
											</div>
                    </div>

										<?php if(session('accessDroit')['g_rapport_sorti_depot_journalier_detail'] == 0 && session('accessDroit')['g_rapport_sorti_magasinier_journalier_detail'] == 0 && session('accessDroit')['g_rapport_stock_general'] == 0 && session('accessDroit')['g_rapport_financier'] == 0 && session('accessDroit')['g_rapport_approvisionnement'] == 0 ):?>
											<div class="messageInfo">
												<div class="text-center">
													<img src="<?=base_url() ?>/public/load/empty.png">
													<h6 class="text-info">Vous n'avez aucun rapport disponible pour l'instant, veuillez contacter l'administrateur du système ou si vous êtes un administrateur, veuillez naviguer dans la partie utilisateur et activer la visibilité de rapports</h6>
													<h6>Après activation, vous devez vous reconnecter de nouveau afin que les modifications prennent effet!</h6>
												</div>
											</div>
										<?php endif; ?>
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
