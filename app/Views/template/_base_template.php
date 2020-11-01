<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=devide-width, initial-scale=1, shrink-to-fit=no">
    <script type="text/javascript" src="<?=base_url() ?>/lib/vue.js"></script>
    <script type="text/javascript" src="<?=base_url() ?>/lib/axios.min.js"></script>
    <script type="text/javascript" src="<?=base_url() ?>/vue/main.js" defer></script>
    <link rel="stylesheet" href="<?=base_url() ?>/icons/icon-font-basic.css">
    <link rel="stylesheet" href="<?=base_url() ?>/icons/icon-font-arrows.css">
    <link rel="stylesheet" href="<?=base_url() ?>/stylesheets/main.css">
    <link rel="stylesheet" href="<?=base_url() ?>/lib/trumbowyg/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="<?=base_url() ?>/lib/datepicker/css/bootstrap-datepicker.standalone.css">

    <title>BYOSEMARKET : <?=$this->renderSection('title') ?></title>
  </head>
  <body>
    <div id = "app">
        <!-- MENU RESPONSIVE -->
        <?=$this->include('partials/_menu_main') ?>
        <!-- FIN MENU RESPONSIVE -->
        <?=$this->renderSection('content') ?>
        <!-- FOOTER -->
        <?=$this->include('partials/_footer_main') ?>
        <!-- FIN FOOTER -->

        <!-- POPUP MESSAGE ERREUR ET SUCCESS -->
        <div v-if="errorPopup" :class="errorPopupClass">
          <div class="popup__header ted-col ted-col-tab-land-2-c7-c1">
            <span class="popup__header--title">{{errorPopupConfig.title}}</span>
            <span class="icon u-content-self-to-right-grid" data-icon="&#xe04a;" @click="errorPopup=!errorPopup"></span>
          </div>
          <div class="popup__content">
            <p v-if="errorPopupConfig.message[0].length ==1">{{errorPopupConfig.message[0][0]}}</p>

            <p v-if="errorPopupConfig.message[0].length >1" v-for="(err, index) in errorPopupConfig.message[0]">{{errorPopupConfig.message[0][index]}}</p>
          </div>
          <!-- <div class="popup__footer">
            <button type="button" name="close"></button>
          </div> -->
        </div>
    </div>

  </body>
  <script src="<?=base_url() ?>/lib/jquery.min.js"></script>
  <script src="<?=base_url() ?>/lib/trumbowyg/dist/trumbowyg.min.js"></script>
  <script src="<?=base_url() ?>/lib/datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="<?=base_url() ?>/vue/others.js" defer></script>
</html>
