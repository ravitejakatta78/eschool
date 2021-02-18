<?php

namespace app\helpers;
 
use yii;
use app\helpers\MyConst;

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
    /*
    * @param date 
    * @return date with changed date format d-M-Y
    */
    public function	format_date($date,$type = MyConst::_D_M_Y)
    {
        if($type == MyConst::_D_M_Y) {
            return date('d-M-Y',strtotime($date));
        }
        else if($type == MyConst::_Y_M_D) {
            return date('Y-m-d',strtotime($date));
        }
        else if($type == _Y_M_D_H){
            return date('Y-m-d h:i:s A',strtotime($date));
        }
    }
}
?>
