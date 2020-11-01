<?php

if (! function_exists('checkingForeignKey')){
  function checkingForeignKey($tableSecondaire,$namePrimaryKey ='id',$id){
    $db = \Config\Database::connect();
    //$query = $builder in codeigniter Docs
    $query = $db->table($tableSecondaire)->getWhere([$namePrimaryKey => $id]);
    $data = $query->getRow();
    if($data){
      return true;
    }
    return false;
  }
}
//$tableSecondaire,$id
