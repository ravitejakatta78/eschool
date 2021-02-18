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
              <h6 class="h2 text-white d-inline-block mb-0">Schools</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add School</a>
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
              <h3 class="mb-0">Schools List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="name">ID</th>
                    <th scope="col" class="sort" data-sort="name">School Name</th>
                    <th scope="col" class="sort" data-sort="budget">Address</th>
                    <th scope="col" class="sort" data-sort="status">Email</th>
                    <th scope="col" class="sort" data-sort="completion">Mobile Number</th>
                    <th scope="col" class="sort" data-sort="completion">Registration Number</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $schoolscount = count($school_list);
                for($i=0;$i < $schoolscount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $school_list[$i]['school_name'] ;?></td>
                    <td><?= $school_list[$i]['address'] ;?></td>
                    <td><?= $school_list[$i]['email'] ;?></td>
                    <td><?= $school_list[$i]['mobile'] ;?></td>
                    <td><?= $school_list[$i]['registration_number'] ;?></td>
                    <td class="icons"><a onclick="editschoolpopup('<?= $school_list[$i]['id'];?>')"><span class="fa fa-pencil"></span></a> 
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
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <?php	$form = ActiveForm::begin([
    		'id' => 'school-form',
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
      <?= Html::submitButton('Add School', ['class'=> 'btn btn-primary']); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      <?php ActiveForm::end() ?>
    </div>
  </div>
</div>

<div id="editschool" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update School</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editschoolbody">
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
                title: 'Schools List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Schools List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editschoolpopup(id)
{
var request = $.ajax({
  url: "editschoolpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editschoolbody').html(msg);
	$('#editschool').modal('show');
});		
}
</script>