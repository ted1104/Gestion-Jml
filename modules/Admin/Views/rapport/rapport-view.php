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
                      <div class="col-md-4 col-lg-4 col-xl-4 ">
                          <div class="card m-b-30">
                              <div class="card-header bg-white">
                                  <h5 class="card-title text-black">RAPPORT JOURNAL DE SORTI DEPOT</h5>
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
