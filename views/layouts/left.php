<?php
use yii\bootstrap\Nav;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity ?></p>

            </div>
        </div>


        <?=
        method_exists($this->context->module, 'getMenuItems') ?
            Nav::widget(
                [
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'items' =>
                        \yii\helpers\ArrayHelper::merge(
                            ['<li class="header">'.\yii\helpers\Inflector::camel2words(
                                    \yii\helpers\Inflector::id2camel($this->context->module->id)
                                ).'</li>'],
                            $this->context->module->getMenuItems($this->context)
                        )
                ]
            ) : ''
        ?>
        <?=
            Nav::widget(
                [
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
                        ['label' => '<i class="fa fa-sign-out"></i><span>Logout</span>', 'url' => ['/logout']],
                    ],
                ]
            )
        ?>
        <?=
        YII_ENV == 'dev' ?
        Nav::widget(
            [
                'encodeLabels' => false,
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    '<li class="header">Developer</li>',
                    ['label' => '<i class="fa fa-file-code-o"></i><span>Gii</span>', 'url' => ['/gii']],
                    ['label' => '<i class="fa fa-dashboard"></i><span>Debug</span>', 'url' => ['/debug']],
                    [
                        'label' => '<i class="glyphicon glyphicon-lock"></i><span>Sign in</span>', //for basic
                        'url' => ['/site/login'],
                        'visible' => Yii::$app->user->isGuest
                    ],
                ],
            ]
        ) : ''
        ?>


    </section>

</aside>
