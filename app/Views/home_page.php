<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
	<main class="u-animation-FromBottom">
		<section class="section-image-home">
			<div class="imageFrontPage">
				<span class="imageFrontPage__text">Nice copy should be placed here</span>
				<div class="imageFrontPage__box">
				</div>
			</div>
			<!-- FORMULAIRE DE RECHERCHE, DE FILTRE -->
			<div class="formulaire-home">
					<form class="ted-col ted-col-e-1 form formulaire-home__form" action="index.html" method="post">
						<div class="ted-col ted-col-mob-2-c2-c1 ted-col-tab-por-2-c2-c1">
							<div class="form__group">
								<input type="text" name="" value="" class="form-input form__group-control" placeholder="Search Adress District Cell Village">
							</div>
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Service Type</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
								</select>
							</div>
						</div>

						<div class="ted-col ted-col-mob-3 ted-col-tab-por-3">
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Property Type</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
								</select>
							</div>
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Number of property</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
								</select>
							</div>
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Mode of payment</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
								</select>
							</div>
						</div>
						<div class="ted-col ted-col-mob-3 ted-col-tab-por-3">
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Min Price</option>
									<option value="">10FRw</option>
									<option value="">20FRw</option>
									<option value="">30FRw</option>
								</select>
							</div>
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Max Price</option>
									<option value="">10FRw</option>
									<option value="">10FRw</option>
									<option value="">10FRw</option>
								</select>
							</div>
							<div class="form__group">
								<select class="form-input-select form__group-select" name="">
									<option value="" disabled selected hidden>Model</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
									<option value="">Teddy</option>
								</select>
							</div>
						</div>
						<div class="ted-col ted-col-mob-2-c2-c1 ted-col-tab-por-2-c2-c1">
							<div class="form__group">
								<input type="text" name="" value="" class="form-input form__group-control" placeholder="Additionnal information">
							</div>
							<div class="form__group">
								<button type="button" name="button" class="btn btn-secondary">Search</button>
							</div>
						</div>
					</form>
			</div>
		</section>
		<section class="section-category ted-col ted-col-tab-por-2 ted-col-tab-land-3 ted-col-desk-normal-auto-fit">
			<a href="<?=route_to('property') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMarketProperties.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<h3 class="title_tertiary card__title">Properties</h3>
			</a>
			<a href="<?=route_to('cars') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_CarLiSting.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<h3 class="title_tertiary card__title">Cars Rentals</h3>
			</a>
			<a href="<?=route_to('tenders') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_TeNdErz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<h3 class="title_tertiary card__title">Tenders</h3>
			</a>
			<a href="#" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_AuCtiOnz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<h3 class="title_tertiary card__title">Actions</h3>
			</a>
			<a href="<?=route_to('jobs') ?>" class="card card__margin ted-col ted-col-mob-2-c2-c1">
				<div class="card__image">
					<img src="uploads/file_static/ByOseMaRkEt_HoMePge_JoBz.png" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
				</div>
				<h3 class="title_tertiary card__title">Jobs Search</h3>
			</a>
		</section>
	</main>
<?=$this->endSection() ?>
