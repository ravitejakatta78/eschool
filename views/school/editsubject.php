<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
     <?php	$form = ActiveForm::begin([
            'id' => 'update-subject-form',
            'action' => 'editsubject',
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
            <label for = "firstname" class = "col-sm-3 control-label">Subject Name :</label>
            <div class = "col-sm-9">
            <?= $form->field($model, 'subject_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Subject Name','autocomplete' => 'off'])->label(false); ?>
            <?= $form->field($model, 'id')->hiddeninput(['class' => 'form-control','placeholder'=>'Enter Subject Name'])->label(false); ?>

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
        
        