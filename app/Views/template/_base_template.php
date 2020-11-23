<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="description" content="Booster is a bootstrap & laravel admin dashboard template">
    <meta name="keywords" content="admin, admin dashboard, admin panel, admin template, admin theme, bootstrap 4, laravel, crm, analytics, responsive, sass support, ui kits, web app, clean design, creative">
    <meta name="author" content="Themesbox17"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>GESTION BOUTIQUE : <?=$this->renderSection('title') ?> </title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?=base_url() ?>/assets/images/favicon.ico">
    <!-- Start CSS -->
    <link href="<?=base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/css/monstyle.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?=base_url() ?>/vue/others.js" defer></script>
    <script type="text/javascript" src="<?=base_url() ?>/lib/vue.js" async></script>
    <script type="text/javascript" src="<?=base_url() ?>/lib/axios.min.js" async></script>
    <script type="text/javascript" src="<?=base_url() ?>/vue/main.js" defer></script>


    <!-- End CSS -->
  </head>

  <body class="xp-vertical">
    <div class="container-main-admin" style="z-index:-100" id="app" @click="_u_fx_bodyClicked">
      <?=$this->renderSection('content') ?>



        <?php if(session()->getFlashData('message')): ?>
        <div class="message-alert u-animation-FromTop">
        <div class="xp-alert">
              <div class="alert <?=session()->getFlashData('message')['color'] ?>" role="alert">
                <h6 class="alert-heading"><?=session()->getFlashData('message')['title'] ?></h6>
                <hr>
                <p><?=session()->getFlashData('message')['content'] ?></p>
              </div>
          </div>
        </div>
        <?php endif; ?>
        <!-- ALERT POUR DB MESSAGE -->
        <div v-if="messageError" class="message-alert u-animation-FromTop" @click="messageError=!messageError">
        <div class="xp-alert">
              <div :class="errorPopupClass" role="alert">
                <div class="row">
                  <h6 class="alert-heading col-md-11">{{messageAlertConfig.title}}</h6>
                  <!-- <i class="mdi mdi-close col-md-1 cursor" @click="messageError=!messageError"></i> -->
                </div>
                <ul class="ul-error" v-if="messageAlertConfig.message[0].length ==1">
                  <li v-for="(err, index) in messageAlertConfig.message">{{err[index]}}</li>
                </ul>
                <ul class="ul-error" v-if="messageAlertConfig.message[0].length >1">
                  <li v-for="(err, index) in messageAlertConfig.message[0]">{{err}}</li>
                </ul>
              </div>
          </div>
        </div>

        <!-- ALERT BOTTOM POUR RECHERCHE MESSAGE -->
        <div v-if="messageErrorBottom" class="message-alert u-animation-FromBottom" style="width:20%;top:80%" @click="messageErrorBottom=!messageErrorBottom">
        <div class="xp-alert">
              <div :class="errorPopupClassBottom" role="alert">
                <div class="row">
                  <span class="col-md-10">{{messageAlertConfigBottom.title}}</span>
                  <!-- <i class="mdi mdi-close col-md-2 cursor" @click="messageErrorBottom=!messageErrorBottom"></i> -->
                </div>
                <span>{{messageAlertConfigBottom.message[0][0]}}</span>

              </div>
          </div>
        </div>

    </div>

    <!-- Start JS -->
    <script src="<?=base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?=base_url() ?>/assets/js/popper.min.js"></script>
    <script src="<?=base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url() ?>/assets/js/modernizr.min.js"></script>
    <script src="<?=base_url() ?>/assets/js/detect.js"></script>
    <script src="<?=base_url() ?>/assets/js/jquery.slimscroll.js"></script>
    <script src="<?=base_url() ?>/assets/js/sidebar-menu.js"></script>

    <!-- Main JS -->
    <script src="<?=base_url() ?>/assets/js/main.js"></script>
    <!-- End JS -->

    <script src="<?=base_url() ?>/lib/vuejs-datepicker.min.js"></script>

  </body>

</html>
