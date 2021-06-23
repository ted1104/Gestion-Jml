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
                      <!-- Start XP Col -->
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-header bg-white">
                                    <h5 class="card-title text-black mb-0 pull-left">LOGs DES ACTIVITES DANS LE SYSTEME</h5>
                                    <div class="pull-right row">
                                      <vuejs-datepicker placeholder="Filtrer par date" input-class="form-control" clear-button-icon="mdi mdi-close-box text-danger" :bootstrap-styling=true format="yyyy-MM-dd" :clear-button=true v-model="dateFilter"></vuejs-datepicker>
                                      <button class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilter(get_commande_admin)"><i class="mdi mdi-search-web"></i> </button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="xp-actions-history">
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                                <h6 class="mb-1 text-black">Start Web Designing</h6>
                                                <p class="text-muted font-12">5 mins ago</p>
                                                <p class="m-b-30">We are start working on USA Project</p>
                                            </div>
                                        </div>
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                                <h6 class="mb-1 text-black">Completed Theme Development</h6>
                                                <p class="text-muted font-12">15 mins ago</p>
                                                <p class="m-b-30">We are completed a theme development into 5 days</p>
                                            </div>
                                        </div>
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                                <h6 class="mb-1 text-black">Project Submitted</h6>
                                                <p class="text-muted font-12">30 mins ago</p>
                                                <p class="m-b-30">We are done process of submitted project</p>
                                            </div>
                                        </div>
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                                <h6 class="mb-1 text-black">Received a Payment</h6>
                                                <p class="text-muted font-12">45 mins ago</p>
                                                <p class="m-b-30">We got monthy payment from clients</p>
                                            </div>
                                        </div>
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                                <h6 class="mb-1 text-black">Received a Payment</h6>
                                                <p class="text-muted font-12">45 mins ago</p>
                                                <p class="m-b-30">We got monthy payment from clients</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End XP Col -->
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
