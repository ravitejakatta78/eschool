<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\helpers\MyConst;
use app\helpers\Utility;

?>
           <?php	$form = ActiveForm::begin([
            'id' => 'update-exam-form',
            'action' => 'editexam',
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
            <label for = "classname" class = "col-sm-3 control-label">Exam Name :</label>
            <div class = "col-sm-9">
            <?= $form->field($examsModel, 'exam_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Exam Name','autocomplete' => 'off'])->label(false); ?>   
              <?= $form->field($examsModel, 'id')->hiddeninput(['class' => 'form-control'
            ,'placeholder'=>'Enter Exam Name','autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>
		 
		      <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Class  :</label>
            <div class = "col-sm-9">
			      <?= $form->field($examsModel, 'class_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Classes::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'class_name')
				  ,['prompt'=>'Select Class'])->label(false); ?>
            </div>
         </div>
		</div>
    <div class="col-md-6">
		
		    <div class = "form-group row">
            <label for = "classname" class = "col-sm-3 control-label">Start Date :</label>
            <div class = "col-sm-9">
            <?= $form->field($examsModel, 'exam_start_date')->textinput(['class' => 'form-control dateselectedit'
            ,'placeholder'=>'Enter Start Date','value' => Utility::format_date($examsModel->exam_start_date,MyConst::_D_M_Y),'autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>
		 
		      <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">End :</label>
            <div class = "col-sm-9">
            <?= $form->field($examsModel, 'exam_end_date')->textinput(['class' => 'form-control dateselectedit'
            ,'placeholder'=>'Enter End Date','value' => Utility::format_date($examsModel->exam_end_date,MyConst::_D_M_Y),'autocomplete' => 'off'])->label(false); ?> 
            </div>
         </div>
		</div>
        <?php if(count($exams_list) > 0 ) {?>	
	<table id="tblAddRowsupdate" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Subject Name</th>
            <th>Exam Date</th>
        </tr>
    </thead>
    <tbody>
	<?php for($i=0;$i<count($exams_list);$i++){ ?>
        <tr>
			<td>
            <select name="exam_<?=$exams_list[$i]['id']; ?>" class="form-control">
                <option>Seclect Subject</option>
                <?php for($s=0; $s < count($subject_list); $s++) { ?>
                  <option value="<?= $subject_list[$s]['id']; ?>" <?php if($subject_list[$s]['id'] == $exams_list[$i]['subject_id'] ) { echo 'selected'; } ?> ><?= $subject_list[$s]['subject_name']; ?></option>
                <?php } ?>
                </select>
            </td>
			<td>
                <input name="exam_date_<?= $exams_list[$i]['id']; ?>"  class="form-control dateselectedit" value="<?=  Utility::format_date($exams_list[$i]['exam_date'],MyConst::_D_M_Y); ?>" class="form-control">
            </td>

        </tr>
    <?php } ?>   
    </tbody>
</table>
	<?php } ?>

    <table id="tblAddRows" class="table table-bordered table-striped">
    <thead>
        <tr>
          <th>Subject Name</th>
          <th>Exam Date</th>
          <th>Action</th>
	    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
                <select name="update_subject_name[]" class="form-control">
                <option value="">Seclect Subject</option>
                <?php for($us=0; $s < count($subject_list); $us++) { ?>
                  <option value="<?= $subject_list[$us]['id']; ?>"><?= $subject_list[$us]['subject_name']; ?></option>
                <?php } ?>
                </select>
        </td>
        <td>
                <input name="update_exam_date[]" class="form-control dateselectedit">
        </td>
            
        </tr>
    </tbody>
</table>
    </div>
         <?php ActiveForm::end() ?>        
<?php
$script = <<< JS

JS;
$this->registerJs($script);
?>
   
   <script>
$(document).ready(function(){
// Add button Delete in row
$('#tblAddRows tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow" ><i class="fa fa-trash border-red text-red deleterow" name="deleterow" ></i></a></td>');
	

	
});
$('.dateselectedit').datepicker({
		format: 'dd-M-yyyy',
    autoclose: true,
		// startDate: '-3d'
	});

</script>    
            
        
        