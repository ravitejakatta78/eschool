<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \app\helpers\MyConst;
use aryelds\sweetalert\SweetAlert;

?>
<?php 
foreach (Yii::$app->session->getAllFlashes() as $message) {
    echo SweetAlert::widget([
        'options' => [
            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text' => (!empty($message['text'])) ? Html::encode($message['text']) : 'Text Not Set!',
            'type' => (!empty($message['type'])) ? $message['type'] : SweetAlert::TYPE_INFO,
            'timer' => (!empty($message['timer'])) ? $message['timer'] : 4000,
            'showConfirmButton' =>  (!empty($message['showConfirmButton'])) ? $message['showConfirmButton'] : true
        ]
    ]);
}
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Teachers</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Teacher</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Teachers List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="namid">ID</th>
                    <th scope="col" class="sort" data-sort="name">Teacher Name</th>
                    <th scope="col" class="sort" data-sort="subjectname">Subject Name</th>
                    <th scope="col" class="sort" data-sort="subjectname">Mobile</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $faculitycount = count($faculity_list);
                for($i=0;$i < $faculitycount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $faculity_list[$i]['faculity_name'];?></td>
                    <td><?= $faculity_list[$i]['subject_name'];?></td>
                    <td><?= $faculity_list[$i]['mobile'];?></td>
                    <td class="icons"><a onclick="editfaculitypopup('<?= $faculity_list[$i]['id'];?>')"><span class="fa fa-pencil"></span></a> 
                    	</td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>  

		
<!-- The Modal -->
<div class="modal fade" id="filter">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Teacher</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

                <!-- Modal Header -->
             

      <!-- Modal body -->
      <div class="modal-body">
      <?php	$form = ActiveForm::begin([
    		'id' => 'faculity-form',
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
            </div>
         </div> 

    </div>
    </div>
         <?php ActiveForm::end() ?>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Add Teacher', ['class'=> 'btn btn-primary', 'id' => 'save' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      

    </div>
  </div>
</div>

<div id="editfaculity" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Teacher Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editfaculitybody" class="modal-body">
  		</div>

     <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Update Teacher', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	
  	</div>
	</div>
</div>
<script>

    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
         //buttons: [ 'copy', 'excel', 'pdf' ]
        buttons: [
          'copy',
            {
                extend: 'excelHtml5',
                title: 'Teachers List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Teachers List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editfaculitypopup(id)
{
var request = $.ajax({
  url: "editfaculitypopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editfaculitybody').html(msg);
	$('#editfaculity').modal('show');
});		
}

$( "#save" ).click(function() {
  $( "#faculity-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-faculity-form" ).submit();
});
</script>