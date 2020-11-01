<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page u-animation-FromBottom">
    <section class="property-cars ted-col ted-col-tab-por-2 ted-col-tab-land-3 ted-col-desk-normal-5 ted-col-e-10 ">

			<?=$this->include('partials/_sq_list_all') ?>

			<!-- PROPERTIES LIST -->
      <a v-for = "(properties, index) in DataProperties" :href="'<?=isLoggedIn() ? base_url('admin-property-detail.dy/'):base_url('/property-detail') ?>/'+ properties.property.id" class="card ted-col ted-col-mob-1 u-padding-bottom-5x">
        <div class="card__image">
          <img :src="'uploads/images/'+properties.images.main.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
        </div>
        <div class="card__detail ted-col ted-col-mob-2 ted-col-tab-por-2-c2-c1 u-margin-top-5x">
          <div class="card__detail__left u-content-vertical">
            <span class="card__detail__left--title-01">
							{{ properties.property.fully==1 ?'Fully furnished house':'Fully unfurnished house'}}
						</span>
            <span class="card__detail__left--title-02">{{ properties.province.name +' '+properties.district.name +' '+properties.sector.name+' '+properties.cell.name }}</span>
            <span class="card__detail__left--title-03">Published {{properties.property.created_at.date}}</span>
          </div>
          <div class="card__detail__right u-content-vertical u-content-vertical__align-right u-content-vertical__align-space-between">
            <span class="card__detail__right--price"> {{properties.property.price}} Frw</span>
            <button href="#" class="btn btn-secondary"><?=$button ?></button>
          </div>
        </div>
      </a>

    </section>
  </main>



	<!-- BOUTONS ADD -->
	<?php if(isLoggedIn()): ?>
		<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-2 u-position-screen-right-bottom" @click="changeModalState"><i :class="modalClassIcon" ></i></button>


	<!-- MODAL AJOUT D'UNE MAISON -->
	<div class="modal" v-if="displayModal">
		<div class="modal-container modal__size-moyen u-animation-FromPointToGrand">
			<div class="modal-header ted-col ted-col-tab-land-2-c3-c1">
				<h3>ADD NEW PROPERTY</h3>
				<button type="button" name="button" class="btn-tertiary btn-rond btn__carre-btn-1 u-content-self-to-right-grid" @click="fx_showFormHouseData" ><i class="icon" data-icon="&#xe03b;"></i></button>
			</div>
			<div class="modal-body">
				<form class="ted-col ted-col-e-1 form u-margin-top-5x" autocomplete="off">
					<?=csrf_field()?>
						<div class="ted-col u-animation-CommingHiddenToVisibleOpacity" v-if="showFormHouseData">
							<h3>House Images to upload</h3>
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
							<h3>House Informations</h3>
							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Province</label>
									<select class="form-input-select form__group-select" @change="_getDistrictByProvince" v-model="province_id">
			              <option selected>Choose Province</option>
										<option v-for="(prov, index) in provinceData" :value="prov.id">{{prov.name}}</option>
			            </select>
								</div>
								<div class="form__group">
									<label for="">District</label>
									<select class="form-input-select form__group-select" v-model="district_id" @change="_getSectorByDistrict">
			              <option value="" selected>Choose District</option>
										<option v-for="(district, index) in districtData" :value="district.id">{{district.name}}</option>
			            </select>
								</div>

								<div class="form__group">
									<label for="">Sector</label>
									<select class="form-input-select form__group-select" v-model="sector_id" @change="_getCellBySector">
			              <option value="" selected >Choose Sector</option>
										<option v-for="(sector, index) in sectorData" :value="sector.id">{{sector.name}}</option>
			            </select>
								</div>
								<div class="form__group">
									<label for="">Cell</label>
									<select class="form-input-select form__group-select" v-model="cell_id" @change="_getVillageByCell">
			              <option value="" selected >Choose Cell</option>
										<option v-for="(cell, index) in cellData" :value="cell.id">{{cell.name}}</option>
			            </select>
								</div>
							</div>
				      <div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Village</label>
									<select class="form-input-select form__group-select" v-model="village_id">
			              <option value="" selected>Choose Village</option>
										<option v-for="(village, index) in villageData" :value="village.id">{{village.name}}</option>
			            </select>
								</div>
				        <div class="form__group">
									<label for="">Address</label>
				          <input type="text" v-model="address" class="form-input form__group-control" placeholder="Address" tabindex="1">
				        </div>
								<div class="form__group">
									<label for="">Etage</label>
				          <input type="text" v-model="etage" class="form-input form__group-control" placeholder="Etage">
				        </div>
								<div class="form__group">
									<label for="">Saloon</label>
				          <input type="text" v-model="saloon" value="" class="form-input form__group-control" placeholder="Saloon">
				        </div>
				      </div>

							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Bedrooms</label>
				          <input type="text" v-model="bedrooms" class="form-input form__group-control" placeholder="Bedrooms">
				        </div>
								<div class="form__group">
									<label for="">Bathrooms</label>
				          <input type="text" v-model="bathrooms" class="form-input form__group-control" placeholder="Bathrooms">
				        </div>
								<div class="form__group">
									<label for="">Toilet</label>
				          <input type="text" v-model="toilet" class="form-input form__group-control" placeholder="Toilet">
				        </div>
								<div class="form__group">
									<label for="">Kitchens</label>
				          <input type="text" v-model="cooked" value="" class="form-input form__group-control" placeholder="Kitchens">
				        </div>
							</div>
							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Annexe</label>
				          <input type="text" v-model="annexe" class="form-input form__group-control" placeholder="Annexe">
				        </div>
								<div class="form__group">
									<label for="">Water Tank</label>
				          <input type="text" v-model="waterTank" class="form-input form__group-control" placeholder="Water Tank">
				        </div>
								<div class="form__group">
									<label for="">Parking</label>
				          <input type="text" v-model="parking" class="form-input form__group-control" placeholder="Parking">
				        </div>
								<div class="form__group">
									<label for="">Jardin</label>
				          <input type="text" v-model="jardin" class="form-input form__group-control" placeholder="Jardin">
				        </div>
							</div>
							<div class="ted-col ted-col-tab-land-4">
								<div class="form__group">
									<label for="">Surface</label>
				          <input type="text" v-model="surface" class="form-input form__group-control" placeholder="Surface">
				        </div>
								<div class="form__group">
									<label for="">Price</label>
				          <input type="number" v-model="price" class="form-input form__group-control" placeholder="Price">
				        </div>
								<div class="form__group">
									<label for="">Fully</label>
									<select class="form-input-select form__group-select" v-model="fully">
			              <option value="" disabled selected hidden>Choose Fully</option>
										<option value="1">Fully furnished house</option>
										<option value="2">Fully unfurnished house</option>
			            </select>
								</div>
							</div>
				      <div class="ted-col ted-col-mob-1 ted-col-tab-por-1 u-margin-top-2x">
				        <div class="ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2">
				        <div>
				          <button name="button" class="btn btn-secondary btn-size-tab-land-3" @click="create_properties">Save</button>
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
	<?php endif; ?>
<?=$this->endSection() ?>
