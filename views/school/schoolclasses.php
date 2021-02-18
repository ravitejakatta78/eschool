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
              <h6 class="h2 text-white d-inline-block mb-0">Classes</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Class</a>
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
              <h3 class="mb-0">Classes List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="namid">ID</th>
                    <th scope="col" class="sort" data-sort="name">Class Name</th>
                     <th scope="col" class="sort" data-sort="completion">Action</th>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $classcount = count($class_list);
                for($i=0;$i < $classcount ; $i++ ){ ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td><?= $class_list[$i]['class_name'];?></td>
                    <td class="icons"><a onclick="editclasspopup('<?= $class_list[$i]['id'];?>')"><span class="fa fa-pencil"></span></a> 
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
    		'id' => 'class-form',
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
    <table id="tblAddRow" class="table table-bordered table-striped">
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

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      <button id="btnAddRow" class="btn btn-add btn-xs" type="button">
    Add Row
</button>
      <?= Html::submitButton('Add Class', ['class'=> 'btn btn-primary', 'id' => 'save' ]); ?>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

      

    </div>
  </div>
</div>

<div id="editclass" class="modal fade" role="dialog">
  <div class="modal-dialog " >
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Update Classes</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
	    <div  id="editclassbody" class="modal-body">
  		</div>

     <!-- Modal footer -->
      <div class="modal-footer">
      <button id="btnAddRow" class="btn btn-add btn-xs" onclick="addrow()" type="button">
    Add Row
</button>
      <?= Html::submitButton('Update Class', ['class'=> 'btn btn-primary', 'id' => 'edit' ]); ?>
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


function editclasspopup(id)
{
var request = $.ajax({
  url: "editclasspopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editclassbody').html(msg);
	$('#editclass').modal('show');
});		
}

$( "#save" ).click(function() {
  $( "#class-form" ).submit();
});

$( "#edit" ).click(function() {
  $( "#update-class-form" ).submit();
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