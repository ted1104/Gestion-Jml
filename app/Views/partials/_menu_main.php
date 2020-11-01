<!-- MENU MOBILE -->
<header class="header mobile-menu">
    <div class="header__box">
      <div class="header__box--logo">
        <a href="<?=base_url() ?>" class="image image-logo">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketLogo.png" alt="Logo ByOseMarket" class="image_size_responsive image__logo">
        </a>
      </div>
      <div class="header__box--searchbar">
        <form class="form" action="#" method="post">
          <div class="form__group-icon">
            <input type="search" name="search" value="">
            <i class="icon-basic-magnifier"></i>
          </div>
        </form>
      </div>
      <div class="header__box--iconmenu">
        <a href="/cart" class="image image--icon">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketPannier.png" alt="Shop ByOseMarket" class="image_size_responsive image__pannier">
          <span class="number_pannier">4</span>
        </a>
        <a href="#" class="image image--icon">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketMenu.png" alt="Menu ByOseMarket" class=" image_size_responsive image__menu">
        </a>
      </div>
    </div>
</header>

<!-- MENU ORDINATEUR -->
<header class="header ordinateur-menu">
    <div class="header__box">
      <div class="header__box--logo">
        <a href="<?=isLoggedIn() ? base_url('admin-home.dy'):base_url('/') ?>" class="image image-logo">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketLogo.png" alt="Logo ByOseMarket" class="image_size_responsive image__logo">
        </a>
      </div>
      <div class="header__box--navbar">
        <nav class="navbar" v-if="MenuShift">
          <ul class="navbar__ul">
            <li class="navbar__ul--li"><a class="navbar__ul--link active-link" href="<?=isLoggedIn() ? base_url('admin-home.dy'):base_url('/') ?>">Home</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=isLoggedIn() ? base_url('admin-property.dy'):base_url('property') ?>">Properties</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=isLoggedIn() ? base_url('admin-cars.dy'):base_url('cars') ?>">Cars Listing</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=isLoggedIn() ? base_url('admin-tenders.dy'):base_url('tenders') ?>">Tenders</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=isLoggedIn() ? base_url('admin-auctions.dy'):base_url('auctions') ?>">Auctions</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=isLoggedIn() ? base_url('admin-jobs.dy'):base_url('jobs') ?>">Jobs</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="#">Contact</a></li>
          </ul>
        </nav>
        <nav class="navbar" v-if="!MenuShift">
          <ul class="navbar__ul">
            <li class="navbar__ul--li"><a class="navbar__ul--link active-link" href="<?=isLoggedIn() ? base_url('admin-home.dy'):base_url('/') ?>">Home</a></li>
            <li class="navbar__ul--li">
              <a class="navbar__ul--link" href="<?=base_url('whoweare') ?>">Who we are</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="<?=base_url('whatWeDo')?>">What we do</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="#">Why doing business with us</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="#">Service Tarif</a></li>
            <li class="navbar__ul--li"><a class="navbar__ul--link" href="#">Team of experts</a></li>

          </ul>
        </nav>
      </div>
      <div class="header__box--iconmenu">
        <a href="/cart" class="image image--icon header__box--iconmenu-1">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketPannier.png" alt="Shop ByOseMarket" class="image_size_responsive image__pannier">
          <span class="number_pannier">4</span>
        </a>
        <form class="form header__box--iconmenu-2" action="#" method="post">
          <div class="form__group">
            <input type="search" name="" value="" class="form-input" placeholder="Search">
          </div>
        </form>
        <a div class="image image--icon header__box--iconmenu-3">
          <img src="<?=base_url() ?>/uploads/file_static/ByOseMarketMenu.png" alt="Menu ByOseMarket" class="image_size_responsive u-cursor-pointer" @click="_u_shift_menu">
          <a href="<?=isLoggedIn() ? base_url('admin-logout.dy'):base_url('login.dy') ?>"><?=isLoggedIn() ?'Logout':'Login' ?></a>
        </a>
      </div>
    </div>
</header>
