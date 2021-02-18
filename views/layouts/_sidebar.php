<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  navbar-expand-xs navbar-light bg-white" id="sidebar">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="<?= Yii::$app->request->baseUrl.'/img/brand/blue.png'; ?>" class="navbar-brand-img" alt="...">
        </a>
        <div style="position: absolute; right: 15px; top: 33px;">
            <a class="sidebarclose">
                <span class="bar1"></span>
                <span class="bar1"></span>
                <span class="bar1"></span>
            </a>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item dropdown" role="presentation">
              <a class="nav-link" lass="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
                <span class="caret"></span>
              </a>
              <ul  class="dropdown-menu">
                <li class="nav-item ">
                  <a class="nav-link" href="dashboard.html">
                    <i class="ni ni-tv-2 text-primary"></i>
                    <span class="nav-link-text">Dashboard</span>
                  </a>
                </li>
                <li  class="nav-item ">
                  <a class="nav-link" href="dashboard.html">
                    <i class="ni ni-tv-2 text-primary"></i>
                    <span class="nav-link-text">Dashboard</span>
                  </a>
                </li>
                <li  class="nav-item ">
                  <a class="nav-link" href="dashboard.html">
                    <i class="ni ni-tv-2 text-primary"></i>
                    <span class="nav-link-text">Dashboard</span>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::to(['school/students']); ?>">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Students</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::to(['school/faculity']); ?>">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Teachers</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::to(['school/school-classes']); ?>">
                <i class="ni ni-bullet-list-67 text-default"></i>
                <span class="nav-link-text">Class</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::to(['school/subjects']); ?>">
                <i class="ni ni-key-25 text-info"></i>
                <span class="nav-link-text">Subjects</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="examples/upgrade.html">
                <i class="ni ni-send text-dark"></i>
                <span class="nav-link-text">Attendamce</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::to(['school/exams']); ?>">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">Exam</span>
              </a>
            </li>

          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">Documentation</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html" target="_blank">
                <i class="ni ni-spaceship"></i>
                <span class="nav-link-text">Getting started</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html" target="_blank">
                <i class="ni ni-palette"></i>
                <span class="nav-link-text">Foundation</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html" target="_blank">
                <i class="ni ni-ui-04"></i>
                <span class="nav-link-text">Components</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/plugins/charts.html" target="_blank">
                <i class="ni ni-chart-pie-35"></i>
                <span class="nav-link-text">Plugins</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active active-pro" href="examples/upgrade.html">
                <i class="ni ni-send text-dark"></i>
                <span class="nav-link-text">Upgrade to PRO</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>