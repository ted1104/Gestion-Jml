<div class="xp-breadcrumbbar text-center">
    <h4 class="page-title"><?=$this->renderSection('title') ?></h4>
    <span><?=session('profile') ?> <?=session('users')['info'][0]->is_main == 1?'PRINCIPAL':'' ?></span><br>
    <span class="text-white"><?=session('users')['info'][0]->prenom.' '.session('users')['info'][0]->nom ?></span><br>
    <span class="text-white"><?=session('lieuAffectation')->nom ?></span>


</div>
