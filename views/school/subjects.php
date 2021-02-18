<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
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
              <h6 class="h2 text-white d-inline-block mb-0">Subjects</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Subject</a>
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
              <h3 class="mb-0">Subjects List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="name">ID</th>
                    <th scope="col" class="sort" data-sort="name">Subject Name</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $subjectcount = count($subject_list);
                for($i=0;$i < $subjectcount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $subject_list[$i]['subject_name'];?></td>
                    <td class="icons"><a onclick="editsubjectpopup('<?= $subject_list[$i]['id'];?>')"><span class="fa fa-pencil"></span></a> 
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
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Subject</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

                <!-- Modal Header -->
             

      <!-- Modal body -->
      <div class="modal-body">
      <?php	$form = ActiveForm::begin([
    		'id' => 'subject-form',
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
            <?= $form->field($subjectsModel, 'subject_name')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Subject Name','autocomplete' => 'off'])->label(false); ?>
            </div>
         </div>
         <?php ActiveForm::end() ?>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Add Subject', ['class'=> 'btn btn-primary', 'id' => 'save' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      

    </div>
  </div>
</div>

<div id="editsubject" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Subject</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editsubjectbody" class="modal-body">
  		</div>

     <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Update Subject', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
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
                title: 'Subjects List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Subjects List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editsubjectpopup(id)
{
var request = $.ajax({
  url: "editsubjectpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editsubjectbody').html(msg);
	$('#editsubject').modal('show');
});		
}

$( "#save" ).click(function() {
  $( "#subject-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-subject-form" ).submit();
});
</script>