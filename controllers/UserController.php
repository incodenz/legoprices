<?php

namespace app\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;
use app\models\ForgotPasswordForm;
use app\models\ResetPasswordForm;

/**
 * Class UserController
 * @package app\controllers
 */
class UserController extends Controller
{
    /**
     * @var string
     */
    public $layout = 'main-login';

    /**
     * Render Login form and allow user to authenticate
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('admin');
        } else {
            return $this->render('login', ['model' => $model,]);
        }
    }

    /**
     * Log the current user out and redirect them to the default controller/action
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     *
     * @return string
     */
    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();
        $success = false;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->sendEmail();
            $success = true;
        }

        return $this->render('forgot_password', [
            'success' => $success,
            'model' => $model,
        ]);
    }

    /**
     *
     * @param $t
     * @return string
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($t)
    {
        Yii::$app->user->logout();

        $model = new ResetPasswordForm();
        $user = User::findByPasswordResetToken($t); /* @var \app\models\User $user */

        if (!$user) {
            throw new BadRequestHttpException('Password reset link is invalid or has expired');
        }

        $model->setUser($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->goHome();
        }

        return $this->render('password_reset', ['model' => $model]);
    }

}


