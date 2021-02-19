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
              <h6 class="h2 text-white d-inline-block mb-0">Class Fee</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Class Fee</a>
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
              <h3 class="mb-0">Fee List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="namid">ID</th>
                    <th scope="col" class="sort" data-sort="name">Class Name</th>
                    <th scope="col" class="sort" data-sort="name">Fee Type</th>
                    <th scope="col" class="sort" data-sort="name">Fee Amount</th>
                    <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $feecount = count($fee_list);
                for($i=0;$i < $feecount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $fee_list[$i]['class_name'];?></td>
                    <td><?= \app\helpers\MyConst::_FEE_DURATION[$fee_list[$i]['fee_type']];?></td>
                    <td><?= $fee_list[$i]['fee_amount'];?></td>
                    <td class="icons">
                    <a onclick="editfeepopup('<?= $fee_list[$i]['id'];?>')">
                      <span class="fa fa-pencil"></span>
                      </a> 
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
        <h4 class="modal-title">Add Fee</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

                <!-- Modal Header -->
             

      <!-- Modal body -->
      <div class="modal-body">
      <?php	$form = ActiveForm::begin([
    		'id' => 'fee-form',
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
            <label for = "classid" class = "col-sm-3 control-label">Class Name :</label>
            <div class = "col-sm-9">
             <?= $form->field($feeModel, 'class_id')
				  ->dropdownlist(\yii\helpers\ArrayHelper::map(\app\models\Classes::find()
				  ->where(['school_id'=>Yii::$app->user->identity->school_id])->all(), 'id', 'class_name')
				  ,['prompt'=>'Select'])->label(false); ?>   
            </div>
         </div>
		    <div class = "form-group row">
            <label for = "classname" class = "col-sm-3 control-label">Fee Type :</label>
            <div class = "col-sm-9">
            <?= $form->field($feeModel, 'fee_type')
				  ->dropdownlist(\app\helpers\MyConst::_FEE_DURATION
				  ,['prompt'=>'Select'])->label(false); ?>   

            </div>
         </div>

         <div class = "form-group row">
            <label for = "feeamount" class = "col-sm-3 control-label">Fee Amount :</label>
            <div class = "col-sm-9">
            <?= $form->field($feeModel, 'fee_amount')->textinput(['class' => 'form-control'
            ,'placeholder'=>'Enter Fee Amount','autocomplete' => 'off'])->label(false); ?>   
            </div>
         </div>


         <?php ActiveForm::end() ?>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Add Exam', ['class'=> 'btn btn-primary', 'id' => 'save' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      

    </div>
  </div>
</div>

<div id="editfee" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Fee</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editfeebody" class="modal-body">
  		</div>

     <!-- Modal footer -->
      <div class="modal-footer">
      <?= Html::submitButton('Update Fee', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
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
                title: 'Fee List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Fee List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );


function editfeepopup(id)
{
var request = $.ajax({
  url: "editfeepopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editfeebody').html(msg);
	$('#editfee').modal('show');
});		
}


$( "#save" ).click(function() {
  $( "#fee-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-fee-form" ).submit();
});
</script>