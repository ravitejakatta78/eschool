<?php
namespace app\components;

use yii;
use \app\models\Users;
use yii\base\Component;
use \app\helpers\Utility;
use \app\helpers\MyConst;


date_default_timezone_set("asia/kolkata");

class SchoolComponent extends Component
{
	public function init()
	{
        date_default_timezone_set("asia/kolkata");
        parent::init();
	}
	public function userCreation($arr)
	{
		$user_model = new Users;
		$resp = MyConst::_FAIL;
			$user_model->attributes = $arr; 
			$school_unique_id = Utility::tableUniqueId('schools','SCH');
			$user_model->user_name = $arr['user_name'] ?? $school_unique_id ;
			$user_model->first_name = $arr['first_name'] ?? $school_unique_id;
			$user_model->user_password = isset($arr['user_password']) ? md5($arr['user_password']) : md5(MyConst::_DEFAULT_PASSWORD);
			$user_model->gender = $arr['gender'] ?? MyConst::_MALE;
			$user_model->role_id = $arr['role_id'] ?? MyConst::_SCHOOL_ADMIN; 
			$user_model->user_status = MyConst::_ACTIVE;
			$user_model->reg_date = date('Y-m-d');
			$user_model->created_by = Yii::$app->user->identity->first_name;
            $user_model->created_on = date('Y-m-d h:i:s A');
            $user_model->updated_by = Yii::$app->user->identity->first_name;
            $user_model->updated_on = date('Y-m-d h:i:s A');  
			if($user_model->validate()){
				$user_model->save();
				$resp = MyConst::_SUCCESS;
			}else{
				$resp = MyConst::_FAIL;
				echo "<pre>";print_r($user_model->getErrors());exit;
			}	
		
			
		
		return $resp;	
	
	}
}
?>