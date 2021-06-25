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
                                      <button class="btn btn-round btn-outline-secondary margin-left-4" @click="_u_formatDateFilterWithoutStatus(get_logs)"><i class="mdi mdi-search-web"></i> </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div v-for="(dt, index) in dataToDisplay" class="xp-actions-history">
                                        <div class="xp-actions-history-list">
                                            <div class="xp-actions-history-item">
                                              <h6 class="mb-1 text-black">{{dt.action_id.name}} - {{dt.custom_error_message.name}}</h6>
                                              <p class="text-muted font-12">Séverité : <span :class="dt.action_id.severite ==1 ? 'text-success font-bold' : (dt.action_id.severite ==2 ? 'text-warning font-bold' :'text-danger font-bold')">{{dt.action_id.severite ==1 ? 'Informationel' : (dt.action_id.severite ==2 ? 'Critique' :'Grave')}}</span></p>
                                              <p class="text-muted font-12">{{ dt.custom_error_message.date}} - {{dt.time_ago}}</p>

                                                <p class="m-b-30">{{ dt.custom_error_message.message}}</p>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center" v-if="dataToDisplay.length < 1 && !isNoReturnedData">
                                      <img src="<?=base_url() ?>/public/load/load-tab.gif" alt="">
                                    </div>
                                    <div class="text-center" alt="" v-if="dataToDisplay.length < 1 && isNoReturnedData">
                                      <img src="<?=base_url() ?>/public/load/empty.png">
                                      <h6 class="text-danger">Données vide!!</h6>
                                    </div>
                                    <nav aria-label="...">
                                        <ul class="pagination">
                                          <li class="page-item">
                                            <button class="page-link" @click="_u_previous_page(get_logs)">Previous</button>
                                          </li>
                                          <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_logs(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                          <li class="page-item">
                                            <button class="page-link" @click="_u_next_page(get_logs)">Next</button>
                                          </li>
                                        </ul>
                                      </nav>
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
