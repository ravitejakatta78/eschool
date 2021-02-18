<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/nucleo/css/nucleo.css',
        'vendor/@fortawesome/fontawesome-free/css/all.min.css',
        'vendor/font-awesome/css/font-awesome.min.css',
        'css/argon.css?v=1.2.0',
        'css/dataTables.bootstrap4.min.css',
        'css/buttons.bootstrap4.min.css',
        'cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css',
		'css/custom.css',
    ];
    public $js = [
		//'vendor/jquery/dist/jquery.min.js',
		'vendor/bootstrap/dist/js/bootstrap.bundle.min.js',
		'vendor/js-cookie/js.cookie.js',
		'vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js',
		'vendor/chart.js/dist/Chart.min.js',
        'vendor/chart.js/dist/Chart.extension.js',
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap4.min.js',
        'js/dataTables.buttons.min.js',
        'js/buttons.bootstrap4.min.js',
        'js/jszip.min.js',
        'js/pdfmake.min.js',
        'js/vfs_fonts.js',
        'js/buttons.html5.min.js',
        'js/buttons.print.min.js',
        //'js/argon.js?v=1.2.0',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js',
		'js/script.js',
	];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
