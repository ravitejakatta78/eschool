<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\helpers\MyConst;
use app\helpers\Utility;

?>
            <?php	$form = ActiveForm::begin([
    		'id' => 'update-notice-form',
            'action' => 'editnotice',

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
            <label for = "firstname" class = "col-sm-3 control-label">Notice :</label>
            <div class = "col-sm-9">
            <?= $form->field($noticeModel, 'notice_text')->textarea(['rows' => '5', 'class' => 'form-control'
            ,'placeholder'=>'Enter Notice','autocomplete' => 'off'])->label(false); ?>
            <?= $form->field($noticeModel, 'id')->hiddeninput(['class' => 'form-control'
            ,'placeholder'=>'Enter Notice','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Notice Start Date :</label>
            <div class = "col-sm-9">
            <?= $form->field($noticeModel, 'notice_start_date')->textinput(['class' => 'form-control dateselectedit'
            ,'placeholder'=>'Enter Start Date','autocomplete' => 'off','value' => Utility::format_date($noticeModel->notice_start_date,MyConst::_D_M_Y)])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Notice End Date:</label>
            <div class = "col-sm-9">
            <?= $form->field($noticeModel, 'notice_end_date')->textinput(['class' => 'form-control dateselectedit'
            ,'placeholder'=>'Enter End Date','autocomplete' => 'off','value' => Utility::format_date($noticeModel->notice_end_date,MyConst::_D_M_Y)])->label(false); ?>
            </div>
         </div>
         <?php ActiveForm::end() ?>        
<?php
$script = <<< JS
$('.dateselectedit').datepicker({
		format: 'dd-M-yyyy',
    autoclose: true,
		// startDate: '-3d'
	});
    window.onbeforeunload = function() { return "Your work will be lost."; };
JS;
$this->registerJs($script);
?>
   
    
        
        