<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->loginUrl);
        } elseif (Yii::$app->user->identity->can('Director')) {
            return $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->params['homePageDirector']));
        } elseif (Yii::$app->user->identity->can('Administrator')) {
            return $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->params['homePageAdmin']));
        } else {
            return $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->params['homePageClient']));
        }
    }

    public function actionLogin() {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->defaultRoute = 'area/journal';

            Yii::$app->response->redirect(Url::to(Yii::$app->homeUrl));
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}