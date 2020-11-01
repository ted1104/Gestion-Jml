<?php $this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
  <main class="main-page u-animation-FromBottom">
    <section class="tenders" v-if="DataProperties.length > 0">
      <div class="card ted-col ted-col-mob-2-c1-c3 ted-col-tab-land-2-c1-c6 ted-col-e-7 u-margin-bottom-6x">
        <div class="card__image">
          <img :src="'<?=base_url() ?>/uploads/images/'+DataProperties[0].logic_main_file.image_file" alt="Logo ByOseMarket" class="image_size_responsive card__image--img">
        </div>
        <div class="card__detail ">
          <div class="card__detail__left u-content-vertical">
            <span class="card__detail__left--title-01">{{DataProperties[0].title}} </span>
            <span class="card__detail__left--title-02 u-color-red">{{DataProperties[0].entreprise}}</span>
            <span class="card__detail__left--title-03 u-font-size-mob">Published {{DataProperties[0].datapublished}}  | Deadline {{DataProperties[0].deadline}}</span>
          </div>
        </div>
      </div>
      <div class="u-content-justify">
      	<div v-html="DataProperties[0].description">
      	</div>
      </div>

      <hr class="u-opacity-4x">
      <div class="ted-col ted-col-tab-land-2 note-section u-margin-top-5x">
        <div class="">
          <p class="u-content-vertical u-font-size-mob u-font-size-tab-por">
            <span><span class="u-bold">Note :</span> Click on the APPLY link if exist to send your application documents <a v-if= "DataProperties[0].linkapply !=null" :href="DataProperties[0].linkapply" target="_blank" class="u-color-red">( Apply link )</a></span>
            <span>Your application will be sent to the employer immediately (Allowed formats : .doc, .pdf, .txt, .docx)</span>
            <span>A confirmation email will be sent to you few minutes after awards</span>
            <span>You can request any documents archived from our website (ex : job description, a CV, a cover letter)</span>
            <span>Please bear in mind that you should never requested to pay to get interviews or to pass extra certification</span>
          </p>
        </div>
        <div class="ted-col ted-col-mob-2-c1-c2 ted-col-tab-por-2-c1-c3 ted-col-tab-land-1 ted-col-e-8 u-margin-top-5x u-content-align-right-tab-land">
          <div class="">
            <a href="#" class="btn btn-secondary">Download Attachement</a>
          </div>
          <div class="icons-socials">
            <span>Share with</span>
          </div>
        </div>
      </div>
    </section>
  </main>
<?=$this->endSection() ?>
