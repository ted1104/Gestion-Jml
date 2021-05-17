<!-- Start XP Sidebar -->
<div class="xp-sidebar">

    <!-- Start XP Logobar -->
    <div class="xp-logobar text-center" style="width:150px; height:auto">
        <a href="index.html" class="xp-logo"><img src="<?=base_url() ?>/public/assets/images/logo.jpg" class="img-fluid" alt="logo"></a>
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
                      <li><a href="<?=base_url('admin-list-achat-partiel') ?>">Achats Partiels</a></li>
                  </ul>
              </li>

              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Operation-Ventes</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-vente') ?>">Créer</a></li>
                      <li><a href="<?=base_url('admin-list-ventes') ?>">Mes Ventes</a></li>
                      <li><a href="<?=base_url('admin-list-dettes') ?>">Mes Déttes</a></li>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Articles</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-article') ?>">Créer</a></li>
                      <li><a href="<?=base_url('admin-list-article') ?>">Liste et Prix</a></li>
                      <li><a href="<?=base_url('admin-stock') ?>">Stock</a></li>
                      <li>
                          <a href="javaScript:void();">
                              <span>G-PV</span><i class="mdi mdi-chevron-right pull-right"></i>
                          </a>
                          <ul class="xp-vertical-submenu">
                            <li><a href="<?=base_url('admin-stock-pv') ?>">PV Stock</a></li>
                            <li>
                              <a href="javaScript:void();">
                                  <span>PV Perdue</span><i class="mdi mdi-chevron-right pull-right"></i>
                              </a>
                              <ul class="xp-vertical-submenu">
                                <li><a href="<?=base_url('admin-add-pv-historique') ?>">Créer</a></li>
                                <li><a href="<?=base_url('admin-historique-pv') ?>">Historique</a></li>
                              </ul>
                            </li>

                          </ul>
                      </li>

                      <li><a href="<?=base_url('admin-stock-personnel') ?>">Stock Personnel</a></li>
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
                      <!-- <li><a href="<?=base_url('admin-add-appro') ?>">Créer</a></li> -->
                      <li><a href="<?=base_url('admin-histo-appro') ?>">Historique </a></li>
                      <li><a href="<?=base_url('admin-histo-appro-inter-depot') ?>">Historique Inter-Dépôt</a></li>
                      <li><a href="<?=base_url('admin-histo-transfert') ?>">Historique Transferts</a></li>
                  </ul>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-table"></i><span>G-Caisses</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-caisse') ?>">Caissiers</a></li>
                      <li><a href="<?=base_url('admin-encaissement-interne') ?>">Encaissement interne</a></li>
                      <li><a href="<?=base_url('admin-encaissement-externe') ?>">Encaissement Externe</a></li>
                      <li><a href="<?=base_url('admin-decaissement-externe') ?>">Decaissement Externe</a></li>
                      <!-- <li><a href="table-editable.html">Editable Table</a></li>
                      <li><a href="table-rwdtable.html">RWD Table</a></li> -->
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-table"></i><span>G-Clients</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-client') ?>">Créer</a></li>
                      <li><a href="<?=base_url('admin-list-client') ?>">Liste</a></li>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-table"></i><span>G-Config</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-config-depot') ?>">C-Dépôt</a></li>
                      <li><a href="<?=base_url('admin-config-etat-critique') ?>">C-Etat Critique & Motif</a></li>
                      <li><a href="<?=base_url('admin-config-system') ?>">C-Système</a></li>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-table"></i><span>G-Utilisateurs</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('admin-add-users') ?>">Créer</a></li>
                      <li><a href="<?=base_url('admin-list-users') ?>">Liste</a></li>
                  </ul>
              </li>

              <li>
                  <a href="<?=base_url('admin-rapport') ?>">
                      <i class="mdi mdi-email"></i><span>Rapport</span>
                  </a>

              </li>
            <?php endif; ?>

            <!-- MENU GERANT -->
            <?php if(session('users')['info'][0]->roles_id == 2): ?>
              <li>
                  <a href="<?=base_url('gerant-dashboard') ?>">
                      <i class="mdi mdi-email"></i><span>Tableau De Bord</span>
                  </a>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Achat</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('gerant-list-achat') ?>">Achat</a></li>
                      <?php if(session('accessDroit')['g_achat_partiels'] == 1): ?>
                        <li><a href="<?=base_url('gerant-list-achat-partiel') ?>">Achats Partiels</a></li>
                      <?php endif; ?>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Articles</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                      <li><a href="<?=base_url('gerant-stock') ?>">Stock</a></li>
                      <?php if(session('accessDroit')['g_pv'] == 1): ?>
                        <li><a href="<?=base_url('gerant-stock-pv') ?>">PV Stock</a></li>
                      <?php endif; ?>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Approvisionnement</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">

                      <li><a href="<?=base_url('gerant-histo-appro') ?>">Historique </a></li>
                      <li><a href="<?=base_url('gerant-histo-appro-inter-depot') ?>">Historique Inter-Dépôt</a></li>
                  </ul>

              </li>
              <?php if(session('accessDroit')['g_systeme'] == 1): ?>
                <li>
                  <a href="<?=base_url('gerant-config-system') ?>">
                    <i class="mdi mdi-chart-areaspline"></i><span>C-Système</span>
                  </a>
                </li>
              <?php endif; ?>
            <?php endif; ?>

            <!-- MENU CAISSIER -->
            <?php if(session('users')['info'][0]->roles_id == 3): ?>
              <li>
                  <a href="<?=base_url('caissier-dashboard') ?>">
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
                      <?php if(session('accessDroit')['g_pv'] == 1): ?>
                        <?php if(session('accessDroit')['g_pv'] == 1): ?>

                          <li>
                              <a href="javaScript:void();">
                                  <span>G-PV</span><i class="mdi mdi-chevron-right pull-right"></i>
                              </a>
                              <ul class="xp-vertical-submenu">
                                <li><a href="<?=base_url('caissier-stock-pv') ?>">PV Stock</a></li>
                                <li>
                                  <a href="javaScript:void();">
                                      <span>PV Perdue</span><i class="mdi mdi-chevron-right pull-right"></i>
                                  </a>
                                  <ul class="xp-vertical-submenu">
                                    <li><a href="<?=base_url('caissier-add-pv-historique') ?>">Créer</a></li>
                                    <li><a href="<?=base_url('caissier-historique-pv') ?>">Historique</a></li>
                                  </ul>
                                </li>

                              </ul>
                          </li>
                        <?php endif; ?>
                      <?php endif; ?>
                  </ul>

              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-security"></i><span>G-Decaissement</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                    <?php if(session('users')['info'][0]->is_main == 1): ?>
                      <li><a href="<?=base_url('caissier-list-decaissement') ?>">En cours</a></li>
                      <li><a href="<?=base_url('caissier-list-caissier') ?>">Caissiers</a></li>
                    <?php else: ?>
                      <li><a href="<?=base_url('caissier-add-decaissement') ?>">Créer</a></li>
                    <?php endif;?>

                  </ul>
              </li>
              <?php if(session('users')['info'][0]->is_main == 1): ?>
                <li>
                    <a href="<?=base_url('caissier-encaissement-externe') ?>">
                        <i class="mdi mdi-email"></i><span>G-Encaissement</span>

                    </a>
                </li>
              <?php endif; ?>
              <?php if(session('accessDroit')['g_systeme'] == 1): ?>
                <li>
                  <a href="<?=base_url('caissier-config-system') ?>">
                    <i class="mdi mdi-chart-areaspline"></i><span>C-Système</span>
                  </a>
                </li>
              <?php endif; ?>
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

                        <?php if(session('accessDroit')['g_pv'] == 1): ?>
                          <!-- <li><a href="<?=base_url('facturier-stock-pv') ?>">PV Stock</a></li> -->
                          <li>
                              <a href="javaScript:void();">
                                  <span>G-PV</span><i class="mdi mdi-chevron-right pull-right"></i>
                              </a>
                              <ul class="xp-vertical-submenu">
                                <li><a href="<?=base_url('facturier-stock-pv') ?>">PV Stock</a></li>
                                <li>
                                  <a href="javaScript:void();">
                                      <span>PV Perdue</span><i class="mdi mdi-chevron-right pull-right"></i>
                                  </a>
                                  <ul class="xp-vertical-submenu">
                                    <li><a href="<?=base_url('facturier-add-pv-historique') ?>">Créer</a></li>
                                    <li><a href="<?=base_url('facturier-historique-pv') ?>">Historique</a></li>
                                  </ul>
                                </li>

                              </ul>
                          </li>
                        <?php endif; ?>

                  </ul>
              </li>
              <?php if(session('accessDroit')['g_systeme'] == 1): ?>
                <li>
                  <a href="<?=base_url('facturier-config-system') ?>">
                    <i class="mdi mdi-chart-areaspline"></i><span>C-Système</span>
                  </a>
                </li>
              <?php endif; ?>
              <!-- <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>Rapport</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                    <li><a href="chart-chartistjs.html">Journalier</a></li>
                    <li><a href="chart-chartistjs.html">Mensuel</a></li>
                      <li><a href="chart-chartistjs.html">Annuel</a></li>

                  </ul>
              </li> -->
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
                    <?php if(session('accessDroit')['g_achat_partiels'] == 1): ?>
                      <li><a href="<?=base_url('magaz-list-achat-partiel') ?>">Mes Achats Partiels</a></li>
                    <?php endif; ?>
                    <?php //if(session('lieuAffectation')->is_central == 1):  ?>
                    <!-- <li><a href="<?=base_url('magaz-list-achat-faveur') ?>">Mes Achats Faveurs</a></li> -->
                    <?php //endif; ?>
                    <li><a href="<?=base_url('magaz-list-achat-a-retirer') ?>">Mes Achats à rétirer</a></li>


                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Stock</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">
                    <li><a href="<?=base_url('magaz-stock') ?>">Mon stock</a></li>
                    <li><a href="<?=base_url('magaz-stock-perso') ?>">Mon stock Personnel</a></li>
                    <?php if(session('accessDroit')['g_pv'] == 1): ?>
                      <!-- <li><a href="<?=base_url('magaz-stock-pv') ?>">PV Stock</a></li> -->
                      <li>
                          <a href="javaScript:void();">
                              <span>G-PV</span><i class="mdi mdi-chevron-right pull-right"></i>
                          </a>
                          <ul class="xp-vertical-submenu">
                            <li><a href="<?=base_url('magaz-stock-pv') ?>">PV Stock</a></li>
                            <li>
                              <a href="javaScript:void();">
                                  <span>PV Perdue</span><i class="mdi mdi-chevron-right pull-right"></i>
                              </a>
                              <ul class="xp-vertical-submenu">
                                <li><a href="<?=base_url('magaz-add-pv-historique') ?>">Créer</a></li>
                                <li><a href="<?=base_url('magaz-historique-pv') ?>">Historique</a></li>
                              </ul>
                            </li>

                          </ul>
                      </li>
                    <?php endif; ?>
                  </ul>
              </li>
              <li>
                  <a href="javaScript:void();">
                      <i class="mdi mdi-chart-areaspline"></i><span>G-Approvisionnement</span><i class="mdi mdi-chevron-right pull-right"></i>
                  </a>
                  <ul class="xp-vertical-submenu">

                      <li>
                          <a href="javaScript:void();">
                              <span>Appro Général</span><i class="mdi mdi-chevron-right pull-right"></i>
                          </a>
                          <ul class="xp-vertical-submenu">
                            <li><a href="<?=base_url('magaz-add-appro') ?>">Créer</a></li>
                            <li><a href="<?=base_url('magaz-histo-appro') ?>">Historique</a></li>
                          </ul>
                      </li>
                      <li>
                        <a href="javaScript:void();">
                            <span>Inter-Dépôt</span><i class="mdi mdi-chevron-right pull-right"></i>
                        </a>
                        <ul class="xp-vertical-submenu">
                            <li><a href="<?=base_url('magaz-add-appro-to-depot') ?>">Créer</a></li>
                            <li><a href="<?=base_url('magaz-histo-appro-inter-depot') ?>">Historique</a></li>
                        </ul>
                      </li>
                      <li>
                        <a href="javaScript:void();">
                            <span>Transferts</span><i class="mdi mdi-chevron-right pull-right"></i>
                        </a>
                        <ul class="xp-vertical-submenu">
                            <li><a href="<?=base_url('magaz-add-transfert-to-magaz') ?>">Créer</a></li>
                            <li><a href="<?=base_url('magaz-histo-transfert-to-magaz') ?>">Historique</a></li>
                        </ul>
                      </li>
                  </ul>

              </li>
              <?php if(session('accessDroit')['g_systeme'] == 1): ?>
                <li>
                  <a href="<?=base_url('magaz-config-system') ?>">
                    <i class="mdi mdi-chart-areaspline"></i><span>C-Système</span>
                  </a>
                </li>
              <?php endif; ?>
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
