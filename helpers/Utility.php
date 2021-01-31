<?php
namespace app\helpers;

use yii;

class Utility{
    public static function tableUniqueId($tablename,$text)
    {
	$sqlunique = 'select count(id) as id from '.$tablename;
	$uniquedetails = Yii::$app->db->createCommand($sqlunique)->queryOne();
	$uniqueId = $uniquedetails['id'];
	if(!empty($uniqueId)){
	    $newid = $uniqueId+1;
        }else{
	    $newid = 1;
        }
        return $text.sprintf('%04d',$newid);
    }	
}
?>
