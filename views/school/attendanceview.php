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
          <form class = "form-inline" role = "form">
            <div class="row">
              
             <div class = "form-group mr-2">
                <select class="form-control">
                  <option>Select Class</option>
                  <option>LKG</option>
                  <option>UKG</option>
                </select>
             </div>
             <div class = "form-group mr-2">
              <select class="form-control">
                <option>Select Section</option>
                <option>A</option>
                <option>B</option>
              </select>
           </div>
           <div class = "form-group mr-2">
            <input type = "text" class = "form-control" placeholder = "Start Date">
           </div>
           <div class = "form-group mr-2">
            <input type = "text" class = "form-control" placeholder = "End Date">
           </div>
           <div class = "form-group mr-2">
            <button class="btn-primary btn">Submit</button>
           </div>
            </div>
            
            </form>
        </div>
      </div>
      
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
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
</script>