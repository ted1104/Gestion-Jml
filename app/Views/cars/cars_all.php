<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page u-animation-FromBottom">
    <section class="property-cars ted-col ted-col-tab-por-2 ted-col-tab-land-3 ted-col-desk-normal-5 ted-col-e-10 ">

			<?=$this->include('partials/_sq_list_all') ?>

			<!-- cars LIST -->
      <a v-for = "(cars, index) in DataProperties" :href="'<?=isLoggedIn() ? base_url('admin-cars-detail.dy'):base_url('cars-detail') ?>/'+ cars.id" class="card ted-col ted-col-mob-1 u-padding-bottom-5x">
        <div class="card__image">
          <img :src="'uploads/images/'+cars.logic_main_image.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
        </div>
        <div class="card__detail ted-col ted-col-mob-2 ted-col-tab-por-2-c2-c1 u-margin-top-5x">
          <div class="card__detail__left u-content-vertical">
            <span class="card__detail__left--title-01">
							{{cars.mark}}
						</span>
            <span class="card__detail__left--title-02">{{cars.annee_fabrication+' | '+cars.engine_size+ ' | '+cars.doors+' Door(s)'}}</span>
            <span class="card__detail__left--title-03">{{cars.steeling}}</span>
          </div>
          <div class="card__detail__right u-content-vertical u-content-vertical__align-right u-content-vertical__align-space-between">
            <span class="card__detail__right--price"> {{cars.price}} Frw</span>
            <button href="#" class="btn btn-secondary"><?=$button ?></button>
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
	<div class="modal" v-if="displayModal">
		<div class="modal-container modal__size-moyen u-animation-FromPointToGrand">
			<div class="modal-header ted-col ted-col-tab-land-2-c3-c1">
				<h3>ADD NEW CAR</h3>
				<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-1 u-content-self-to-right-grid" @click="fx_showFormHouseData" ><i class="icon" data-icon="&#xe03b;"></i></button>
			</div>
			<div class="modal-body">
				<form class="ted-col ted-col-e-1 form u-margin-top-5x" autocomplete="off">
					<?=csrf_field()?>
						<div class="ted-col u-animation-CommingHiddenToVisibleOpacity" v-if="showFormHouseData">
							<h3>Cars Images to upload</h3>
							<div class="ted-col ted-col-tab-land-2-c1-c2">
								<div class="form__group form__group-upload">
									<span class="u-margin-bottom-2x">Choose Main Image</span>
									<label for="input-file">
										<img :src="avatarMain" alt="File upload ByOseMarket" class="image_size_responsive card__image--img">
									</label>
									<input type="file" ref="file" id="input-file" accept="image/*" @change="fx_DisplayImageToUpload">
								</div>
								<div class="">
									 <div class="u-content-flex u-margin-bottom-2x">
											<span class="u-margin-right-2x">Choose Others Image</span>
											<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-0 " @click="fx_addOneImage"><i class="icon" data-icon="&#xe048;"></i></button>
										</div>
										<div class="ted-col ted-col-tab-land-4 ted-col-e-2">
											<div class="OneImage u-postion-relative" v-for="(img, index) in tabImageHouseUpload">
												<button type="button" name="button" class="btn-secondary btn-rond btn__carre-btn-0 top-right-element" @click="fx_removeSpecificImage(index)" v-if="tabImageHouseUpload.length >1"><i class="icon" data-icon="&#xe041;"></i></button>
												<label :for="index">
													<!-- {{tabImageHouseUpload[index][0]}} -->
													<img :src="tabImageHouseUpload[index][1]" alt="File upload ByOseMarket" class="image_size_manual-1 card__image--img">
												</label>
												<input type="file" :id="index" ref="input-file-other" accept="image/*" @change="fx_DisplayImageToUploadOther">
											</div>
										</div>
								</div>
							</div>
						</div>
						<div class="ted-col u-animation-CommingHiddenToVisibleOpacity" v-if="!showFormHouseData">
							<h3>Cars Informations</h3>
							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Mark</label>
				          <input type="text" v-model="mark" class="form-input form__group-control" placeholder="Mark" tabindex="1">
				        </div>
								<div class="form__group">
									<label for="">Year</label>
				          <input type="text" v-model="annee_fabrication" class="form-input form__group-control" placeholder="Year" tabindex="1">
				        </div>
								<div class="form__group">
									<label for="">Mileage</label>
				          <input type="text" v-model="kilometrage" class="form-input form__group-control" placeholder="Mileage" tabindex="1">
				        </div>
								<div class="form__group">
									<label for="">Fuel</label>
									<select class="form-input-select form__group-select" v-model="fuel">
										<option value="1">Essence</option>
										<option value="2">Mazout</option>
			            </select>
								</div>
							</div>
				      <div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Steeling</label>
									<select class="form-input-select form__group-select" v-model="steeling">
										<option value="1">Right</option>
			              <option value="2">Left</option>
			            </select>
								</div>
								<div class="form__group">
									<label for="">Transmission</label>
									<select class="form-input-select form__group-select" v-model="transimission">
										<option value="1">Automatic</option>
			              <option value="2">Manual</option>
			            </select>
								</div>
								<div class="form__group">
									<label for="">Ext Color</label>
				          <input type="text" v-model="coleur" class="form-input form__group-control" placeholder="Ext Color">
				        </div>
								<div class="form__group">
									<label for="">Engine size</label>
				          <input type="text" v-model="engine_size" value="" class="form-input form__group-control" placeholder="Engine Size : Ex 2.790">
				        </div>
				      </div>

							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Doors</label>
				          <input type="text" v-model="doors" class="form-input form__group-control" placeholder="Doors">
				        </div>
								<div class="form__group">
									<label for="">Seats</label>
				          <input type="text" v-model="seating" class="form-input form__group-control" placeholder="Seats">
				        </div>
								<div class="form__group">
									<label for="">Type Moteur</label>
				          <input type="text" v-model="moteur" value="" class="form-input form__group-control" placeholder="Type Moteur">
				        </div>
								<div class="form__group">
									<label for="">Price</label>
				          <input type="text" v-model="price" value="" class="form-input form__group-control" placeholder="Price">
				        </div>
							</div>
				      <div class="ted-col ted-col-mob-1 ted-col-tab-por-1 u-margin-top-2x">
				        <div class="ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2">
				        <div>
				          <button name="button" class="btn btn-secondary btn-size-tab-land-3" @click="create_cars">Save</button>
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
