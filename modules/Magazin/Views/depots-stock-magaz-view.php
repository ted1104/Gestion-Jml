<?=$this->extend('template/_base_template') ?>

<?=$this->section('title') ?>
	<?=$titlePage ?>
<?=$this->endSection() ?>

<?=$this->section('content') ?>


    <!-- Start XP Container -->
    <div id="xp-container">
        <!-- Start XP Leftbar -->
        <div class="xp-leftbar">
          <?=$this->include('partials/_menu_main') ?>
        </div>
        <!-- End XP Leftbar -->
        <!-- Start XP Rightbar -->
        <div class="xp-rightbar">
          <?=$this->include('partials/_header_main') ?>
            <!-- Start XP Breadcrumbbar -->
            <?=$this->include('partials/_page_title') ?>
            <!-- End XP Breadcrumbbar -->
            <!-- Start XP Contentbar -->
            <div class="xp-contentbar">
                <!-- Write page content code here -->
                <!-- Start XP Row -->
                <div class="row">
									<!-- Start XP Col -->
									 <div class="col-md-12 col-lg-12 col-xl-12">
											 <div class="text-center mt-3 mb-5">
													 <h4>DEPOTS STOCK {{dataToDisplay.nom}}</h4>
											 </div>
									 </div>
									 <!-- End XP Col -->
                    <div class="col-md-12 col-lg-12 col-xl-12">
											<div class="row">

												<div class="col-md-10 col-lg-10 col-xl-10">
													<div class="card m-b-30 container">
                            <div class="card-header row bg-white">
                                <h5 class="card-title text-black col-md-6">INFORMATIONS DE MON STOCK</h5>
																<div class="col-md-6">
																	<div class="row text-center" v-if="CritiqueDataTab.length >0">
																		<div class="col-md-4" >
																			<span class="badge badge-pill badge-danger">N</span><br> Qte <= {{CritiqueDataTab[0].montant_min}}
																		</div>
																		<div class="col-md-4">
																			<span class="badge badge-pill badge-warning">N</span><br> {{CritiqueDataTab[0].montant_min}} < Qte < {{CritiqueDataTab[0].montant_max}}
																		</div>
																		<div class="col-md-4">
																			<span class="badge badge-pill badge-success">N</span><br> {{CritiqueDataTab[0].montant_max}} <= Qte
																		</div>
																	</div>
																</div>
                            </div>
														<div class="table-responsive card-body">
															<table class="table">
																<thead>
																	<tr>
																		<th scope="col">code</th>
																		<th scope="col">Article</th>
																		<th scope="col">Descritpion</th>
																		<th scope="col">Qte</th>
																		<th scope="col">Etat</th>

																	</tr>
																</thead>
																<tbody>
																	<tr v-for="(det,i) in dataToDisplay.logic_article_stock">
																		<td>{{det.articles_id[0].code_article}}</td>
																		<td>{{det.articles_id[0].nom_article}}</td>
																		<td>{{det.articles_id[0].description}}</td>
																		<td>{{det.qte_stock}}</td>
																		<td>
																			<span :class="det.logic_etat_critique==1?'badge badge-pill badge-danger':(det.logic_etat_critique==2?'badge badge-pill badge-warning':'badge badge-pill badge-success')">N</span>
																		</td>

																	</tr>
																</tbody>
															</table>
															<!-- LOAD FOR WAITING DATA -->
															<div class="text-center" v-if="dataToDisplay.length < 1">
																<img src="<?=base_url() ?>/load/load-tab.gif" alt="">
															</div>
															<!-- PAGINATION -->
															<!-- <nav aria-label="...">
                                  <ul class="pagination">
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_previous_page(get_historique_approvisionnement)">Previous</button>
                                    </li>
                                    <li v-for="(pageData, index) in paginationTab" :class="currentIndexPage==index?'page-item active':'page-item'"><button class="page-link" @click="get_historique_approvisionnement(pageData.limit,pageData.offset,index)">{{index+1}}</button></li>
                                    <li class="page-item">
                                      <button class="page-link" @click="_u_next_page(get_historique_approvisionnement)">Next</button>
                                    </li>
                                  </ul>
                                </nav> -->
														</div>
                        </div>
												</div>


											</div>
                    </div>
                    <!-- End XP Col -->
                </div>
                <!-- End XP Row -->
            </div>
            <!-- End XP Contentbar -->
            <!-- Start XP Footerbar -->
          <?=$this->include('partials/_footer_main') ?>
            <!-- End XP Footerbar -->
        </div>
        <!-- End XP Rightbar -->
    </div>
    <!-- End XP Container -->
<?=$this->endSection() ?>
