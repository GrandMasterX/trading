<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="width: 100%;height: 100%;">
<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>'Best Trading',
    'brandUrl'=>'/',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Profile', 'url'=>'profile'),
                array('label'=>'logout', 'url'=>'logout'),
            ),
        ),
        //'<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',
    ),
)); ?>
<?php if(isset($this->breadcrumbs)):?>
    <?$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?>
<?php endif?>
<div class="container-fluid" style="padding-top: 50px;">
    <div class="row-fluid">
        <div class="span6">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Graphic</li>
                    <?php echo $content; ?>
                </ul>
            </div><!--/.well -->
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Portfolio</li>
                    <div class="row" style="margin-left: 2px">
                        <div class="col-md-3">
                            <ul class="nav nav-stacked" id="accordion1">
                            </ul>
                        </div>
                    </div>
                </ul>
            </div><!--/.well -->
        </div><!--/span-->

        <div class="span6">
            <div class="row-fluid">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <li class="nav-header">available traders</li>
                        <?$this->renderPartial('/trading/traders')?>
                    </ul>
                </div>
            </div><!--/row-->
        </div><!--/span-->
    </div><!--/row-->


    <div class="navbar-fixed-bottom row-fluid" id="footer">
        Copyright &copy; 2014 by GrandMasterX.<br>
        All Rights Reserved .<br>
    </div>

</div>


<? $this->renderPartial('/trading/graphic')?>

<script type="application/javascript">
    jQuery.noConflict();

    $(document).ready(function() {
        $(".panel").draggable();
        $(".nav.nav-list").droppable({
            drop: function( event, ui ) {
                $(this).find('.nav.nav-stacked').append(ui.draggable.css({'left':'0','top':'0'}))
            }
        });
    });
</script>
</body>
</html>
