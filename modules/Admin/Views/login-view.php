<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>
	<main class="">
    <form class="ted-col ted-col-e-1 form u-margin-top-5x bloc-center-horizontal" action="<?=base_url('admin.dy') ?>" method="post">
			<?=csrf_field()?>
      <div class="ted-col">
        <div class="form__group">
          <input type="text" name="username" value="" class="form-input form__group-control" placeholder="Your Email">
        </div>
        <div class="form__group u-margin-top-2x">
          <input type="password" name="password" value="" class="form-input form__group-control" placeholder="Password">
        </div>
      </div>
      <div class="ted-col ted-col-mob-1 ted-col-tab-por-1 u-margin-top-2x">
        <div class="ted-col ted-col-mob-2 ted-col-e-2 ted-col-tab-por-2">
        <div>
          <button type="submit" name="button" class="btn btn-secondary">Login</button>
        </div>
        <div class="u-content-vertical u-content-vertical__align-right ">
          <a class="u-color-red" href="<?=base_url('admin-home.dy') ?>">Forgot Password</a>
        </div>
        </div>

      </div>
    </form>

		
		<?php if(session()->getFlashData('message')): ?>
		<!-- POPUP MESSAGE ERREUR ET SUCCESS -->
		<div class="popup u-animation-FromTop <?=session()->getFlashData('message')['color'] ?>">
			<div class="popup__header">
				<span class="popup__header--title"><?=session()->getFlashData('message')['title'] ?></span>
			</div>
			<div class="popup__content">
				<p><?=session()->getFlashData('message')['content'] ?></p>
			</div>
			<!-- <div class="popup__footer">
				<button type="button" name="close"></button>
			</div> -->
		</div>
	<?php endif; ?>
	</main>
<?=$this->endSection() ?>
