<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
	<main class="">
    <section class="section-category ted-col ted-col-tab-por-2 ted-col-tab-land-3 ted-col-desk-normal-auto-fit">
			<a href="<?=base_url('admin-property.dy') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMarketProperties.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<span class="title_tertiary card__title u-font-size-3x">Properties</span>
        <span class="title_default card__title u-font-size-2x">Range of our tarif</span>
			</a>
			<a href="<?=base_url('admin-cars.dy') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_CarLiSting.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<span class="title_tertiary card__title u-font-size-3x">Cars Rentals</span>
        <span class="title_default card__title u-font-size-2x">Range of our tarif</span>
			</a>
			<a href="<?=base_url('admin-tenders.dy') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_TeNdErz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<span class="title_tertiary card__title u-font-size-3x">Tenders</span>
        <span class="title_default card__title u-font-size-2x">Range of our tarif</span>
			</a>
			<a href="<?=base_url('admin-auctions.dy') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_AuCtiOnz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<span class="title_tertiary card__title u-font-size-3x">Auctions</span>
        <span class="title_default card__title u-font-size-2x">Range of our tarif</span>
			</a>
			<a href="<?=base_url('admin-jobs.dy') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_JoBz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<span class="title_tertiary card__title u-font-size-3x">Jobs Search</span>
        <span class="title_default card__title u-font-size-2x">Range of our tarif</span>
			</a>
		</section>
	</main>
<?=$this->endSection() ?>
