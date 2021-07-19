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
											<!-- End XP Col -->
											<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="card m-b-30">
															<div class="card-body">
																	<div class="xp-widget-box">
																			<div class="float-left">
																					<h4 class="xp-counter text-primary">{{D_NbreVente}}</h4>
																					<p class="mb-0 text-muted">Nbre Factures</p>
																			</div>
																			<div class="float-right">
																					<div class="xp-widget-icon xp-widget-icon-bg bg-primary-rgba">
																							<i class="mdi mdi-file-document font-30 text-primary"></i>
																					</div>
																			</div>
																			<div class="clearfix"></div>
																	</div>
															</div>
													</div>
											</div>
											<!-- End XP Col -->

											<!-- End XP Col -->
											<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="card m-b-30">
															<div class="card-body">
																	<div class="xp-widget-box">
																			<div class="float-left">
																					<h4 class="xp-counter text-success">{{D_MontantVente}} USD</h4>
																					<p class="mb-0 text-muted">Total Montant Ventes</p>
																			</div>
																			<div class="float-right">
																					<div class="xp-widget-icon xp-widget-icon-bg bg-success-rgba">
																							<i class="mdi mdi-currency-usd font-30 text-success"></i>
																					</div>
																			</div>
																			<div class="clearfix"></div>
																	</div>
															</div>
													</div>
											</div>
											<!-- End XP Col -->

											<!-- End XP Col -->
											<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="card m-b-30">
															<div class="card-body">
																	<div class="xp-widget-box">
																			<div class="float-left">
																					<h4 class="xp-counter text-warning">{{D_MontantBus}} USD</h4>
																					<p class="mb-0 text-muted">Total Montant Bus</p>
																			</div>
																			<div class="float-right">
																					<div class="xp-widget-icon xp-widget-icon-bg bg-warning-rgba">
																							<i class="mdi mdi-car-side font-30 text-warning"></i>
																					</div>
																			</div>
																			<div class="clearfix"></div>
																	</div>
															</div>
													</div>
											</div>
											<!-- End XP Col -->

											<!-- End XP Col -->
											<div class="col-md-6 col-lg-6 col-xl-3">
													<div class="card m-b-30">
															<div class="card-body">
																	<div class="xp-widget-box">
																			<div class="float-left">
																					<h4 class="xp-counter text-danger">{{D_MontantDecaiss}} USD</h4>
																					<p class="mb-0 text-muted">Total Montant Décaissé</p>
																			</div>
																			<div class="float-right">
																					<div class="xp-widget-icon xp-widget-icon-bg bg-danger-rgba">
																							<i class="mdi mdi-currency-usd font-30 text-danger"></i>
																					</div>
																			</div>
																			<div class="clearfix"></div>
																	</div>
															</div>
													</div>
											</div>

											<!-- End XP Col -->
											</div>
                    </div>


										<div class="col-md-12 col-lg-12 col-xl-12" style="margin-bottom :15px">
												<div class="card card-body">
													<div class="">
														<div class="pull-left row">
															<div class="col-12">
																<!-- <div class="custom-control custom-checkbox custom-control-inline">
																	<input type="checkbox" name="checkBoxArticles" id="0" class="custom-control-input" value="0" v-model="checkBoxArticles">
																	<label class="custom-control-label" for="0">{{checkBoxArticles.length > 0 ?'Désactiver': 'Activer'}} filtre d'interval</label>
																</div> -->
															</div>
														</div>
														<div class="pull-right row">
															<div class="form-group">
																<div class="row">
																	<div class="col-4">
																		<label for="">Nombre de jours passés</label>
																	</div>
																	<div class="col-6">
																		<input type="number" class="form-control" id="numero_commande" aria-describedby="nombreDeJours" v-model="nombreDeJours">
																	</div>
																</div>
															</div>
															<div v-if="checkBoxArticles.length > 0" class="margin-left-4">
																<span>DE : </span>
															</div>
															<div class="margin-left-4">
																<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
															</div>
															<div v-if="checkBoxArticles.length > 0" class="margin-left-4">
																<span>A : </span>
															</div>
															<div class="margin-left-4" v-if="checkBoxArticles.length > 0">
																<vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilterEnd"></vuejs-datepicker>
															</div>

															<!-- BOUTTON DECAISSEMENT EXTERNE -->
															<button class="btn btn-round btn-outline-secondary margin-left-4" @click="get_data_graphique"><i class="mdi mdi-search-web"></i> </button>
														</div>
													</div>
												</div>

												<div class="card" style="margin-top:20px; padding:10px 0px">
													<div class="row container">
														<div class="col-xl-12 ">
															<h6>SELECTIONNER LES ARTILCES</h6>
															<!-- {{checkBoxArtilcesDashbord}} -->
														</div>
													</div>
													<div class="row container">

														<div class="col-2" v-for="(dt, index) in dataToDisplay">
															<div class="custom-control custom-checkbox custom-control-inline">
																<input type="checkbox" name="checkBoxArtilcesDashbord" :id="dt.id" class="custom-control-input" :value="dt.id+'/'+dt.nom_article" v-model="checkBoxArtilcesDashbord">
																<label class="custom-control-label" :for="dt.id">{{dt.nom_article}}</label>
															</div>
														</div>
													</div>
												</div>
										</div>
										<div class="col-md-12 col-lg-12 col-xl-12" style="margin-bottom :100px">
											<highcharts v-if="checkBoxArtilcesDashbord.length > 0" :style="chartstyle" :options="chartOptions"></highcharts>
											<div class="text-center" v-if="checkBoxArtilcesDashbord.length==0">
												<h5>RAPPORT GRAPHIQUE ECOULEMENT ARTICLES {{nombreDeJours}} DERNIERS JOURS</h5>
												<span>Veuillez selectionner un article pour visualiser le rapport graphique</span>
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
