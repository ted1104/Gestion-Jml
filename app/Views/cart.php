<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page ted-col ted-col-desk-normal-2-c3-c1 u-animation-FromBottom">
    <section class="property-cars ted-col ted-col-tab-land-2 ted-col-desk-normal-2">
      <?php foreach ($items_list as $value): ?>
      <div class="card ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2 u-padding-bottom-5x">
        <div class="card__image">
          <img src="uploads/file_static/<?= $value['img'] ?>.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
        </div>
        <div class="card__detail ted-col ted-col-mob-2 ted-col-tab-por-2-c2-c1 u-margin-top-5x">
          <div class="card__detail__left u-content-vertical">
            <span class="card__detail__left--title-01 u-font-size-mob"><?= $value['tile'] ?> </span>
            <span class="card__detail__left--title-02 u-font-size-mob">Kigali</span>
            <span class="card__detail__left--title-03 u-font-size-mob">16/09/2020</span>
          </div>
          <div class="card__detail__right u-content-vertical__align-right u-content-vertical__align-space-between">
            <span class="card__detail__right--price"><?= $value['prix'] ?> Frw</span>
            <button href="#" class="btn btn-dark u-margin-bottom-2x">Save for later</button>
            <button href="#" class="btn btn-secondary">Call for visit</button>
          </div>
        </div>
      </div>
      <?php endForeach; ?>
    </section>

    <section class="form-payement">
      <form class="ted-col ted-col-e-1 form u-margin-top-5x" action="index.html" method="post">
        <div class="ted-col ted-col-mob-2 ted-col-tab-por-2">
          <div class="form__group">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Your Name">
          </div>
          <div class="form__group">
            <select class="form-input-select form__group-select" name="">
              <option value="" disabled selected hidden>Pay with</option>
              <option value="">Master Card</option>
              <option value="">Visa Card</option>
              <option value="">Paypal</option>
            </select>
          </div>
        </div>

        <div class="ted-col ted-col-mob-2 ted-col-tab-por-2">
          <div class="form__group">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Your Email">
          </div>
          <div class="form__group">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Card Number">
          </div>
        </div>
        <div class="ted-col ted-col-mob-2 ted-col-tab-por-2">
          <div class="form__group">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Your phone Number">
          </div>
          <div class="form__group ted-col ted-col-mob-2 ted-col-tab-por-2">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Expiration date">
            <div class="form__group">
              <input type="text" name="" value="" class="form-input form__group-control" placeholder="Security Code">
            </div>
          </div>
        </div>
        <div class="ted-col ted-col-mob-2 ted-col-tab-por-2">
          <div class="form__group">
            <select class="form-input-select form__group-select" name="">
              <option value="" disabled selected hidden>Bank Card</option>
              <option value="">Visa</option>
              <option value="">Master card</option>
              <option value="">USA Card</option>
            </select>
          </div>
          <div class="form__group">
            <input type="text" name="" value="" class="form-input form__group-control" placeholder="Your name on others cards">
          </div>
        </div>
        <div class="ted-col ted-col-mob-2 ted-col-tab-por-2 ted-col-e-2">
          <div class="form__group ted-col u-postion-relative">
            <label class="ted-col" data-text="i.e to remember this card on the next operation"><input type="checkbox" value="" class=""> <span class="u-font-size-mob u-font-size-tab-por">Remember this card</span></label>
          </div>
          <div class="form__group ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2">
            <button type="button" name="button" class="btn btn-secondary">Approvement</button>
            <button type="button" name="button" class="btn btn-default">Cancel</button>
          </div>

        </div>
      </form>
    </section>
  </main>
<?=$this->endSection() ?>
