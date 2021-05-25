<?php
namespace App\Models;
use CodeIgniter\Model;


class StZoneModel extends Model{
  protected $table = 'st_zone';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nom','description'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'nom' => 'required|is_unique[st_zone.nom]',
    'description' => 'required'
  ];
  protected $validationMessages = [
    'nom'=>[
              'required' => 'Le nom de la zône est obligatoire',
              'is_unique' => 'Ce nom descriptif de la zône existe déjà'
            ],
    'description'=>[
              'required' => 'La description de la zône est obligatoire',
            ],

];
  protected $returnType ='App\Entities\StZoneEntity';


  // public function checkingIfAnotherDepotCentralExit($isCentral){
  //   if($isCentral==1){
  //     if($this->Where('is_central',$isCentral)->find()){
  //       return false;
  //     }
  //   }
  //   return true;
  // }

}
