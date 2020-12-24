<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\CommandesDetailModel;
use App\Models\StockModel;

class CommandesModel extends Model{
  protected $table = 'g_interne_vente';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['numero_commande','nom_client','telephone_client','date_vente','status_vente_id','users_id','depots_id','payer_a','is_negotiate','container_faveur'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'numero_commande' => 'required|is_unique[g_interne_vente.numero_commande]',
    'nom_client' => 'required',
    'date_vente' => 'required|valid_date[Y-m-d]',
    'status_vente_id' => 'required',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]',
    'depots_id' => 'required|checkingForeignKeyExist[st_depots,id]',
    'payer_a' =>'required|checkingForeignKeyExist[g_users,id]'
  ];
	protected $validationMessages = [
    'numero_commande'=>[
      'required' => 'Le numéro de la facture est obligatoire',
      'is_unique' => 'Le numero de la facture renseigné existe déjà'
    ],
    'nom_client'=>['required' => 'Le nom du client est obligatoire'],
    'date_vente'=>[
      'required' => 'La date de la vente est obligatoire',
      'valid_date'=>'Le format de la date est incorect'
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ],
    'payer_a' => [
      'required' => 'Le(a) caissier(e) est obligatoire',
      'checkingForeignKeyExist' => 'cet(te) caissièr(e) n\'existe pas'
    ],
    'depots_id' => [
      'required' => 'Le depot est obligatoire',
      'checkingForeignKeyExist' => 'ce dépôt n\'existe pas'
    ]

  ];
  protected $returnType ='App\Entities\CommandesEntity';
  protected $commandeDetail = null;
  protected $stockModel = null;

  public function checkingIfOneArticleHasNotEnoughtQuanity($iddepot, $idcommande){
    $this->commandeDetail = new CommandesDetailModel();
    $this->stockModel  = new StockModel();
    $is = false;
    $depot = $iddepot;
    $detail = $this->commandeDetail->Where('vente_id',$idcommande)->findAll();
    foreach ($detail as $key => $value) {

      $qte_vendue = $value->qte_vendue;
      $stockqte = $this->stockModel->Where('depot_id',$depot)->Where('articles_id',$value->articles_id[0]->id)->first();
      if($qte_vendue > $stockqte->qte_stock){
        $is = true;
      }
    }
    return $is;

  }
  public function createUniqueAchatID(){
        $alpha  = '1234567890932893208394238439408230948234023482309483094830948230';
        $length = 6;
        $tip = array();
        $alphaLength = strlen($alpha) - 1;
        for($i = 0; $i< $length; $i++){
                $n = rand(0, $alphaLength);
                $tip[] = $alpha[$n];
        }
        return implode($tip);
  }
  public function checkIfUniqueAchatIDExist($uniqueID){
    $data = $this->Where('numero_commande',$uniqueID)->find();
    if($data){
      return $this->checkIfUniqueAchatIDExist($this->createUniqueAchatID());
    }
    return $uniqueID;

  }

  // LES TRANSACTIONS
  public function beginTrans(){
    $this->db->transBegin();
  }
  public function RollbackTrans(){
    $this->db->transRollback();
  }
  public function commitTrans(){
    $this->db->transCommit();
  }
}
