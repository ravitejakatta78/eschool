<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="header bg-primary pb-6 content">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-10 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Class Wise Attendence</h6>
              
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="card">
        <div class="card-body">
          <form class = "form-inline" method="POST" role = "form">
            <div class="row">
              
             <div class = "form-group mr-2">
                <select class="form-control" name="class_id" id="class_id" onchange="getSections()">
                  <option>Select Class</option>
                  <?php for ( $c = 0; $c < count($res_classes); $c++ ) { ?> 
                  <option value="<?= $res_classes[$c]['id']; ?>" <?php if($res_classes[$c]['id'] == $class_id) { echo 'selected'; } ?> ><?= $res_classes[$c]['class_name']; ?></option>
                  <?php } ?>
                </select>
             </div>
             <div class = "form-group mr-2">
              <select id="section_id" name="section_id" class="form-control">
               <option value="">Select Section</option>
              </select>
           </div>
           <div class = "form-group mr-2">
            <input type = "text" class = "form-control dateselect" id="start_date" name="start_date" 
            value="<?= date('d-M-Y',strtotime($start_date)); ?>">
           </div>
           <div class = "form-group mr-2">
            <input type = "text" class = "form-control dateselect" id="end_date" name="end_date" 
            value="<?= date('d-M-Y',strtotime($end_date)); ?>">
           </div>
           <div class = "form-group mr-2">
            <button class="btn-primary btn">Submit</button>
           </div>
            </div>
          </form>
          <div class="table-responsive">
              <table class="table align-items-center table-flush" id="example">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sort" data-sort="id">ID</th>
                    <th scope="col" class="sort" data-sort="name">Student Name</th>
                    <?php 
                    function compare($a, $b)
                    {
                        return strtotime($a) - strtotime($b);
                    }
                    usort($attendance_dates, 'compare');
                    for($a = 0; $a < count($attendance_dates) ; $a++){ ?> 
                    <th scope="col" class="sort" data-sort="attendance"><?= date('d-M-Y',strtotime($attendance_dates[$a])) ; ?>
                    <?php } ?>
                </tr>
                </thead>
                <tbody class="list">
                <?php 
                $n = 0;
                foreach($new_arr as $key => $value) {
                  $n++;
                  ?>
                  <tr>
                    <td><?= $n; ?></td>
                    <td><?= $student_arr[$key]; ?></td>
                    <?php for($s = 0; $s < count($attendance_dates) ; $s++) { ?>
                      <td><?php if($value[$attendance_dates[$s]] == '1') { ?>
                      P  
                      <?php }
                      else if ($value[$attendance_dates[$s]] == '2') { ?>
                      A
                      <?php } ?>
                      </td>
                    <?php } ?> 
                  </tr>
                <?php } ?>
                </tbody>
              </table>
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
                title: 'Attendance List'
            },
            {
                extend: 'pdfHtml5',
                title: 'Attendance List'
            }
        ]

    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );

   
} );
</script>