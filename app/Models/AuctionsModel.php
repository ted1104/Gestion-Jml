<?php
namespace App\Models;
use CodeIgniter\Model;
class AuctionsModel extends Model{

  protected $table = 'o_auctions';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['title','description','lieu','datapublished','deadline'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'title' => 'required',
    'description' => 'required',
    'datapublished' => 'required|valid_date[Y-m-d]',
    'deadline' => 'required|valid_date[Y-m-d]|compareDate[datapublished,deadline]',
    // 'linkapply' => 'valid_url'
  ];
	protected $validationMessages = [
      'title'=>[
        'required' => 'The field title is required'
      ],
      'description'=>[
        'required' => 'The field description is required',
      ],
      'datapublished'=>[
        'required' => 'The field Start date is required',
        'valid_date' => 'Invalid start date, format must be like 2020-10-09'
      ],
      'deadline'=>[
        'required' => 'The field End date is required',
        'valid_date' => 'Invalid end date, format must be like 2020-10-09',
        'compareDate' => 'Start date must be inferior to the End date'
      ],
      // 'linkapply'=>[
      //   'valid_url' => 'Please put the correct url link'
      // ]
  ];
  protected $returnType ='App\Entities\AuctionsEntity';


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
