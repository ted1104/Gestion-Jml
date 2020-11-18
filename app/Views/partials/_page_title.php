<div class="xp-breadcrumbbar text-center">
    <h4 class="page-title"><?=$this->renderSection('title') ?></h4>
    <p><?=session('profile') ?> <?=session('users')['info'][0]->is_main == 1?'PRINCIPAL':'' ?></p>
</div>
