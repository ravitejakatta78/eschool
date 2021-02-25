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
                <label>Attendence:</label>
                <label class="switch">
                  <input type="checkbox" checked>
                  <span class="slider round"></span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
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
  </script>
  