<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
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
              <h6 class="h2 text-white d-inline-block mb-0">Students</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Student</a>
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
              <h3 class="mb-0">Students List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="name">ID</th>
                    <th scope="col" class="sort" data-sort="name">Student Name</th>
                    <th scope="col" class="sort" data-sort="name">Parent Name</th>
                    <th scope="col" class="sort" data-sort="budget">Address</th>
                    <th scope="col" class="sort" data-sort="status">Email</th>
                    <th scope="col" class="sort" data-sort="completion">Mobile Number</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $studentcount = count($student_list);
                for($i=0;$i < $studentcount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $student_list[$i]['first_name'].' '.$student_list[$i]['last_name'];?></td>
                    <td><?= $student_list[$i]['parent_name']; ?></td>
                    <td><?= $student_list[$i]['address'] ;?></td>
                    <td><?= $student_list[$i]['email'] ;?></td>
                    <td><?= $student_list[$i]['phone'] ;?></td>
                    <td class="icons"><a onclick="editstudentpopup('<?= $student_list[$i]['id'];?>')"><span class="fa fa-pencil"></span></a> 
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
        <h4 class="modal-title">Student Admission</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <?php	$form = ActiveForm::begin([
    		'id' => 'student-form',
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
            <label for = "firstname" class = "col-sm-3 control-label">First Name :</label>
            <div class = "col-sm-9">
                <?= $form->field($studentModel, 'first_name')->textinput(['class' => 'form-control'
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
                <?= $form->field($studentModel, 'dob')->textinput(['class' => 'form-control dateselect'
                ,'placeholder'=>'Enter Date Of Birth','autocomplete' => 'off'])->label(false); ?>            
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
                <?= $form->field($studentModel, 'student_img')->textinput(['class' => 'form-control','placeholder'=>'Enter Student Image'])->label(false); ?>
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

	</div>

      <?php ActiveForm::end() ?>
      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Add Student', ['class'=> 'btn btn-primary','id' => 'save']); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div id="editstudent" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Student</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editstudentbody" class="modal-body">
  		</div>
      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Update Student', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
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
                title: 'Student List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Student List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editstudentpopup(id)
{
var request = $.ajax({
  url: "editstudentpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editstudentbody').html(msg);
	$('#editstudent').modal('show');
});		
}
$( "#save" ).click(function() {
  $( "#student-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-student-form" ).submit();
});
</script>