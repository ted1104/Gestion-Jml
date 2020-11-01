<!-- SEQUELETON -->

<div v-if="showSqleton" v-for ="(n,i) in tabSqleton" class="card ted-col ted-col-mob-1 u-padding-bottom-5x">
  <div class="card__image sq sq__image sq__image-size-1 u-border-radius-5">
  </div>
  <div class="card__detail ted-col ted-col-mob-2 ted-col-tab-por-2-c2-c1 u-margin-top-5x">
    <div class="u-content-vertical u-content-vertical__align-space-between">
      <span class="sq sq__text-size-h-1 sq__text-size-w-50"></span>
      <span class="sq sq__text-size-h-1 sq__text-size-w-75"></span>
      <span class="sq sq__text-size-h-1 sq__text-size-w-60"></span>
    </div>
    <div class="card__detail__right u-content-vertical u-content-vertical__align-right u-content-vertical__align-space-between">
      <span class="card__detail__right--price sq sq__text-size-h-1 sq__text-size-w-60"></span>
      <button href="#" class="btn sq sq__btn">sql</button>
    </div>
  </div>
</div>
