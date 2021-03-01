<?php

namespace app\controllers;

use Yii;
use \app\helpers\MyConst;
use \app\models\Students;
use \app\models\Parents;
use \app\models\Subjects;
use \app\models\Faculity;
use \app\models\Classes;
use \app\models\Exams;
use \app\models\ExamDetails;
use \app\models\SchoolFee;
use \app\models\NoticeBoard;
use app\models\StudentPaidFee;
use yii\web\UploadedFile;
use \yii\helpers\Url;


class SchoolController extends GoController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionStudents()
    {
        $studentModel = new Students;
        $parentModel = new Parents;
        $sql_student_list = 'select s.id,first_name,last_name,parent_name
        ,address,email,phone,c.class_name 
        from students s inner join parents p on p.id = s.parent_id
        left join classes c on c.id = s.student_class 
        where s.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $student_list = Yii::$app->db->createCommand($sql_student_list)->queryAll();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            $parent_arr = Yii::$app->request->post('Parents');
            $student_arr = Yii::$app->request->post('Students');
            $parent_identity = Parents::find()->where(['phone'=> $parent_arr['phone']])->asArray()->One();
            if ($parentModel->load(Yii::$app->request->post()) && empty($parent_identity)) {
                
                $parentModel->status = MyConst::_ACTIVE;
                $parentModel->created_by = Yii::$app->user->identity->first_name;
                $parentModel->created_on = date('Y-m-d h:i:s A');
                $parentModel->updated_by = Yii::$app->user->identity->first_name;
                $parentModel->updated_on = date('Y-m-d h:i:s A');
                $parentModel->reg_date = date('Y-m-d');
                if($parentModel->validate()){
                    $parentModel->save();
                    $parent_id = $parentModel->getPrimaryKey();
                    $parent_list = Parents::find()->all();
                    if(!empty($parent_list)){
                        $newid = count($parent_list)+1;
                    }else{
                        $newid = 1;
                    }
                    $username = 'P'.Yii::$app->user->identity->school_id.sprintf('%04d',$newid);

                    $user_array = ['user_mobile' => $parent_arr['phone'] ,'user_email' => $parent_arr['email'],
                    'first_name' =>  $parent_arr['parent_name'],'role_id' => MyConst::_PARENT,
                    'gender' => $parent_arr['parent_type'],'user_name' => $username,'school_id' => Yii::$app->user->identity->school_id
                    ];
                Yii::$app->school->userCreation($user_array);  
                }    
            }
            else{
                $parent_id = $parent_identity['phone'];
            }

            if ($studentModel->load(Yii::$app->request->post()) ) {
                $studentModel->school_id = Yii::$app->user->identity->school_id;
                $studentModel->dob = date('Y-m-d',strtotime($student_arr['dob']));
                $studentModel->role_id = MyConst::_STUDENT;
                $studentModel->parent_id = $parent_id;
                $studentModel->status = MyConst::_ACTIVE;
                $studentModel->created_by = Yii::$app->user->identity->first_name;
                $studentModel->created_on = date('Y-m-d h:i:s A');
                $studentModel->updated_by = Yii::$app->user->identity->first_name;
                $studentModel->updated_on = date('Y-m-d h:i:s A');
                $studentModel->reg_date = date('Y-m-d');
                $image = UploadedFile::getInstance($studentModel, 'student_img');
                if($image){
                $folderpath = 'uploads/'.Yii::$app->user->identity->school_id.'/student_images/';
                    if (!is_dir($folderpath)) {
                        mkdir($folderpath, 0777, true);
                    }
            
                    $imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
                    $image->saveAs($folderpath . $imagename);
                    $studentModel->student_img = $imagename;
                }
                $studentModel->save();
                Yii::$app->getSession()->setFlash('success', [
                    'title' => 'Student',
                    'text' => 'Student Created Successfully',
                    'type' => 'success',
                    'timer' => 3000,
                    'showConfirmButton' => false
                ]);
                $transaction->commit();
                return $this->redirect('students');
            }
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('students',['studentModel' => $studentModel, 'parentModel' => $parentModel
        , 'student_list' => $student_list]);
    }
    public function actionEditstudentpopup()
    {
        extract($_POST);
        $studentModel = Students::findOne($id);
        $parentModel = Parents::findOne($studentModel['parent_id']);
        return $this->renderAjax('editstudent', ['studentModel' => $studentModel,'parentModel'=>$parentModel]);   
    }
    public function actionEditstudent()
    {
        $studentModel = new Students;
        $parentModel = new Parents;
        if (Yii::$app->request->isAjax && $studentModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($studentModel);
        }

        $student_arr = Yii::$app->request->post('Students');
        $students_update = Students::findOne($_POST['Students']['id']);
        $oldStudentImage = $students_update['student_img'];
        $students_update->attributes = \Yii::$app->request->post('Students');
        $students_update->dob = date('Y-m-d',strtotime($student_arr['dob']));
        $students_update->updated_by = Yii::$app->user->identity->first_name;
        $students_update->updated_on = date('Y-m-d h:i:s A');   

        $image = UploadedFile::getInstance($studentModel, 'student_img');
        if($image){
            $folderpath = 'uploads/'.Yii::$app->user->identity->school_id.'/student_images/';
            $imagePath =  '../../'.Url::to(['/'.$folderpath. $oldStudentImage]);
            if(file_exists($imagePath)){
                unlink($imagePath);	
            }
            if (!is_dir($folderpath)) {
                mkdir($folderpath, 0777, true);
            }
            $imagename = strtolower(base_convert(time(), 10, 36) . '_' . md5(microtime())).'.'.$image->extension;
            $image->saveAs($folderpath.$imagename);
            $students_update->student_img = $imagename;
        }else{
            $students_update->student_image = $oldProductImage;
        }

        
        if($students_update->validate()){
            $students_update->save();
            $parent_arr = Yii::$app->request->post('Parents');
            $parent_update = Parents::findOne($students_update['parent_id']);
            $parent_update->attributes = \Yii::$app->request->post('Parents');
            $parent_update->updated_by = Yii::$app->user->identity->first_name;
            $parent_update->updated_on = date('Y-m-d h:i:s A'); 
            if($parent_update->validate()){
                $parent_update->save();
            }
            Yii::$app->getSession()->setFlash('success', [
        'title' => 'Student',
        'text' => 'Student Details Updated Successfully',
        'type' => 'success',
        'timer' => 3000,
        'showConfirmButton' => false
    ]);
        }
            return $this->redirect('students');        
    }
    public function actionSubjects()
    {
        $subjectsModel = new Subjects;
        $subject_list = Subjects::find()
        ->where(['status' => MyConst::_ACTIVE])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($subjectsModel->load(Yii::$app->request->post()) ) {
                $subjects_arr = Yii::$app->request->post('Subjects');
                $subjectsModel->school_id = Yii::$app->user->identity->school_id;
                $subjectsModel->status = MyConst::_ACTIVE;
                $subjectsModel->created_by = Yii::$app->user->identity->first_name;
                $subjectsModel->created_on = date('Y-m-d h:i:s A');
                $subjectsModel->updated_by = Yii::$app->user->identity->first_name;
                $subjectsModel->updated_on = date('Y-m-d h:i:s A');
                if($subjectsModel->validate()){
                    $subjectsModel->save();
                    Yii::$app->getSession()->setFlash('success', [
                        'title' => 'Subject',
                        'text' => 'Subject Created Successfully',
                        'type' => 'success',
                        'timer' => 3000,
                        'showConfirmButton' => false
                    ]);
                    $transaction->commit();
                    return	$this->redirect('subjects');
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('subjects',['subjectsModel' => $subjectsModel, 'subject_list' => $subject_list]);
    }
    public function actionEditsubjectpopup()
    {
        extract($_POST);
		$model = Subjects::findOne($id);
        return $this->renderAjax('editsubject', ['model' => $model]);   
    }
    public function actionEditsubject()
    {
            $model = new Subjects;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $subjects_arr = Yii::$app->request->post('Subjects');
            $subjects_update = Subjects::findOne($_POST['Subjects']['id']);
            $subjects_update->attributes = \Yii::$app->request->post('Subjects');
            $subjects_update->updated_by = Yii::$app->user->identity->first_name;
            $subjects_update->updated_on = date('Y-m-d h:i:s A');   
            if($subjects_update->validate()){
                $subjects_update->save();
                Yii::$app->getSession()->setFlash('success', [
            'title' => 'Subject',
            'text' => 'Subject Updated Successfully',
            'type' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
            }
                return $this->redirect('subjects');
    }
    public function actionFaculity()
    {
        $faculityModel = new Faculity;
        $school_id = Yii::$app->user->identity->school_id;
        $connection = \Yii::$app->db;	
        $sql_faculity_list = 'select f.id,f.faculity_name,f.mobile,s.subject_name from faculity f inner join subjects s on f.subject_id = s.id 
        where f.school_id = \''.$school_id.'\' and f.status = \''.MyConst::_ACTIVE.'\'';
        $faculity_list = $connection->createCommand($sql_faculity_list)->queryAll(); 
        
        $transaction = $connection->beginTransaction();
        try {
            if ($faculityModel->load(Yii::$app->request->post()) ) {
                $faculity_arr = Yii::$app->request->post('Faculity');
                $faculityModel->school_id = $school_id;
                $faculityModel->status = MyConst::_ACTIVE;
                $faculityModel->created_by = Yii::$app->user->identity->first_name;
                $faculityModel->created_on = date('Y-m-d h:i:s A');
                $faculityModel->updated_by = Yii::$app->user->identity->first_name;
                $faculityModel->updated_on = date('Y-m-d h:i:s A');
                if(!empty($faculity_list)){
                        $newid = count($faculity_list)+1;
                    }else{
                        $newid = 1;
                    }
                    $username = 'T'.$school_id.sprintf('%04d',$newid);
                if($faculityModel->validate()){
                    $faculityModel->save();

                    $user_array = ['user_mobile' => $faculity_arr['mobile'] ,'user_email' => $faculity_arr['email'],
                        'first_name' =>  $faculity_arr['faculity_name'],'role_id' => MyConst::_TEACHER,
                        'gender' => $faculity_arr['gender'],'user_name' => $username,'school_id' => $school_id
                        ];
                    Yii::$app->school->userCreation($user_array);    
                    Yii::$app->getSession()->setFlash('success', [
                        'title' => 'Teacher',
                        'text' => 'Teacher Created Successfully',
                        'type' => 'success',
                        'timer' => 3000,
                        'showConfirmButton' => false
                    ]);
                    
                    $transaction->commit();
                    return	$this->redirect('faculity');
                }
                else{
//                    echo "<pre>";print_r($faculityModel);exit;
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
//            echo "<pre>";var_dump($e->getMessage());exit;
        }    
        return $this->render('faculity',['faculityModel' => $faculityModel, 'faculity_list' => $faculity_list]);
    }
    public function actionEditfaculitypopup()
    {
        extract($_POST);
		$model = Faculity::findOne($id);
        return $this->renderAjax('editfaculity', ['faculityModel' => $model]);   
    }
    public function actionEditfaculity()
    {
            $model = new Faculity;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $faculity_arr = Yii::$app->request->post('Faculity');
            $faculity_update = Faculity::findOne($_POST['Faculity']['id']);
            $faculity_update->attributes = \Yii::$app->request->post('Faculity');
            $faculity_update->updated_by = Yii::$app->user->identity->first_name;
            $faculity_update->updated_on = date('Y-m-d h:i:s A');   
            if($faculity_update->validate()){
                $faculity_update->save();
            Yii::$app->getSession()->setFlash('success', [
            'title' => 'Faculity',
            'text' => 'Faculity Details Updated Successfully',
            'type' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
            }
                return $this->redirect('faculity');
    }
    public function actionSchoolClasses()
    {
        extract($_POST);
        $model = new Classes;
        $class_list = Classes::find()
        ->where(['status' => MyConst::_ACTIVE,'school_id' => Yii::$app->user->identity->school_id])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) ) {
                $model->school_id = Yii::$app->user->identity->school_id;
                $model->status = MyConst::_ACTIVE;
                $model->created_by = Yii::$app->user->identity->first_name;
                $model->created_on = date('Y-m-d h:i:s A');
                $model->updated_by = Yii::$app->user->identity->first_name;
                $model->updated_on = date('Y-m-d h:i:s A');
                if($model->validate()){
                    $model->save();
                    $section_names = array_filter($section_names);
                    if(!empty($section_names)){
                        for($i=0;$i<count($section_names);$i++)
                        {
                            $data[] = [$model->getPrimaryKey(),Yii::$app->user->identity->school_id
                            ,$section_names[$i],MyConst::_ACTIVE,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                            ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name];
                        }
                        Yii::$app->db
                        ->createCommand()
                        ->batchInsert('class_sections', ['class_id','school_id','section_name','section_status'
                        , 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                        ->execute();	
                    }
                Yii::$app->getSession()->setFlash('success', [
                'title' => 'Class',
                'text' => 'Class Added Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->commit();        
            return	$this->redirect('school-classes');
                }
            }    

        }  
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('schoolclasses',['model' => $model,'class_list' => $class_list]);
    }
    public function actionEditclasspopup()
    {
        extract($_POST);
        $model = Classes::findOne($id);
        $section_list = \app\models\ClassSections::find()
        ->where(['section_status' => MyConst::_ACTIVE,'class_id' => $id])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        return $this->renderAjax('editclass', ['model' => $model,'section_list' => $section_list]);   
    }
    public function actionEditclass()
    {
        extract($_POST);
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $class_arr = Yii::$app->request->post('Classes');
            $classUpdate = Classes::findOne($class_arr['id']);
            $classSections =  \app\models\ClassSections::find()->where(['class_id'=>$class_arr['id']])->asArray()->all();
            if( (trim($classUpdate['class_name']) != trim($class_arr['class_name'])) ||  (trim($classUpdate['teacher_id']) != trim($class_arr['teacher_id'])) )
            {
                $classUpdate->class_name = trim($class_arr['class_name']);
                $classUpdate->teacher_id = trim($class_arr['teacher_id']);		
                $classUpdate->save();	
            }
            if(count($classSections) > 0){
                for($i=0;$i<count($classSections);$i++)
                {
                    if($_POST['section_'.$classSections[$i]['id']] != $classSections[$i]['section_name'] )
                    {
                            $classSecModel = \app\models\ClassSections::findOne($classSections[$i]['id']);
                            $classSecModel->section_name = $_POST['section_'.$classSections[$i]['id']];
                            $classSecModel->save();
                    }
                }
            }
            $new_section_names = array_filter($section_names);
            if(!empty($new_section_names))
	        {
                for($i=0;$i<count($new_section_names);$i++)
                {
                    $data[] = [$class_arr['id'],Yii::$app->user->identity->school_id
                    ,$new_section_names[$i],MyConst::_ACTIVE,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                    ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name];
                }
                Yii::$app->db
                ->createCommand()
                ->batchInsert('class_sections', ['class_id','school_id','section_name','section_status'
                , 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                ->execute();
	        }
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Class',
                'text' => 'Class Details Updated Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->commit();        
            return	$this->redirect('school-classes');

        }  
        catch(Exception $e) {
            $transaction->rollback();
        }
    }
    public function actionExams()
    {
        extract($_POST);
        $examsModel = new Exams;
        $sql_exams_list = 'select e.id,c.class_name,e.exam_name,e.exam_start_date,e.exam_end_date,e.marks_status from exams e inner join classes c on e.class_id = c.id where 
        e.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $exams_list = Yii::$app->db->createCommand($sql_exams_list)->queryAll();
        $subject_list = Subjects::find()
        ->where(['school_id' => Yii::$app->user->identity->school_id])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();

        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($examsModel->load(Yii::$app->request->post()) ) {
                $exams_arr = Yii::$app->request->post('Exams');
                $examsModel->exam_start_date = date('Y-m-d',strtotime($exams_arr['exam_start_date']));
                $examsModel->exam_end_date = date('Y-m-d',strtotime($exams_arr['exam_end_date']));
                $examsModel->school_id = Yii::$app->user->identity->school_id;
                $examsModel->created_by = Yii::$app->user->identity->first_name;
                $examsModel->created_on = date('Y-m-d h:i:s A');
                $examsModel->updated_by = Yii::$app->user->identity->first_name;
                $examsModel->updated_on = date('Y-m-d h:i:s A');
				$examsModel->marks_status = 0;
                if($examsModel->validate()){
                    $examsModel->save();
                    $subject_name = array_filter($subject_name);
                    if(!empty($subject_name)){
                        for($i=0;$i<count($subject_name);$i++)
                        {
                            $data[] = [$examsModel->getPrimaryKey(),$subject_name[$i]
                            ,date('Y-m-d',strtotime($exam_date[$i])),date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                            ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name];
                        }
                        Yii::$app->db
                        ->createCommand()
                        ->batchInsert('exam_details', ['exam_id','subject_id','exam_date'
                        , 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                        ->execute();	
                    }
                Yii::$app->getSession()->setFlash('success', [
                'title' => 'Exam',
                'text' => 'Exam Added Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->commit();        
            return	$this->redirect('exams');
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('exams',['examsModel' => $examsModel, 'exams_list' => $exams_list,'subject_list'=>$subject_list]);
    }
    public function actionEditexampopup()
    {
        extract($_POST);
        $model = Exams::findOne($id);
        $exams_list = \app\models\ExamDetails::find()
        ->where(['exam_id' => $id])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        $subject_list = Subjects::find()
        ->where(['school_id' => Yii::$app->user->identity->school_id])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        return $this->renderAjax('editexam', ['examsModel' => $model,'exams_list' => $exams_list,'subject_list'=>$subject_list]);   
    }
    public function actionEditexam()
    {
        extract($_POST);
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            $exam_arr = Yii::$app->request->post('Exams');
            $examUpdate = Exams::findOne($exam_arr['id']);
            $exam_details =  \app\models\ExamDetails::find()->where(['exam_id'=>$exam_arr['id']])->asArray()->all();
            if( (trim($examUpdate['exam_name']) != trim($exam_arr['exam_name'])) 
            ||  (trim($examUpdate['exam_start_date']) != trim($exam_arr['exam_start_date']))
            ||  (trim($examUpdate['exam_end_date']) != trim($exam_arr['exam_end_date']))
            )
            {
                $examUpdate->exam_name = trim($exam_arr['exam_name']);
                $examUpdate->class_id = trim($exam_arr['class_id']);
                $examUpdate->exam_start_date = trim(date('Y-m-d',strtotime($exam_arr['exam_start_date'])));
                $examUpdate->exam_end_date = trim(date('Y-m-d',strtotime($exam_arr['exam_end_date'])));		
                $examUpdate->save();	
            }
            if(count($exam_details) > 0){
                for($i=0;$i<count($exam_details);$i++)
                {
                    if($_POST['exam_'.$exam_details[$i]['id']] != $exam_details[$i]['subject_id'] 
                    || $_POST['exam_date_'.$exam_details[$i]['id']] != date('Y-m-d',strtotime($exam_details[$i]['exam_date']))
                    )
                    {
                            $examDetModel = \app\models\ExamDetails::findOne($exam_details[$i]['id']);
                            $examDetModel->subject_id = $_POST['exam_'.$exam_details[$i]['id']];
                            $examDetModel->exam_date = date('Y-m-d',strtotime($_POST['exam_date_'.$exam_details[$i]['id']]));
                            $examDetModel->save();
                    }
                }
            }
            $new_subject_name = array_filter($update_subject_name);
            if(!empty($new_subject_name))
	        {
                for($i=0;$i<count($new_subject_name);$i++)
                {
                    $data[] = [$exam_arr['id'],$new_subject_name[$i]
                    ,date('Y-m-d',strtotime($update_exam_date[$i])),date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                    ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name];
                }
                Yii::$app->db
                ->createCommand()
                ->batchInsert('exam_details', ['exam_id','subject_id','exam_date'
                , 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                ->execute();
	        }
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Exam',
                'text' => 'Exam Details Updated Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->commit();        
            return	$this->redirect('exams');

        }  
        catch(Exception $e) {
            $transaction->rollback();
        }
    }
    public function actionSamplesave()
    {
        $subjectsModel = new Subjects;
        $subject_list = Subjects::find()
        ->where(['status' => MyConst::_ACTIVE])
        ->orderBy([
            'id'=>SORT_DESC
        ])
        ->asArray()->all();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) ) {
                $schools_arr = Yii::$app->request->post('Schools');
                $subjectsModel->status = MyConst::_ACTIVE;
                $subjectsModel->created_by = Yii::$app->user->identity->first_name;
                $subjectsModel->created_on = date('Y-m-d h:i:s A');
                $subjectsModel->updated_by = Yii::$app->user->identity->first_name;
                $subjectsModel->updated_on = date('Y-m-d h:i:s A');

                if($model->validate()){
                $subjectsModel->status = MyConst::_ACTIVE;
                $subjectsModel->created_by = Yii::$app->user->identity->first_name;
                $subjectsModel->created_on = date('Y-m-d h:i:s A');
                $subjectsModel->updated_by = Yii::$app->user->identity->first_name;
                $subjectsModel->updated_on = date('Y-m-d h:i:s A');

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
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('subjects',['subjectsModel' => $subjectsModel, 'subject_list' => $subject_list]);
    }
    public function actionSectionslist($id = '')
    {				
		extract($_REQUEST);
        $sections = \app\models\ClassSections::find()
				->where(['class_id' => $id])
				->andWhere(['school_id'=>Yii::$app->user->identity->school_id])
				->all();

		if (!empty($sections)) {
						echo "<option value=''>Select Section</option>"; 

			foreach($sections as $sections) {
			echo "<option value='".$sections->id."'>".$sections->section_name."</option>";
			}
		} else {
			echo "<option value=''>Select Section</option>";
		}
		
    }
	public function actionSubmitmarks()
    {	
        extract($_POST);
        $examModel = Exams::findOne($id);
        //Exam and subject details
        $sqlSubjects = 'select sub.*,e.id as exam_id from exams e
                inner join exam_details ed on ed.exam_id = e.id
                inner join subjects sub on sub.id=ed.subject_id 
                where e.id=\''.$id.'\'
                and e.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $subjects = Yii::$app->db->createCommand($sqlSubjects)->queryAll();
        //students 
        $sqlstudents = 'select s.*  from exams e
                inner join students s on s.student_class=e.class_id
				where e.id=\''.$id.'\'';
        $students = Yii::$app->db->createCommand($sqlstudents)->queryAll();
        //Marks
        $marks = [];
        $sqlmarks = 'select * from marks
                  where exam_id=\''.$id.'\' and school_id=\''.Yii::$app->user->identity->school_id.'\'';
        $marks = Yii::$app->db->createCommand($sqlmarks)->queryAll();
        $marksArr = (Yii\helpers\ArrayHelper::index($marks,null, 'student_id'));       
    //        $marksArr = array_column($marks,'marks','student_id');
        return $this->render('marks',['marks'=>$marksArr,'subjects'=>$subjects,'students'=>$students, 'examModel'=>$examModel]);
    }
    public function actionUpdatemarks(){
        extract($_POST);
        $marks_status = 0;
        if(isset($save)){
            $marks_status=1;
        } else if(isset($closeExam)){
            $marks_status=2;
        }
        $sqlSubjects = 'select ed.subject_id from exams e
                inner join exam_details ed on ed.exam_id = e.id
                where e.id=\''.$exam_id.'\'
                and e.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $subjects = Yii::$app->db->createCommand($sqlSubjects)->queryAll();
        $subjectIdArr = array_column($subjects,'subject_id');
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            for($i=0; $i<count($student_id); $i++){
                for($j=0; $j<count($subjectIdArr); $j++){
                    $data[]= [$exam_id, $student_id[$i],$subjectIdArr[$j] ,
                    $_POST['subject_'.$subjectIdArr[$j]][$i], Yii::$app->user->identity->school_id,
                    date('Y-m-d h:i:s A'), Yii::$app->user->identity->first_name
                    ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name];
                }
            }
            //Marks update
            Yii::$app->db
                ->createCommand()
                ->batchInsert('marks', ['exam_id','student_id','subject_id','marks','school_id'
                , 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                ->execute();	
            //Exam marks status update
            $sqlUpdate = 'update exams set marks_status = \''.$marks_status.'\', 
                      updated_by = \''.Yii::$app->user->identity->first_name.'\',
	              updated_on = \''.date('Y-m-d H:i:s').'\'
                      where ID = \''.$exam_id.'\'';
            $resUpdate = Yii::$app->db->createCommand($sqlUpdate)->execute();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Marks',
                'text' => 'Marks Updated Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->commit();
            return $this->redirect('exams');
        } catch(Exception $e) {
            $transaction->rollback();
        }
    }
    public function actionViewmarks()
    {
        extract($_POST);
        $examModel = Exams::findOne($id);
        //Exam and subject details
        $sqlSubjects = 'select sub.*,e.id as exam_id from exams e
                inner join exam_details ed on ed.exam_id = e.id
                inner join subjects sub on sub.id=ed.subject_id 
                where e.id=\''.$id.'\'
                and e.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $subjects = Yii::$app->db->createCommand($sqlSubjects)->queryAll();
        //students 
        $sqlstudents = 'select s.*  from exams e
                inner join students s on s.student_class=e.class_id where e.id=\''.$id.'\'';
        $students = Yii::$app->db->createCommand($sqlstudents)->queryAll();
        //Marks
        $marks = [];
        $sqlmarks = 'select * from marks
                  where exam_id=\''.$id.'\' and school_id=\''.Yii::$app->user->identity->school_id.'\'';
        $marks = Yii::$app->db->createCommand($sqlmarks)->queryAll();
        $marksArr = (Yii\helpers\ArrayHelper::index($marks,null, 'student_id'));       
        return $this->renderAjax('viewMarks',['marks'=>$marksArr,'subjects'=>$subjects,'students'=>$students, 'examModel'=>$examModel]);   
    }

    public function actionClasswisefee()
    {
        $feeModel = new SchoolFee;
        $sql_fee_list = 'select class_name,sf.* from school_fee sf
        inner join classes c on c.id = sf.class_id
        where fee_status = \''.MyConst::_ACTIVE.'\' and sf.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $fee_list = Yii::$app->db->createCommand($sql_fee_list)->queryAll();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($feeModel->load(Yii::$app->request->post()) ) {
                $feeModel->school_id = Yii::$app->user->identity->school_id;
                $feeModel->fee_status = MyConst::_ACTIVE;
                $feeModel->created_by = Yii::$app->user->identity->first_name;
                $feeModel->created_on = date('Y-m-d h:i:s A');
                $feeModel->updated_by = Yii::$app->user->identity->first_name;
                $feeModel->updated_on = date('Y-m-d h:i:s A');

                if ($feeModel->validate()) {
                    Yii::$app->getSession()->setFlash('success', [
                        'title' => 'Fee',
                        'text' => 'Fee Created Successfully',
                        'type' => 'success',
                        'timer' => 3000,
                        'showConfirmButton' => false
                    ]);
                    $feeModel->save();
                    $transaction->commit();
                    return	$this->redirect('classwisefee');
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('classwisefee',['feeModel' => $feeModel, 'fee_list' => $fee_list]);
    }
    public function actionEditfeepopup()
    {
        extract($_POST);
        $feeModel = SchoolFee::findOne($id);
        return $this->renderAjax('editfee', ['feeModel' => $feeModel]);   

    }
    public function actionEditfee()
    {
            $model = new SchoolFee;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $fee_arr = Yii::$app->request->post('SchoolFee');
            $fee_update = SchoolFee::findOne($_POST['SchoolFee']['id']);
            $fee_update->attributes = \Yii::$app->request->post('SchoolFee');
            $fee_update->updated_by = Yii::$app->user->identity->first_name;
            $fee_update->updated_on = date('Y-m-d h:i:s A');   
            if($fee_update->validate()){
                $fee_update->save();
                Yii::$app->getSession()->setFlash('success', [
            'title' => 'Fee',
            'text' => 'Fee Updated Successfully',
            'type' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
            }
                return $this->redirect('classwisefee');
    }
    public function actionMainattendance()
    {
        
        $sql_class_list = 'select c.*,cs.section_name,cs.id as section_id from classes c left join class_sections cs 
        on c.id = cs.class_id and cs.section_status = \''.MyConst::_ACTIVE.'\' 
        where c.status = \''.MyConst::_ACTIVE.'\' 
        and c.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $class_list = Yii::$app->db->createCommand($sql_class_list)->queryAll();
        return $this->render('mainattendance', ['class_list' => $class_list]);
    }
    public function actionAdmindashboard()
    {
        return $this->render('admindashboard');
    }
    public function actionNoticeboard()
    {
        $noticeModel = new NoticeBoard;
        $sql_notice_list = 'select * from notice_board nb
        where notice_status = \''.MyConst::_ACTIVE.'\' 
        and school_id = \''.Yii::$app->user->identity->school_id.'\' order by created_on desc';
        $notice_list = Yii::$app->db->createCommand($sql_notice_list)->queryAll();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($noticeModel->load(Yii::$app->request->post()) ) {
                $notice_arr = Yii::$app->request->post('NoticeBoard');
                $noticeModel->school_id = Yii::$app->user->identity->school_id;
                $noticeModel->notice_start_date = date('Y-m-d',strtotime($notice_arr['notice_start_date']));
                $noticeModel->notice_end_date = date('Y-m-d',strtotime($notice_arr['notice_end_date']));
                $noticeModel->notice_status = MyConst::_ACTIVE;
                $noticeModel->created_by = Yii::$app->user->identity->first_name;
                $noticeModel->created_on = date('Y-m-d h:i:s A');
                $noticeModel->updated_by = Yii::$app->user->identity->first_name;
                $noticeModel->updated_on = date('Y-m-d h:i:s A');

                if ($noticeModel->validate()) {
                    Yii::$app->getSession()->setFlash('success', [
                        'title' => 'Notice',
                        'text' => 'Notice Created Successfully',
                        'type' => 'success',
                        'timer' => 3000,
                        'showConfirmButton' => false
                    ]);
                    $noticeModel->save();
                    $transaction->commit();
                    return	$this->redirect('noticeboard');
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }    
        return $this->render('noticeboard',['noticeModel' => $noticeModel, 'notice_list' => $notice_list]);
    }
    public function actionClassattendance(){
        extract($_POST);
        $sql = 'select s.*,a.attendance_status,a.attendance_date
                from students s
                left join attendance a on a.student_id=s.id and a.attendance_date=\''.date('Y-m-d',strtotime($attendance_date)).'\'
                where s.student_class=\''.$id.'\' ';
                if(!empty($section_id)){
                    $sql .= ' and student_section = \''.$section_id.'\' ';
                }
                 
                $sql .= ' and  s.school_id=\''.Yii::$app->user->identity->school_id.'\'';
        $students = Yii::$app->db->createCommand($sql)->queryAll();
        $attendance = \app\models\Attendance::find()
				->where(['class_id' => $id])
				->andWhere(['school_id'=>Yii::$app->user->identity->school_id])
                                ->andWhere(['attendance_date'=> date('Y-m-d',strtotime($attendance_date))])
				->all();
        $classDet = Classes::findOne($id);         
        return $this->render('classAttendance',['students'=>$students,'classid'=>$id
        ,'attendance'=>$attendance,'classDet' => $classDet,'section_id' => $section_id, 'attendance_date' => $attendance_date]);
    }
    public function actionSaveattendance(){
        extract($_POST);
        $atendanceDet = $attendance = \app\models\Attendance::find()
				->where(['class_id' => $classid])
				->andWhere(['school_id'=>Yii::$app->user->identity->school_id])
                                ->andWhere(['attendance_date'=> date('Y-m-d',strtotime($attendance_date))])
				->all();
        if(count($atendanceDet) > 0){
            /*
             * Attendance records exist for date
             *Updating Attendance data 
             */
             for($i=0;$i<count($studentid);$i++){
                $update = 'update attendance set
                    attendance_status='.$attendance_status_hidden[$i].', 
                    updated_on=\''.date('Y-m-d').'\', updated_by=\''.Yii::$app->user->identity->first_name.'\'
                    where attendance_date=\''.date('Y-m-d',strtotime($attendance_date)).'\'
                    and class_id=\''.$classid.'\'  and section_id = \''.$section_id.'\' and student_id=\''.$studentid[$i].'\'
                    and school_id=\''.Yii::$app->user->identity->school_id.'\'';
                $resUpdate = Yii::$app->db->createCommand($update)->execute();
             }
             Yii::$app->getSession()->setFlash('success', [
                'title' => 'Attendance',
                'text' => 'Attendance Updated Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
            
        } else {
             
            /*
             * No Attendance data found for date
             */
            for($i=0;$i<count($studentid);$i++){
                $data[] = [
                    $studentid[$i], $attendance_status_hidden[$i], 
                    date('Y-m-d',strtotime($attendance_date)),$classid,$section_id,Yii::$app->user->identity->school_id
                    ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                    ,date('Y-m-d h:i:s A'),Yii::$app->user->identity->first_name
                ];
            }
            Yii::$app->db->createCommand()
                ->batchInsert('attendance', ['student_id','attendance_status','attendance_date'
                ,'class_id','section_id', 'school_id', 'created_on', 'created_by', 'updated_on', 'updated_by'],$data)
                ->execute();
            Yii::$app->getSession()->setFlash('success', [
                'title' => 'Attendance',
                'text' => 'Attendance added Successfully',
                'type' => 'success',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
        }
        return $this->redirect('mainattendance');
    }
    public function actionEditnoticepopup()
    {
        extract($_POST);
        $noticeModel = NoticeBoard::findOne($id);
        return $this->renderAjax('editnotice', ['noticeModel' => $noticeModel]);   

    }
    public function actionEditnotice()
    {
            $model = new NoticeBoard;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $notice_arr = Yii::$app->request->post('NoticeBoard');
            $notice_update = NoticeBoard::findOne($_POST['NoticeBoard']['id']);
            $notice_update->attributes = \Yii::$app->request->post('NoticeBoard');
            $notice_update->notice_start_date = date('Y-m-d',strtotime($notice_arr['notice_start_date']));
            $notice_update->notice_end_date = date('Y-m-d',strtotime($notice_arr['notice_end_date']));
            $notice_update->updated_by = Yii::$app->user->identity->first_name;
            $notice_update->updated_on = date('Y-m-d h:i:s A');   
            if($notice_update->validate()){
                $notice_update->save();
                Yii::$app->getSession()->setFlash('success', [
            'title' => 'Notice',
            'text' => 'Notice Updated Successfully',
            'type' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
            }
                return $this->redirect('noticeboard');
    }
    public function actionAttendanceview()
    {
        extract($_POST);
        $attendance_dates = [];
        $new_arr = []; 
        $class_arr = [];
        $student_arr = [];
        $class_id = $class_id ?? null;
        $sql_classes = 'select id,class_name from classes c where school_id = \''.Yii::$app->user->identity->school_id.'\'
        and  c.status = \''.MyConst::_ACTIVE.'\'';
        $res_classes = Yii::$app->db->createCommand($sql_classes)->queryAll();
        $start_date = isset($start_date) ? date('Y-m-d',strtotime($start_date)) : date('Y-m-d');
        $end_date =  isset($end_date) ? date('Y-m-d',strtotime($end_date)) : date('Y-m-d');

        if (isset($class_id)) {
            $class_list = Classes::findOne($class_id);
            $class_arr = array_column((array)$class_list,'class_name','id');
            $sql_student_list = 'select id, concat(first_name,last_name) first_name 
            from students
            where school_id =  \''.Yii::$app->user->identity->school_id.'\' 
            and student_class = \''.$class_id.'\'';
            $student_list = Yii::$app->db->createCommand($sql_student_list)->queryAll();

            $student_arr =  array_column((array)$student_list,'first_name','id');
            $sql_attendance = 'select * from attendance where attendance_date between \''.$start_date.'\' 
            and \''.$end_date.'\' and class_id = \''.$class_id.'\' ';
            if(!empty($section_id)){
                $sql_attendance .= ' and section_id =\''.$section_id.'\' ';
            }
            $res_attendance = Yii::$app->db->createCommand($sql_attendance)->queryAll();
            if(!empty($res_attendance)) {
                $attendance_dates = (array_values(array_unique(array_column($res_attendance,'attendance_date'))));
                for($i=0;$i<count($res_attendance);$i++)
                {
                    $new_arr[$res_attendance[$i]['student_id']][$res_attendance[$i]['attendance_date']] = $res_attendance[$i]['attendance_status']; 
                }
               
            }
        }
        return $this->render('attendanceview', ['res_classes' => $res_classes, 'start_date' => $start_date
                            ,'end_date' => $end_date,'attendance_dates' => $attendance_dates
                            ,'class_arr' => $class_arr , 'new_arr' => $new_arr
                            , 'student_arr' => $student_arr,'class_id' =>$class_id] );
    }
    public function actionStudentwisefee(){
        $feeModel = new StudentPaidFee;
        $sql_fee_paid = 'select class_name, s.first_name, s.last_name,sf.* from student_paid_fee sf
            inner join classes c on c.id = sf.class_id
            join students s on s.id=sf.student_id
            where sf.status = \''.MyConst::_ACTIVE.'\'
            and sf.school_id = \''.Yii::$app->user->identity->school_id.'\'';
        $fee_paid_details = Yii::$app->db->createCommand($sql_fee_paid)->queryAll();
        $connection = \Yii::$app->db;	
		$transaction = $connection->beginTransaction();
        try {
            if ($feeModel->load(Yii::$app->request->post()) ) {
                $feeModel->school_id = Yii::$app->user->identity->school_id;
                $feeModel->status = MyConst::_ACTIVE;
                $feeModel->paid_date = date('Y-m-d');
                $feeModel->created_by = Yii::$app->user->identity->first_name;
                $feeModel->created_on = date('Y-m-d h:i:s A');
                $feeModel->updated_by = Yii::$app->user->identity->first_name;
                $feeModel->updated_on = date('Y-m-d h:i:s A');

                if ($feeModel->validate()) {
                    Yii::$app->getSession()->setFlash('success', [
                        'title' => 'Fee',
                        'text' => 'Fee Paid Successfully',
                        'type' => 'success',
                        'timer' => 3000,
                        'showConfirmButton' => false
                    ]);
                    $feeModel->save();
                    $transaction->commit();
                    return	$this->redirect('studentwisefee');
                }
            }    
        }
        catch(Exception $e) {
            $transaction->rollback();
        }
        return $this->render('studentwisefee',['feeModel'=>$feeModel,'fee_paid_details'=>$fee_paid_details]);
    }
}
