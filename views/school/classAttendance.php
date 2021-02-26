    <div class="header bg-primary pb-6 content">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-10 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Students Attendence - 9th class</h6>
              
            </div>
            <div class="col-lg-2 col-5 text-right">
              <input id="myInput" type="text" class="form-control" placeholder="Search Student">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <!--1-->
    <form method="post" action="saveattendance">
        <input type="hidden" name="classid" value="<?= $classid; ?>">
    <div class="container-fluid mt--6">
      <div class="row" id="myList">
        <!--33-->
        <?php foreach($students as $student){ ?>
        <div class="col-md-3 eachstu">
            <div class="card attendence">
                <div class="card-body text-center">
                    <img src="<?= Yii::$app->request->baseUrl.'/img/theme/team-1.jpg' ?>">
              <div class="stu-name">
               <?= $student['first_name'].' '.$student['last_name']; ?>
              </div>
              <div class="stu-reg">
               <?= $student['roll_number']; ?>
              </div>
              <div class="stu-att mt-2">
                <label>Attendance:</label>
                <label class="switch">
                  <input type="checkbox" id="student_attendance_<?= $student['id']; ?>" onclick="setAttendance('<?= $student['id']; ?>')"
                      <?php 
                      echo count($attendance) > 0 ? ($student['attendance_status'] == 1 ? 'checked' : '') : 'checked';
                      ?>
                      name="attendance_status[]" value="1">
                  <span class="slider round"></span>
                </label>
                <input type="hidden" name="studentid[]" value="<?= $student['id']; ?>">
                <input type="hidden" id="student_attendance_hidden_<?= $student['id']; ?>" name="attendance_status_hidden[]" 
                value="<?php echo count($attendance) > 0 ? ($student['attendance_status'] == 1 ? '1' : '2') : '1'; ?>">
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <input type="submit" id="saveattendance" value="Submit Attendance" class="btn btn-primary">
    </form>
    <!--2-->
    
  <script src="../assets/js/argon.js?v=1.2.0"></script>
  <script src="../assets/js/script.js"></script>
  <script>
    $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList .eachstu").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
function setAttendance(student_id){
    if ($('#student_attendance_'+student_id).is(":checked")){
        $('#student_attendance_hidden_'+student_id).val('1');
    } else {
        $('#student_attendance_hidden_'+student_id).val('2');
    }
    
}
  </script>
  