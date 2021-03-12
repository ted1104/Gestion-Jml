<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="JML System">
    <!-- <meta name="keywords" content="admin, admin dashboard, admin panel, admin template, admin theme, bootstrap 4, laravel, crm, analytics, responsive, sass support, ui kits, web app, clean design, creative">
    <meta name="author" content="Themesbox17"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>JML : <?=$this->renderSection('title') ?> </title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="<?=base_url() ?>/public/assets/images/logo.ico">
    <!-- Start CSS -->
    <link href="<?=base_url() ?>/public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/public/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/public/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/public/css/monstyle.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url() ?>/public/assets/plugins/animate/animate.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?=base_url() ?>/public/vue/others.js" defer></script>
    <script type="text/javascript" src="<?=base_url() ?>/public/lib/vue.js" defer></script>
    <script type="text/javascript" src="<?=base_url() ?>/public/lib/axios.min.js" defer></script>
    <script type="text/javascript" src="<?=base_url() ?>/public/vue/main.js" defer></script>


    <!-- End CSS -->
  </head>

  <body class="xp-vertical">
    <div class="container-main-admin" style="z-index:-100" id="app" @click="_u_fx_bodyClicked">
      <?=$this->renderSection('content') ?>



        <?php if(session()->getFlashData('message')): ?>
        <div class="message-alert u-animation-FromTop cursor-div" v-if="isShowLoginMessage" @click="isShowLoginMessage=false">
        <div class="xp-alert">
              <div class="alert <?=session()->getFlashData('message')['color'] ?>" role="alert">
                <div class="row">
                  <div class="col-md-11">
                    <h6 class="alert-heading"><?=session()->getFlashData('message')['title'] ?></h6>
                  </div>
                  <div class="col-md-1">
                    <span @click="isShowLoginMessage=false"> <i class="mdi mdi-close"></i></span>
                  </div>
                </div>

                <hr>
                <p><?=session()->getFlashData('message')['content'] ?></p>
              </div>
          </div>
        </div>
        <?php endif; ?>
        <!-- ALERT POUR DB MESSAGE -->
        <div v-if="messageError" class="message-alert u-animation-FromTop cursor-div" @click="messageError=false">
        <div class="xp-alert">
              <div :class="errorPopupClass" role="alert">
                <div class="row">
                    <div class="col-md-11">
                        <h6 class="alert-heading">{{messageAlertConfig.title}}</h6>
                    </div>
                    <div class="col-md-1">
                      <span @click="messageError=false"> <i class="mdi mdi-close"></i></span>
                    </div>
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
        <div v-if="messageErrorBottom" class="message-alert u-animation-FromBottom cursor-div" style="width:20%;top:80%" @click="messageErrorBottom=false">
        <div class="xp-alert">
              <div :class="errorPopupClassBottom" role="alert">
                <div class="row">
                  <div class="col-md-10">
                    <span class="">{{messageAlertConfigBottom.title}}</span>
                  </div>
                  <div class="col-md-1">
                    <span @click="messageErrorBottom=false"> <i class="mdi mdi-close"></i></span>
                  </div>
                  <!-- <span class="col-md-10">{{messageAlertConfigBottom.title}}</span> -->
                  <!-- <i class="mdi mdi-close col-md-2 cursor" @click="messageErrorBottom=!messageErrorBottom"></i> -->
                </div>
                <span>{{messageAlertConfigBottom.message[0][0]}}</span>

              </div>
          </div>
        </div>

    </div>

    <!-- Start JS -->
    <script src="<?=base_url() ?>/public/assets/js/jquery.min.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/popper.min.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/modernizr.min.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/detect.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/jquery.slimscroll.js"></script>
    <script src="<?=base_url() ?>/public/assets/js/sidebar-menu.js"></script>

    <!-- Main JS -->
    <script src="<?=base_url() ?>/public/assets/js/main.js"></script>
    <!-- End JS -->

    <script src="<?=base_url() ?>/public/lib/vuejs-datepicker.min.js"></script>

  </body>

</html>
