<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\CommandesDetailModel;
use App\Models\StDepotModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\StockModel;
use CodeIgniter\I18n\Time;
use App\Models\CommandesModel;




class CommandesEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'numero_commande' => null,
    'nom_client' => null,
    'telephone_client' => null,
    'date_vente' => null,
    'status_vente_id' => null,
    'users_id ' => null,
    'depots_id ' => null,
    'payer_a'=>null,
    'container_faveur' => null,
    'depots_id_faveur' => null,
    'depots_id_first_livrer' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_article'=>null,
    'logic_somme' =>null,
    'logic_status_histo'=>null,
    'logic_is' => null,
    'logic_code_facture'=>null
  ];

  protected $datamap = [];
  // protected $dates = ['created_at', 'updated_at','deleted_at'];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $depotModel = null;
  protected $commandeDetail = null;
  protected $commandesStatusHistoriqueModel = null;
  protected $stockModel = null;
  protected $commandesModel = null;
  protected $encrypter;




  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->depotModel = new StDepotModel();
    $this->commandeDetail = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->stockModel = new StockModel();
    $this->encrypter = Services::encrypter();
    $this->commandesModel = new CommandesModel();
  }

  public function getStatusVenteId(){
    $db = \Config\Database::connect();
    $query = $db->table('st_status_vente')->getWhere(['id' => $this->attributes['status_vente_id']]);
    $data = $query->getRow();
    return $data;
  }

  public function getUsersId(){
    return $this->userModel->Where('id',$this->attributes['users_id'])->findAll();
  }
  public function getDepotsId(){
    return $this->depotModel->Where('id',$this->attributes['depots_id'])->findAll();
  }
  public function getPayerA(){
    return $this->userModel->Where('id',$this->attributes['payer_a'])->findAll();
  }

  public function getLogicArticle(){
    return $this->commandeDetail->Where('vente_id',$this->attributes['id'])->findAll();
  }
  public function getDateVente(){
    return $this->attributes['created_at'];
  }
  public function getLogicSomme(){
    $detail = $this->commandeDetail->Where('vente_id',$this->attributes['id'])->findAll();
    $sommes= 0;
    foreach ($detail as $key => $value) {
      $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;
      $sommes +=$montant;
    }
    return round($sommes,2);
  }
  public function getLogicStatusHisto(){
    $arr_main = [];
    for ($i=1; $i < 5; $i++) {
      $user = null;
      $date = null;
      if($att = $this->commandesStatusHistoriqueModel->Where('vente_id',$this->attributes['id'])->Where('status_vente_id',$i)->first()){
        $date = $att->created_at;
        if($userAtt = $this->userModel->Where('id',$att->users_id)->first()){
          $user = $userAtt->nom.' '.$userAtt->prenom;
        }
      }
      $array = $i==1?'attente':($i==2?'payer_par':($i==3?'livre_par':'annuler_par'));
      $a =[$array =>[
        "user"=> $user,
        "date"=> $date,
      ]];
      array_push($arr_main,$a);
    }
    return $arr_main;

  }

  public function getLogicIs(){
    //CONTAIN EN SE BASANT SUR VIRTUELLE
    $is = false;
    $isReel = false;

    $depot = $this->attributes['depots_id'];
    $depotCentral = $this->attributes['depots_id_faveur'];
    $detail = $this->commandeDetail->Where('vente_id',$this->attributes['id'])->findAll();
    foreach ($detail as $key => $value) {
      //print_r($depotCentral);
      $qte_vendue = $value->qte_vendue;
      // if($value->is_faveur == 0){
        $stockqte = $this->stockModel->Where('depot_id',$depot)->Where('articles_id',$value->articles_id[0]->id)->first();
      // }else{
      //   $stockqte = $this->stockModel->Where('depot_id',$depotCentral)->Where('articles_id',$value->articles_id[0]->id)->first();
      // }
      if($depotCentral !=""){
        if($qte_vendue > $stockqte->qte_stock_virtuel){
          $is = true;
        }
        if($qte_vendue > $stockqte->qte_stock){
          $isReel = true;
        }
      }

    }
    return array(
      'virtuel' => $is,
      'reel' => $isReel
    );
  }

  public function getLogicCodeFacture(){
    $plainText = 200;
    $ciphertext = base64_encode($this->encrypter->encrypt($plainText));

    // Outputs: This is a plain-text message!
    //echo $this->encrypter->decrypt(base64_decode($ciphertext));
    return $ciphertext;
  }

  //HELPER




  // public function getUsersId(){
  //   return $this->userModel->find($this->attributes['users_id']);
  // }
  // public function getLogicDetailData(){
  //   return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }



}
