<?php
namespace App\Models;
use CodeIgniter\Model;

class ImageSecondairesModel extends Model{
  protected $table = 'o_images_secondaires';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['image_file','element_id','is_main','type_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'image_file' => 'required',
    'element_id' => 'required',
    'type_id' => 'required',
  ];

  protected $returnType ='object';
}
