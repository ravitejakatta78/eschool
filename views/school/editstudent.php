<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\MyConst;
use app\helpers\Utility;

?>
      <?php	$form = ActiveForm::begin([
            'id' => 'update-student-form',
            'action' => 'editstudent',
		    'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
            'fieldConfig' => [
        'horizontalCssClasses' => [
            
            'offset' => 'col-sm-offset-0',
            'wrapper' => 'col-sm-12 pl-0 pr-0',
        ],
		]
		]) ?>
      <!-- Modal body -->
      

    <div class="row">
		<div class="col-md-6">
		
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">First Name :</label>
            <div class = "col-sm-9">
                <?= $form->field($studentModel, 'first_name')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter First Name','autocomplete' => 'off'])->label(false); ?>

<?= $form->field($studentModel, 'id')->hiddeninput(['class' => 'form-control'
                ,'placeholder'=>'Enter First Name','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>
		 
		 <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Address :</label>
            <div class = "col-sm-9">
            <?= $form->field($studentModel, 'address')->textarea(['class' => 'form-control','rows'=>2
            ,'cols'=>2,'placeholder'=>'Enter Student Address','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Gender :</label>
            <div class = "col-sm-9">
            <?= $form->field($studentModel, 'gender')->dropDownList(
            MyConst::_GENDER, 
            ['prompt'=>'Select Gender'])->label(false); ?>
            </div>
         </div>
		 
		 
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Student Class :</label>
            <div class = "col-sm-9">
			      <?= $form->field($studentModel, 'student_class')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Classes::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'class_name')
				  ,['prompt'=>'Select',
                    'onchange'=>'
                        $.get( "'.Url::toRoute('/school/sectionslist').'", { id: $(this).val() } )
                            .done(function( data ) {
                                $( "#'.Html::getInputId($studentModel, 'student_section').'" ).html( data );
                            }
                        );
                    '])->label(false); ?>
            </div>
         </div>
		 
		 
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Student Section :</label>
            <div class = "col-sm-9">
          <?= $form->field($studentModel, 'student_section')
				  ->dropdownlist([]
				  ,['prompt'=>'Select'])->label(false); ?>
            </div>
         </div>
		 
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Admission Id :</label>
            <div class = "col-sm-9">
            <?= $form->field($studentModel, 'admission_id')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Admission Id','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>
		 
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Parent Name :</label>
            <div class = "col-sm-9">
            <?= $form->field($parentModel, 'parent_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Parent Name','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>
		 
		 
		      <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Parent Occupation :</label>
            <div class = "col-sm-9">
            <?= $form->field($parentModel, 'occupation')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Parent Occupation','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>


         
		
		</div>
        <div class="col-md-6">
            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Last Name :</label>
                <div class = "col-sm-9">
                <?= $form->field($studentModel, 'last_name')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter Last Name','autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>
            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Data of birth :</label>
                <div class = "col-sm-9">
                <?= $form->field($studentModel, 'dob')->textinput(['class' => 'form-control dateselectedit'
                ,'placeholder'=>'Enter Date Of Birth','value' => Utility::format_date($studentModel->dob,MyConst::_D_M_Y),'autocomplete' => 'off'])->label(false); ?>            
                </div>
            </div>            

            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Roll Number :</label>
                <div class = "col-sm-9">
                <?= $form->field($studentModel, 'roll_number')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter Roll Number','autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>
			
			<div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Blood Group :</label>
                <div class = "col-sm-9">
                <?= $form->field($studentModel, 'blood_group')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter Blood Group','autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>
			
            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Religion :</label>
                <div class = "col-sm-9">
              <?= $form->field($studentModel, 'religion')->dropDownList(
              MyConst::_RELIGION, 
              ['prompt'=>'Select Religion'])->label(false); ?>

                </div>
            </div>
			
			<div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Student Image :</label>
                <div class = "col-sm-9">
                <?= $form->field($studentModel, 'student_img')->fileInput(['class' => 'form-control','accept'=>'image/*'])->label(false); ?>
                </div>
            </div>
			
			<div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Parent Email :</label>
                <div class = "col-sm-9">
                <?= $form->field($parentModel, 'email')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter Parent Email','autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>
			
			
			<div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Parent Mobile :</label>
                <div class = "col-sm-9">
                <?= $form->field($parentModel, 'phone')->textinput(['class' => 'form-control'
                ,'placeholder'=>'Enter Parent Mobile Number','autocomplete' => 'off'])->label(false); ?>
                </div>
            </div>

            <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Parent Type :</label>
            <div class = "col-sm-9">
            <?= $form->field($parentModel, 'parent_type')->dropDownList(
            MyConst::PARENT_TYPE, 
            ['prompt'=>'Select Type'])->label(false); ?>
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
$(document).ready(function(){

    $('.dateselectedit').datepicker({
		format: 'dd-M-yyyy',
    autoclose: true,
		// startDate: '-3d'
	});
	
});

</script>    
            
        
        