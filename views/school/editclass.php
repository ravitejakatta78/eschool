<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
           <?php	$form = ActiveForm::begin([
            'id' => 'update-class-form',
            'action' => 'editclass',
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
            <label for = "classname" class = "col-sm-3 control-label">Class Name :</label>
            <div class = "col-sm-9">
            <?= $form->field($model, 'class_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Class Name','autocomplete' => 'off'])->label(false); ?>
            <?= $form->field($model, 'id')->hiddeninput(['class' => 'form-control'
            ,'placeholder'=>'Enter Class Name','autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>
		 
		  <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">Class Teacher :</label>
            <div class = "col-sm-9">
			      <?= $form->field($model, 'teacher_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Faculity::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'faculity_name')
				  ,['prompt'=>'Select Teacher'])->label(false); ?>
            </div>
         </div>
		</div>
        <?php if(count($section_list) > 0 ) {?>	
	<table id="tblAddRowsupdate" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Section Name</th>
        </tr>
    </thead>
    <tbody>
	<?php for($i=0;$i<count($section_list);$i++){ ?>
        <tr>
			<td>
                <input name="section_<?=$section_list[$i]['id']; ?>" value="<?= $section_list[$i]['section_name']?>" class="form-control">
            </td>
        </tr>
    <?php } ?>   
    </tbody>
</table>
	<?php } ?>

    <table id="tblAddRows" class="table table-bordered table-striped">
    <thead>
        <tr>
          <th>Section Name</th>
	    		<th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>
                <input name="section_names[]" class="form-control">
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

</script>    
            
        
        