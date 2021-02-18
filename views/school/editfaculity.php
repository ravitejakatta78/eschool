<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \app\helpers\MyConst;

?>
<?php	$form = ActiveForm::begin([
            'id' => 'update-faculity-form',
            'action' => 'editfaculity',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>
 <div class="row">
		<div class="col-md-6">
		
		    <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Teacher Name :</label>
            <div class = "col-sm-9">
            <?= $form->field($faculityModel, 'faculity_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Faculity Name','autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>
		 
		      <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Qualification :</label>
            <div class = "col-sm-9">
            <?= $form->field($faculityModel, 'qualification')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Faculity Qualification','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>
         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Gender :</label>
            <div class = "col-sm-9">
            <?= $form->field($faculityModel, 'gender')->dropDownList(
            MyConst::_GENDER, 
            ['prompt'=>'Select Gender'])->label(false); ?>
            </div>
         </div>         
		
		</div>
		<div class="col-md-6">
          <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Subject Name :</label>
            <div class = "col-sm-9">
			      <?= $form->field($faculityModel, 'subject_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Subjects::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'subject_name')
				  ,['prompt'=>'Select Subject',])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Email :</label>
            <div class = "col-sm-9">
            <?= $form->field($faculityModel, 'email')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Faculity Email','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Mobile Number :</label>
            <div class = "col-sm-9">
            <?= $form->field($faculityModel, 'mobile')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Faculity Mobile Number','autocomplete' => 'off'])->label(false); ?>
                       <?= $form->field($faculityModel, 'id')->hiddeninput(['class' => 'form-control'
            ,'autocomplete' => 'off'])->label(false); ?>
            </div>
         </div> 

    </div>
    </div>
         <?php ActiveForm::end() ?>

        
<?php
$script = <<< JS

JS;
$this->registerJs($script);
?>
   
<script>

</script>    
        
        