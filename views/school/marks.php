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
              <h6 class="h2 text-white d-inline-block mb-0">Marks</h6>
            </div>
<!--            <div class="col-lg-6 col-5 text-right">
              <a href="#" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#filter">Add Exam</a>
            </div>-->
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
              <h3 class="mb-0">Marks List</h3>
            </div>
            <!-- Light table -->
            <div class="table-responsive">
                <form id="marks_form" method="post" action="updatemarks">
                <input type="hidden" id="exam_id" name="exam_id" value="<?= $examModel['id'] ?>">
                <table class="table align-items-center table-flush" >
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="namid">S.No.</th>
                    <th scope="col" class="sort" data-sort="name">Student Name</th>
                    <?php foreach($subjects as $sub){ ?>
                    <th scope="col" class="sort" data-sort="name"><?= $sub['subject_name']; ?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $studentcount = count($students);
				//echo '<pre>';print_r($students);exit;
				$newMarksArr =[];
                for($i=0;$i < $studentcount ; $i++ ){ 
					if(!empty($marks)){
						$studentMarkMainArr = $marks[$students[$i]['id']];
                        $newMarksArr = array_column($studentMarkMainArr,'marks','subject_id'); 
					}
                     
                      ?> 
                <tr>
                    <td><?= ($i+1) ;?></td>
                    <td>
                        <?= $students[$i]['first_name'].' '.$students[$i]['last_name'];?>
                        <input type="hidden" name="student_id[]" value="<?= $students[$i]['id'] ?>" class="form-control">
                    </td>
                    <?php foreach($subjects as $sub){ 
                       
                        ?>
                    <td>
                        <input type="text" name="subject_<?=$sub['id'] ?>[]" 
                               value="<?php echo $newMarksArr[$sub['id']] ?? ''; ?>" class="form-control">
                    </td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
              </table>
                <div style="float:right">
                    <button class="btn btn-primary text-white" name="save">Save</button>
                    <button class="btn btn-primary text-white" name="closeExam">Close Exam</button>
                </div>
                </form>
            </div>

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

</script>