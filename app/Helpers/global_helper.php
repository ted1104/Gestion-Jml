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
if(! function_exists('checkroleandredirect')){
  function checkroleandredirect($idrole){
    $db = \Config\Database::connect();
    $query = $db->table('st_roles')->getWhere(['id' => $idrole]);
    $data = $query->getRow();
    return $data;
  }
}
//$tableSecondaire,$id
