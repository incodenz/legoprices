<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">AGL</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-success">2</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 2 Appointments today</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <h4>
                                            5548 Copper Falls Ave
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Kelly Howell</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <h4>
                                            8043 W Lone Mountain Rd
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Rick Mitchell</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Appointments</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" title="Logout">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
