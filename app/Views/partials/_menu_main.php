<!-- Start XP Sidebar -->
<div class="xp-sidebar">

    <!-- Start XP Logobar -->
    <div class="xp-logobar text-center">
        <a href="index.html" class="xp-logo"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a>
    </div>
    <!-- End XP Logobar -->

    <!-- Start XP Navigationbar -->
    <div class="xp-navigationbar">
        <ul class="xp-vertical-menu">
            <li class="xp-vertical-header">Menu</li>
            <!-- MENU MANAGER -->
            <?php if(session('users')['info'][0]->roles_id == 1):  ?>
              <li>
                  <a href="<?=base_url('facturier-dashboard') ?>">
                      <i class="mdi mdi-email"></i><span>Tableau De Bord</span>
                  </a>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Achat</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-list-achat') ?>">Achat</a></li>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Articles</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-article') ?>">Créer</a></li>
                      <li><a href="<?=base_url('admin-list-article') ?>">Liste</a></li>
                  </ul>
              </li>
              <li>
                  <a href="<?=base_url('admin-list-negotiation-achat') ?>">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Negotiation</span>
                  </a>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Approvisionnement</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-appro') ?>">Créer</a></li>
                  </ul>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-histo-appro') ?>">Historique</a></li>
                  </ul>
              </li>
            <?php endif; ?>

            <!-- MENU GERANT -->
            <?php if(session('users')['info'][0]->roles_id == 2): ?>
            <?php endif; ?>

            <!-- MENU CAISSIER -->
            <?php if(session('users')['info'][0]->roles_id == 3): ?>
              <li>
                  <a href="<?=base_url('facturier-dashboard') ?>">
                      <i class="mdi mdi-email"></i><span>Tableau De Bord</span>
                  </a>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Achats</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <?php if(session('users')['info'][0]->is_main == 1): ?>
                      <li><a href="<?=base_url('caissier-add-achat') ?>">Créer</a></li>
                      <?php endif;?>
                      <li><a href="<?=base_url('caissier-list-achat') ?>">Mes Achats</a></li>
                  </ul>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-security"></i><span>G-Decaissement</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                    <?php if(session('users')['info'][0]->is_main == 1): ?>
                      <li><a href="<?=base_url('caissier-list-decaissement') ?>">Demandes</a></li>
                    <?php else: ?>
                      <li><a href="<?=base_url('caissier-add-decaissement') ?>">Créer</a></li>
                    <?php endif;?>

                  </ul>
              </li>

            <?php endif; ?>

            <!-- MENU FACTURIER -->
            <?php if(session('users')['info'][0]->roles_id == 4): ?>
              <li>
                  <a href="<?=base_url('facturier-dashboard') ?>">
                      <i class="mdi mdi-email"></i><span>Tableau De Bord</span>
                  </a>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Achats</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('facturier-add-achat') ?>">Créer</a></li>
                      <li><a href="<?=base_url('facturier-list-achat') ?>">Mes Achats</a></li>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>Rapport</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                    <li><a href="chart-chartistjs.html">Journalier</a></li>
                    <li><a href="chart-chartistjs.html">Mensuel</a></li>
                      <li><a href="chart-chartistjs.html">Annuel</a></li>

                  </ul>
              </li>
            <?php endif; ?>

            <!-- MENU MAGASINIER -->
            <?php if(session('users')['info'][0]->roles_id == 5): ?>
              <li>
                  <a href="<?=base_url('magaz-dashboard') ?>">
                      <i class="mdi mdi-email"></i><span>Tableau De Bord</span>
                  </a>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Achats</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('magaz-list-achat') ?>">Mes Achats</a></li>
                  </ul>
              </li>
            <?php endif; ?>

            <!--
            <li>
                <a href="javaScript:void();">
                    <i class="mdi mdi-table"></i><span>Tables</span><i class="mdi mdi-chevron-right pull-right"></i>
                </a>
                <ul class="xp-vertical-submenu">
                    <li><a href="table-bootstrap.html">Bootstrap Table</a></li>
                    <li><a href="table-datatable.html">Data Table</a></li>
                    <li><a href="table-editable.html">Editable Table</a></li>
                    <li><a href="table-rwdtable.html">RWD Table</a></li>
                </ul>
            </li>
            <li>
                <a href="javaScript:void();">
                    <i class="mdi mdi-map"></i><span>Maps</span><span class="badge badge-pill badge-danger pull-right">2</span>
                </a>
                <ul class="xp-vertical-submenu">
                    <li><a href="map-google.html">Google Map</a></li>
                    <li><a href="map-vector.html">Vector Map</a></li>
                </ul>
            </li>
            <li class="xp-vertical-header">Extras</li>
            <li>
                <a href="javaScript:void();">
                    <i class="mdi mdi-security"></i><span>Authenication</span><i class="mdi mdi-chevron-right pull-right"></i>
                </a>
                <ul class="xp-vertical-submenu">
                    <li><a href="page-login.html">Login</a></li>
                    <li><a href="page-register.html">Register</a></li>
                    <li><a href="page-forgotpsw.html">Forgot Password</a></li>
                    <li><a href="page-lock-screen.html">Lock Screen</a></li>
                    <li><a href="page-comingsoon.html">Coming Soon</a></li>
                    <li><a href="page-maintenance.html">Maintenance</a></li>
                    <li><a href="page-404.html">Error 404</a></li>
                    <li><a href="page-403.html">Error 403</a></li>
                    <li><a href="page-500.html">Error 500</a></li>
                    <li><a href="page-503.html">Error 503</a></li>
                </ul>
            </li>
            <li>
                <a href="javaScript:void();">
                    <i class="mdi mdi-book-open-page-variant"></i><span>Extra Pages</span><i class="mdi mdi-chevron-right pull-right"></i>
                </a>
                <ul class="xp-vertical-submenu">
                    <li><a href="page-starter.html">Starter Page</a></li>
                    <li><a href="page-timeline.html">Timeline</a></li>
                    <li><a href="page-pricing.html">Pricing</a></li>
                    <li><a href="page-invoice.html">Invoice</a></li>
                    <li><a href="page-faq.html">FAQ</a></li>
                </ul>
            </li> -->
        </ul>
    </div>
    <!-- End XP Navigationbar -->

</div>
<!-- End XP Sidebar -->
