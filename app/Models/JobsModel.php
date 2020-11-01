<?php
namespace App\Models;
use CodeIgniter\Model;
class JobsModel extends Model{

  protected $table = 'o_jobs';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['title','description','entreprise','datapublished','deadline','linkapply'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'title' => 'required',
    'description' => 'required',
    'entreprise' => 'required',
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
      'entreprise'=>[
        'required' => 'The field entreprise is required',
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
  protected $returnType ='App\Entities\JobsEntity';


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
