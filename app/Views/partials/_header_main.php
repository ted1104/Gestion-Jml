<input type="hidden" value="<?=session('users')['info'][0]->id ?>" id="user">
<input type="hidden" value="<?=session('users')['info'][0]->depot_id ?>" id="depot_user">
<!-- Start XP Topbar -->
<div class="xp-topbar">

    <!-- Start XP Row -->
    <div class="row">

        <!-- Start XP Col -->
        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
            <div class="xp-menubar">
                <a class="xp-menu-hamburger" href="javascript:void();">
                   <i class="mdi mdi-sort-variant font-24 text-white"></i>
                 </a>
             </div>
        </div>
        <!-- End XP Col -->

        <!-- Start XP Col -->
        <div class="col-md-5 col-lg-3 order-3 order-md-2">
            <div class="xp-searchbar">
                <form>
                    <div class="input-group">
                      <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                      <div class="input-group-append">
                        <button class="btn" type="submit" id="button-addon2">GO</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End XP Col -->

        <!-- Start XP Col -->
        <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
            <div class="xp-profilebar text-right">
                <ul class="list-inline mb-0">

                    <li class="list-inline-item">
                        <div class="dropdown xp-notification mr-3">
                          <a class="dropdown-toggle user-profile-img text-white" href="http://169.255.189.89:8090/" target="_blank" role="button" id="xp-notification">
                              <i class="mdi mdi-camera font-25 v-a-m"></i>
                          </a>
                          <a class="dropdown-toggle user-profile-img text-white" href="https://webmail1.hostinger.com/" target="_blank" role="button" id="xp-notification">
                              <i class="mdi mdi-email font-25 v-a-m"></i>
                          </a>


                            <?php if(session('users')['info'][0]->roles_id == 3 OR session('users')['info'][0]->roles_id == 1): ?>
                              <a class="dropdown-toggle user-profile-img text-white" href="#" role="button" id="xp-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="mdi mdi-currency-usd font-25 v-a-m"></i>
                              </a>
                            <?php endif; ?>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-notification">
                                <ul class="list-unstyled">
                                  <li class="media">
                                    <div class="media-body">
                                      <h5 class="mt-0 mb-0 my-3 text-dark text-center font-15">MON SOLDE</h5>
                                    </div>
                                  </li>
                                  <li class="media xp-noti">
                                    <div class="mr-3 xp-noti-icon"><i class="mdi mdi-currency-usd"></i></div>
                                    <div class="padding-top-5">
                                        <h3 class="font-18">{{montantCaisse}} USD</h3>
                                    </div>
                                  </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-inline-item mr-0">
                        <div class="dropdown xp-userprofile">
                            <a class="dropdown-toggle user-profile-img" href="#" role="button" id="xp-userprofile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?=base_url() ?>/public/uploads/profiles/<?=session('users')['info'][0]->photo ?>" alt="user-profile" class="rounded-circle img-fluid" style="width:50px !important; height:50px !important"><span class="xp-user-live"></span></a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="xp-userprofile">
                                <a class="dropdown-item" href="#">Bienvenu, <?=session('users')['info'][0]->nom.' '.session('users')['info'][0]->prenom ?></a>
                                <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-account mr-2"></i> Profile</a> -->
                                <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-credit-card mr-2"></i> Billing</a> -->
                                <a class="dropdown-item" href="<?=base_url('config-pass-profile') ?>"><i class="mdi mdi-account mr-2"></i> Mon compte</a>
                                <!-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock mr-2"></i> Lock Screen</a> -->
                                <a class="dropdown-item" href="<?=base_url('logout') ?>"><i class="mdi mdi-logout mr-2"></i> Deconnexion</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End XP Col -->

    </div>
    <!-- End XP Row -->

</div>
<!-- End XP Topbar -->
