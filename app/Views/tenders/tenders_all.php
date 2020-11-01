<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page u-animation-FromBottom">

    <section class="tenders">

      <a v-for="(tender, index) in DataProperties" :href="'<?=isLoggedIn() ? base_url('admin-tenders-detail.dy'):base_url('tenders-detail') ?>/'+ tender.id" class="card ted-col ted-col-mob-2-c1-c3 ted-col-tab-por-2-c1-c3 ted-col-tab-land-2-c1-c6 ted-col-e-7 u-margin-bottom-6x">
        <div class="card__image">
          <img :src="'uploads/images/'+tender.logic_main_file.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
        </div>
        <div class="card__detail ">
          <div class="card__detail__left u-content-vertical">
            <span class="card__detail__left--title-01">{{tender.title}} </span>
            <span class="card__detail__left--title-02 u-color-red">{{tender.entreprise}}</span>
            <span class="card__detail__left--title-03 u-font-size-mob">Published {{tender.datapublished}}  | Deadline {{tender.deadline}}</span>
          </div>
        </div>
      </a>

    </section>
  </main>

	<!-- BOUTONS ADD -->
	<?php if(isLoggedIn()): ?>
		<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-2 u-position-screen-right-bottom" @click="changeModalState"><i :class="modalClassIcon" ></i></button>
	<?php endif; ?>

	<!-- MODAL AJOUT D'UNE MAISON -->
	<div class="modal" v-show="displayModal">
		<div class="modal-container modal__size-moyen u-animation-FromPointToGrand">
			<div class="modal-header ted-col ted-col-tab-land-2-c3-c1">
				<h3>ADD NEW TENDER</h3>
				<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-1 u-content-self-to-right-grid" @click="fx_showFormHouseData" ><i class="icon" data-icon="&#xe03b;"></i></button>
			</div>
			<div class="modal-body">
				<form class="ted-col ted-col-e-1 form u-margin-top-5x" autocomplete="off">
					<?=csrf_field()?>
						<div class="ted-col u-animation-CommingHiddenToVisibleOpacity" v-show="showFormHouseData">
							<h3>Tender Logo Company and file to upload</h3>
							<div class="ted-col ted-col-tab-land-2-c1-c2">
								<div class="form__group form__group-upload">
									<span class="u-margin-bottom-2x">Choose Tender Logo Image</span>
									<label for="input-file">
										<img :src="avatarMain" alt="File upload ByOseMarket" class="image_size_responsive card__image--img">
									</label>
									<input type="file" ref="file" id="input-file" accept="image/*" @change="fx_DisplayImageToUpload">
								</div>
								<div class="">
									 <div class="u-content-flex u-margin-bottom-2x">
											<span class="u-margin-right-2x">Upload Attachments</span>
											<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-0 " @click="fx_addOneImage"><i class="icon" data-icon="&#xe048;"></i></button>
										</div>
										<div class="ted-col ted-col-tab-land-4 ted-col-e-2">
											<div class="OneImage u-postion-relative" v-for="(img, index) in tabImageHouseUpload">
												<button type="button" name="button" class="btn-secondary btn-rond btn__carre-btn-0 top-right-element" @click="fx_removeSpecificImage(index)" v-if="tabImageHouseUpload.length >1"><i class="icon" data-icon="&#xe041;"></i></button>
												<label :for="index">
													<!-- {{tabImageHouseUpload[index][0]}} -->
													<img :src="tabImageHouseUpload[index][1]" alt="File upload ByOseMarket" class="image_size_manual-1 card__image--img">
												</label>
												<input type="file" :id="index" ref="input-file-other" accept="application/pdf,application/doc,application/docx,application/txt" @change="fx_DisplayImageToUploadOther">
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="ted-col u-animation-CommingHiddenToVisibleOpacity" v-show="!showFormHouseData">
							<h3>Tender Informations</h3>
							<div class="ted-col ted-col-tab-land-2">
								<div class="form__group">
									<label for="">Tender Title</label>
									<input type="text" v-model="title" class="form-input form__group-control" placeholder="Tender Title" tabindex="1">
								</div>
								<div class="form__group">
									<label for="">Entreprise Name</label>
									<input type="text" v-model="entreprise" class="form-input form__group-control" placeholder="Entreprise Name" tabindex="1">
								</div>
							</div>
							<div class="ted-col ted-col-tab-land-2" style="z-index:100">
								<div class="form__group">
									<label for="">Start Date</label>
									<div class="ted-col ted-col-tab-land-2-c1-c8">
										<span class="icon icon-arrows-squares u-content-self-justify-to-center-grid u-content-self-align-to-center-grid" id="datepicker-1" data-date="2020-11-02"></span>
										<input type="text" value="" class="form-input form__group-control" id="val-date-1">
									</div>
								</div>
								<div class="form__group">
									<label for="">End Date</label>
									<div class="ted-col ted-col-tab-land-2-c1-c8">
										<span class="icon icon-arrows-squares u-content-self-justify-to-center-grid u-content-self-align-to-center-grid" id="datepicker-2" data-date="2020-11-02"></span>
										<input type="text" value="" class="form-input form__group-control"  id="val-date-2">

									</div>
								</div>
							</div>
							<div class="ted-col" style="z-index:100">
								<div class="form__group">
									<label for="">Link to apply </label>
									<input type="text" v-model="linkapply" value="" class="form-input form__group-control">
								</div>
							</div>
							<div class="ted-col">
								<div class="form__group">
									<label for="">Description</label>
									<textarea id="editor"></textarea>
								</div>

							</div>
							<div class="ted-col ted-col-mob-1 ted-col-tab-por-1 u-margin-top-2x">
								<div class="ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2">
								<div>
									<button name="button" class="btn btn-secondary btn-size-tab-land-3" @click="create_tenders">Save</button>
								</div>
								</div>
							</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">

			</div>
		</div>

	</div>
<?=$this->endSection() ?>
