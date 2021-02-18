<?php
namespace app\controllers;

use yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use \app\models\Schools;
use \app\helpers\MyConst;

class AdminController extends GoController
{
    public function actionIndex()
    {
		return $this->render('index');
    }
    public function actionAddSchool(){
        $model = new Schools;
        $school_list = Schools::find()
            ->where(['status' => MyConst::_ACTIVE])
	        ->orderBy([
                'ID'=>SORT_DESC
            ])
            ->asArray()->all();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
                if ($model->load(Yii::$app->request->post()) ) {
                    $schools_arr = Yii::$app->request->post('Schools');
                    $model->status = MyConst::_ACTIVE;
                    $model->created_by = Yii::$app->user->identity->first_name;
                    $model->created_on = date('Y-m-d h:i:s A');
                    $model->updated_by = Yii::$app->user->identity->first_name;
                    $model->updated_on = date('Y-m-d h:i:s A');            
                    if($model->validate()){
                        $user_array = ['user_mobile' => $schools_arr['mobile'] ,'user_email' => $schools_arr['email'],
                        'first_name' =>  $schools_arr['school_name'],'school_id' => $model->getPrimaryKey()
                        ];
                        Yii::$app->school->userCreation($user_array);
                        $model->save();
                        Yii::$app->getSession()->setFlash('success', [
                            'title' => 'School',
                            'text' => 'School Created Successfully',
                            'type' => 'success',
                            'timer' => 3000,
                            'showConfirmButton' => false
                        ]);
                        $transaction->commit();
                        return	$this->redirect('add-school');
                    }
                    else
                    {
                    //	echo "<pre>";print_r($model->getErrors());exit;
                    }
                }
            }catch(Exception $e) {
                $transaction->rollback();
            }

        return $this->render('addschool',['model'=>$model,'school_list'=>$school_list]);
    }
    public function actionEditschoolpopup(){
        extract($_POST);
		$model = Schools::findOne($id);
        return $this->renderAjax('editschool', ['model' => $model,'id'=>$id]);		
    }
    public function actionEditschool()
    {
            $model = new Schools;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $schoolsArr = Yii::$app->request->post('Schools');
            $schools_update = Schools::findOne($_POST['Schools']['id']);
            
            $schools_update->attributes = \Yii::$app->request->post('Schools');
            $schools_update->updated_by = Yii::$app->user->identity->first_name;
            $schools_update->updated_on = date('Y-m-d h:i:s A');   
            if($schools_update->validate()){
                $schools_update->save();
                Yii::$app->getSession()->setFlash('success', [
            'title' => 'School',
            'text' => 'School Edited Successfully',
            'type' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
            }
                return $this->redirect('add-school');
    }
    public function actionTest()
    {
        \app\helpers\Mailer::mailsent();
    }
}
