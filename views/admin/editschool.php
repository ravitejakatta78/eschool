<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
      <?php	$form = ActiveForm::begin([
			'id' => 'update-school-form',
			'action' => 'editschool',
		'options' => ['class' => 'form-horizontal','wrapper' => 'col-xs-12',],
        	'layout' => 'horizontal',
			'fieldConfig' => [
	   'horizontalCssClasses' => [
		   
		   'offset' => 'col-sm-offset-0',
		   'wrapper' => 'col-sm-12 pl-0 pr-0',
	   ],
	   ]
		]) ?>
      <!-- Modal body -->
      <div class="modal-body">

    <div class="row">
		<div class="col-md-6">
		
		<div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">School Name :</label>
            <div class = "col-sm-9">
                <?= $form->field($model, 'school_name')->textinput(['class' => 'form-control','placeholder'=>'Enter School Name'])->label(false); ?>
                <?= $form->field($model, 'id')->hiddeninput(['class' => 'form-control'])->label(false); ?>

            </div>
         </div>
		 
		 <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Address :</label>
            <div class = "col-sm-9">
            <?= $form->field($model, 'address')->textarea(['class' => 'form-control','rows'=>2,'cols'=>2,'placeholder'=>'Enter School Address'])->label(false); ?>
            </div>
         </div>

         <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Registration Number :</label>
            <div class = "col-sm-9">
            <?= $form->field($model, 'registration_number')->textinput(['class' => 'form-control','placeholder'=>'Enter School Registration Number'])->label(false); ?>
            </div>
         </div>
         
		
		</div>
        <div class="col-md-6">
            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Email :</label>
                <div class = "col-sm-9">
                <?= $form->field($model, 'email')->textinput(['class' => 'form-control','placeholder'=>'Enter School Email'])->label(false); ?>
                </div>
            </div>
            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Phone Number :</label>
                <div class = "col-sm-9">
                <?= $form->field($model, 'mobile')->textinput(['class' => 'form-control','placeholder'=>'Enter School Phone Number'])->label(false); ?>            
                </div>
            </div>            

            <div class = "form-group row">
                <label for = "firstname" class = "col-sm-3 control-label">Landline :</label>
                <div class = "col-sm-9">
                <?= $form->field($model, 'landline')->textinput(['class' => 'form-control','placeholder'=>'Enter Landline Number'])->label(false); ?>
                </div>
            </div>
            

            </div>
        </div>

	</div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Update School', ['class'=> 'btn btn-primary']); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      <?php ActiveForm::end() ?>
        
<?php
$script = <<< JS

JS;
$this->registerJs($script);
?>
   
<script>

</script>    
        
        