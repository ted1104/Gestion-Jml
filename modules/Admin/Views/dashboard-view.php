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
