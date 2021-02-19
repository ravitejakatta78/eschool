<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\helpers\MyConst;
use app\helpers\Utility;

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
              <h6 class="h2 text-white d-inline-block mb-0">Exams</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Exam</a>
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
              <h3 class="mb-0">Exams List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="namid">ID</th>
                    <th scope="col" class="sort" data-sort="name">Class Name</th>
                    <th scope="col" class="sort" data-sort="name">Exam Name</th>
                    <th scope="col" class="sort" data-sort="name">Exam Start Date</th>
                    <th scope="col" class="sort" data-sort="name">Exam End Date</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
					<th>Marks</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $examscount = count($exams_list);
                for($i=0;$i < $examscount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $exams_list[$i]['class_name'];?></td>
                    <td><?= $exams_list[$i]['exam_name'];?></td>
                    <td><?= Utility::format_date($exams_list[$i]['exam_start_date'],MyConst::_D_M_Y);?></td>
                    <td><?= Utility::format_date($exams_list[$i]['exam_end_date'],MyConst::_D_M_Y);?></td>
                    <td class="icons">
                    <a onclick="editexampopup('<?= $exams_list[$i]['id'];?>')">
                      <span class="fa fa-pencil"></span>
                      </a> 
                    
                    	</td>
						<td>
                            <?php if($exams_list[$i]['marks_status'] == '2'){ ?>
                               <a onclick="viewMarks('<?= $exams_list[$i]['id'];?>')"><span class="fa fa-eye"></span></a> 
                            <?php } else { ?>
                                <a class="btn btn-primary" style="color:white" onclick="submitMarks('<?= $exams_list[$i]['id'];?>')">Submit Marks</a>
                            <?php } ?>
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
        <h4 class="modal-title">Add Exam</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

                <!-- Modal Header -->
             

      <!-- Modal body -->
      <div class="modal-body">
      <?php	$form = ActiveForm::begin([
    		'id' => 'exam-form',
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
            <?= $form->field($examsModel, 'exam_start_date')->textinput(['class' => 'form-control dateselect'
            ,'placeholder'=>'Enter Start Date','autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>
		 
		      <div class = "form-group row">
            <label for = "firstname" class = "col-sm-3 control-label">End :</label>
            <div class = "col-sm-9">
            <?= $form->field($examsModel, 'exam_end_date')->textinput(['class' => 'form-control dateselect'
            ,'placeholder'=>'Enter End Date','autocomplete' => 'off'])->label(false); ?> 
            </div>
         </div>
		</div>
    <table id="tblAddRow" class="table table-bordered table-striped">
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
                <select name="subject_name[]" class="form-control">
                <option value="">Seclect Subject</option>
                <?php for($s=0; $s < count($subject_list); $s++) { ?>
                  <option value="<?= $subject_list[$s]['id']; ?>"><?= $subject_list[$s]['subject_name']; ?></option>
                <?php } ?>
                </select>
        </td>
        <td>
                <input name="exam_date[]" class="form-control dateselect">
        </td>
            
        </tr>
        
       
    </tbody>
</table>
    </div>
         <?php ActiveForm::end() ?>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <button id="btnAddRow" class="btn btn-add btn-xs" type="button">
    Add Row
</button>
      <?= Html::submitButton('Add Exam', ['class'=> 'btn btn-primary', 'id' => 'save' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      

    </div>
  </div>
</div>

<div id="editexam" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Exam</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editexambody" class="modal-body">
  		</div>

     <!-- Modal footer -->
      <div class="modal-footer">
      <button id="btnAddRow" class="btn btn-add btn-xs" onclick="addrow()" type="button">
    Add Row
</button>
      <?= Html::submitButton('Update Exam', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
	
  	</div>
	</div>
</div>
<!--marks popup-->
<div id="viewmarks" class="modal fade" role="dialog">
   <div class="modal-dialog modal-lg" >
        <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Marks List</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="viewmarksbody" class="modal-body">
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
                title: 'Exams List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Exams List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editexampopup(id)
{
var request = $.ajax({
  url: "editexampopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editexambody').html(msg);
	$('#editexam').modal('show');
});		
}
function viewMarks(id){
    var request = $.ajax({
  url: "viewmarks",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#viewmarksbody').html(msg);
	$('#viewmarks').modal('show');
});
}
function submitMarks(id){
    
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("target", "_blank");
    form.setAttribute("action", "submitmarks");
    
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("name", "id");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);
    
    document.body.appendChild(form);
    form.submit();
}

$( "#save" ).click(function() {
  $( "#exam-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-exam-form" ).submit();
});

function addrow() {
	     var lastRow = $('#tblAddRows tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRows tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRows tbody tr:last input').val('');

}

$(document).on("click", "i[name=deleterow]", function(e) {
	 var lenRow = $('#tblAddRows tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});


// Add button Delete in row

$('#tblAddRow tbody tr')
    .find('td')
    //.append('<input type="button" value="Delete" class="del"/>')
    .parent() //traversing to 'tr' Element
    .append('<td><a href="#" class="delrow"><i class="fa fa-trash border-red text-red"></i></a></td>');



// Add row the table
$('#btnAddRow').on('click', function() {
    var lastRow = $('#tblAddRow tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRow tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRow tbody tr:last input').val('');

    $('.dateselect').datepicker({
		format: 'dd-M-yyyy',
    autoclose: true,
		// startDate: '-3d'
	});

});


// Delete row on click in the table
$('#tblAddRow').on('click', 'tr a', function(e) {
    var lenRow = $('#tblAddRow tbody tr').length;
    e.preventDefault();
    if (lenRow == 1 || lenRow <= 1) {
        alert("Can't remove all row!");
    } else {
        $(this).parents('tr').remove();
    }
});

function addrow() {
	     var lastRow = $('#tblAddRows tbody tr:last').html();
    //alert(lastRow);
    $('#tblAddRows tbody').append('<tr>' + lastRow + '</tr>');
    $('#tblAddRows tbody tr:last input').val('');

}

</script>