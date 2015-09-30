<?php

namespace app\modules\admin;

use Yii;
use yii\web\ForbiddenHttpException;
use app\models\User;

/**
 * Class Module
 * @package app\modules\admin
 */
class Module extends \yii\base\Module
{
    /**
     * @param \yii\base\Action $event
     * @return bool
     */
    public function beforeAction($event)
    {
        if (!parent::beforeAction($event)) {
            return false;
        }

        $user = Yii::$app->user->identity; /* @var User $user */

        if (!$user || !in_array($user->role_id, [User::ROLE_MASTER, User::ROLE_ADMIN])) {
            throw new ForbiddenHttpException('Access Denied');
        }

        return true;
    }

    /**
     * @param $context
     * @return array
     */
    public function getMenuItems($context)
    {
        return [
            [
                'label' => '<i class="fa fa-users"></i><span> Users</span>',
                'url' => ['/admin/user'],
                'active' => $context->id == 'user',
                'encode' => false,
            ],
        ];
    }
}