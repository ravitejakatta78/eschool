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
              <h6 class="h2 text-white d-inline-block mb-0">Attendance</h6>
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
              <h3 class="mb-0">Attendance List</h3>
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