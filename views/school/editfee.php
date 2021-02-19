<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
           <?php	$form = ActiveForm::begin([
            'id' => 'update-fee-form',
            'action' => 'editfee',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			 'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>
     <div class = "form-group row">
            <label for = "classid" class = "col-sm-3 control-label">Class Name :</label>
            <div class = "col-sm-9">
             <?= $form->field($feeModel, 'class_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Classes::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'class_name')
				  ,['prompt'=>'Select'])->label(false); ?>   
            </div>
         </div>
		    <div class = "form-group row">
            <label for = "classname" class = "col-sm-3 control-label">Fee Type :</label>
            <div class = "col-sm-9">
            <?= $form->field($feeModel, 'fee_type')
				  ->dropdownlist(\app\helpers\MyConst::_FEE_DURATION
				  ,['prompt'=>'Select'])->label(false); ?>   

            </div>
         </div>

         <div class = "form-group row">
            <label for = "feeamount" class = "col-sm-3 control-label">Fee Amount :</label>
            <div class = "col-sm-9">
            <?= $form->field($feeModel, 'fee_amount')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Fee Amount','autocomplete' => 'off'])->label(false); ?>   
            <?= $form->field($feeModel, 'id')->hiddeninput(['class' => 'form-control'
            ,'placeholder'=>'Enter Id','autocomplete' => 'off'])->label(false); ?>    
            </div>
         </div>
    <?php ActiveForm::end() ?>          
        