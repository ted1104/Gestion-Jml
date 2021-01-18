<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>

  <div class="xp-authenticate-bg"></div>
  <!-- Start XP Container -->
  <div id="xp-container" class="xp-container">
      <!-- Start Container -->
      <div class="container">
          <!-- Start XP Row -->
          <div class="row vh-100 align-items-center">
              <!-- Start XP Col -->
              <div class="col-lg-12 ">
                  <!-- Start XP Auth Box -->
                  <div class="xp-auth-box">
                      <div class="card">
                          <div class="card-body">
                              <h3 class="text-center">
                                  <a href="<?=base_url() ?>" class="xp-web-logo"><img src="<?=base_url() ?>/public/assets/images/logo.jpg" height="40" alt="logo"></a>
                              </h3>
															<div class="text-center">
																<span >Version : 1.0</span>
																<?=$_SERVER['SERVER_NAME'] ?>
															</div>
                              <div class="p-3">
                                  <form action="<?=base_url('login') ?>" autocomplete="off" method="POST">
																			<?=csrf_field()?>
                                      <div class="text-center mb-3">
                                          <h4 class="text-black">Se Connecter !</h4>
                                      </div>
                                      <div class="form-group">
                                          <input type="text" class="form-control" name="username" placeholder="Nom utilisateur" required value=<?=old('username') ?>>
                                      </div>
                                      <div class="form-group">
                                          <input type="password" class="form-control" name="password_main" placeholder="Mot de passe" required>
                                      </div>
                                      <div class="form-row">
                                          <div class="form-group col-6">
                                              <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                                <label class="custom-control-label" for="rememberme">Se souvenir de moi</label>
                                              </div>
                                          </div>
                                          <!-- <div class="form-group col-6 text-right">
                                            <label class="forgot-psw">
                                              <a id="forgot-psw" href="#">Forgot Password?</a>
                                            </label>
                                          </div> -->
                                      </div>
                                    <button type="submit" class="btn btn-primary btn-rounded btn-lg btn-block">Connexion</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- End XP Auth Box -->
              </div>
              <!-- End XP Col -->
          </div>
          <!-- End XP Row -->
    </div>
    <!-- End Container -->
</div>
<?=$this->endSection() ?>
