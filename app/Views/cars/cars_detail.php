<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page ted-col-desk-normal-2-c4-c1 u-tab-norm-desk-take-grid">
    <section class="property-detail-cars ted-col ted-col-tab-por-1 u-animation-FromLeft">
      <div v-if="DataProperties.length > 0" class="card ted-col ted-col-mob-1 ted-col-tab-por-1 u-padding-bottom-5x">
        <div class="card__image ted-col">
				<div class="ted-col ted-col-mob-2-c3-c1 ted-col-tab-por-2-c3-c1 ted-col-tab-land-2-c3-c1">
					<h3>{{ DataProperties[0].mark }}</h3>
					<span class="title_secondary u-content-self-to-right-grid">{{DataProperties[0].price}} Rwf</span>
				</div>
					<div class="">
						<img :src="'<?=base_url() ?>/uploads/images/'+DataProperties[0].logic_main_image.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
					</div>
        </div>
        <div class="card__other-images ted-col ted-col-mob-3 ted-col-tab-por-3 ted-col-tab-land-4 ted-col-e-3 u-margin-top-6x u-change-norm-desk-grid-to-flex u-change-norm-desk-grid-to-flex-u-scroll">
          <img v-for="(img, index) in DataProperties[0].logic_list_image" :src="'<?=base_url() ?>/uploads/images/'+img.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img u-change-norm-desk-grid-to-flex-u-scroll__element">
        </div>
        <div class="card__detail ted-col ted-col-mob-2-c3-c1 ted-col-tab-por-2-c3-c1 u-margin-top-6x">
          <div class="card__detail__left ted-col ted-col-mob-4 ted-col-tab-por-4">
            <h4 class="u-grid-1-1-area">{{ DataProperties[0].mark }}</h4>
            <div class="card__detail__left__1 u-content-vertical">
              <span class="card__detail__left--title-detail-text">Mark: {{DataProperties[0].mark}} </span>
							<span class="card__detail__left--title-detail-text">Year : {{DataProperties[0].annee_fabrication}}</span>
              <span class="card__detail__left--title-detail-text">Mileage : {{DataProperties[0].kilometrage}}</span>
            </div>
						<div class="card__detail__left__1 u-content-vertical">
              <span class="card__detail__left--title-detail-text">Fuel: {{DataProperties[0].fuel}} </span>
							<span class="card__detail__left--title-detail-text">Steeling : {{DataProperties[0].steeling}}</span>
              <span class="card__detail__left--title-detail-text">Transmission : {{DataProperties[0].transimission}}</span>
            </div>
						<div class="card__detail__left__1 u-content-vertical">
              <span class="card__detail__left--title-detail-text">Ext Color: {{DataProperties[0].coleur}} </span>
							<span class="card__detail__left--title-detail-text">Engine Size : {{DataProperties[0].engine_size}}</span>
              <span class="card__detail__left--title-detail-text">Doors : {{DataProperties[0].doors}}</span>
            </div>
						<div class="card__detail__left__1 u-content-vertical">
              <span class="card__detail__left--title-detail-text">Seats: {{DataProperties[0].coleur}} </span>
							<span class="card__detail__left--title-detail-text">Engine Size : {{DataProperties[0].seating}}</span>
              <span class="card__detail__left--title-detail-text">Moteur : {{DataProperties[0].moteur}}</span>
            </div>

          </div>
          <div class="card__detail__right u-content-vertical u-content-vertical__align-right u-content-vertical__align-space-between">
            <span class="card__detail__right--price">{{DataProperties[0].price}} Frw</span>
            <a href="/cart" class="btn btn-secondary btn-size-tab-land-2">Add to carts</a>
          </div>
        </div>
      </div>
    </section>
    <!-- SIMILAR ITEM PROPERTIES -->

    <section class="poperty-similaire u-margin-top-6x u-animation-FromRight">
      <h3 class="title_secondary u-margin-left-5x u-hidden-norm-desk">Similar items</h3>
      <div v-if="DataSimulaire.length > 0" class="u-scroll-horizontal u-scroll-horizontal__property">
        <a v-for="(sim, index) in DataSimulaire[0]" :href="'<?=isLoggedIn() ? base_url('admin-cars-detail.dy/'):base_url('cars-detail') ?>/'+ sim.id" class="card ted-col ted-col-mob-1 u-padding-bottom-5x">
          <div class="card__image card__image__height-size__similar">
            <img :src="'<?=base_url() ?>/uploads/images/'+sim.logic_main_image.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
          </div>
          <div class="card__detail ted-col ted-col-desk-normal-2">
            <div class="card__detail__left u-content-vertical">
              <span class="card__detail__left--title-01__item">{{sim.mark}} </span>
            </div>
            <div class="card__detail__right u-content-vertical u-content-vertical__align-right">
              <span class="card__detail__right--price">{{sim.price}} Frw</span>
              <button href="#" class="btn btn-secondary ">Add to cart</button>
            </div>
          </div>
        </a>

      </div>
    </section>
  </main>
<?=$this->endSection() ?>
