<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title. ' | '. Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-15345500-5', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>

<?php $this->beginBody() ?>
<nav class="navbar navbar-primary navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><?= Yii::$app->name ?></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
            <ul class="nav navbar-nav">
                <li class=""><a href="/">Set Finder</a></li>
                <li class=""><a href="/top">Best Discounts</a></li>

            </ul>


        </div>
    </div>
</nav>

<div class="wrap">
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
                <?= $content ?>
        </div>
    </div>
</div>
<footer>
    <p class="text-right small">built by <a href="http://incode.nz">incode.nz</a> - feedback / comments? <a href="mailto:lego@incode.co.nz">lego@incode.co.nz</a> </p>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
