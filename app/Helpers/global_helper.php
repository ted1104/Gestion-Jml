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

if(! function_exists('getLieuAffectationDetail')){
  function getLieuAffectationDetail($idDepot){
    $db = \Config\Database::connect();
    $query = $db->table('st_depots')->getWhere(['id' => $idDepot]);
    $data = $query->getRow();
    return $data;
  }
}

if(! function_exists('getTypeDepot')){
  function getTypeDepot($idDepot){
    $db = \Config\Database::connect();
    $query = $db->table('st_depots')->getWhere(['id' => $idDepot]);
    $data = $query->getRow();
    return $data->is_central == 1 ? true : false;
  }
}

if(! function_exists('getDepotCentral')){
  function getDepotCentral($lieu){
    $db = \Config\Database::connect();
    $query = $db->table('st_depots')->getWhere(['is_central' => 1, 'lieu' =>$lieu]);
    $data = $query->getRow();
    return $data->id;
  }
}
//$tableSecondaire,$id
