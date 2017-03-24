<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 03.03.17
 * Time: 15:46
 */

namespace app\controllers;


use app\models\db\Admin;
use app\models\db\Author;
use app\models\db\Book;
use app\models\db\Cell;
use app\models\db\Client;
use app\models\db\Journal;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class AreaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->isGuest) {
                                return false;
                            } elseif ($action->id === 'personal-area') {
                                return Yii::$app->user->identity->can('Reader');
                            } elseif ($action->id === 'admin') {
                                return Yii::$app->user->identity->can('Director');
                            } else {
                                return Yii::$app->user->identity->can('Administrator');
                            }
                        }
                    ],
                ],
            ]
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

    public function actionBook() {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors', 'category'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $link = Yii::$app->urlManager->createUrl(['area/authors']);
        $authorsLink = "<a href='$link'>Authors</a>";
        $link = Yii::$app->urlManager->createUrl(['area/cells']);
        $cellsLink = "<a href='$link'>Cells</a>";
        $link = Yii::$app->urlManager->createUrl(['form/book-new']);
        $newLink = "<a href='$link'>New</a>";

        return $this->render('books', [
            "dataProvider" => $dataProvider,
            "authorsLink" => $authorsLink,
            "cellsLink" => $cellsLink,
            "newLink" => $newLink
        ]);
    }

    public function actionAuthors() {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        $link = Yii::$app->urlManager->createUrl(['form/author-new']);
        $authorsLink = "<a href='$link'>New</a>";

        return $this->render('authors', [
            "dataProvider" => $dataProvider,
            "authorsLink" => $authorsLink
        ]);
    }

    public function actionCells() {
        $dataProvider = new ActiveDataProvider([
            'query' => Cell::find(),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $link = Yii::$app->urlManager->createUrl(['form/cell-new']);
        $newLink = "<a href='$link'>New</a>";

        return $this->render('cells', [
            "dataProvider" => $dataProvider,
            "newLink" => $newLink
        ]);
    }

    public function actionClient() {
        $dataProvider = new ActiveDataProvider([
            'query' => Client::find()->with('user'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $link = Yii::$app->urlManager->createUrl(['form/client-new']);
        $newLink = "<a href='$link'>New</a>";

        return $this->render('clients', [
            "dataProvider" => $dataProvider,
            "newLink" => $newLink
        ]);
    }

    public function actionJournal() {
        $dataProvider = new ActiveDataProvider([
            'query' => Journal::find()->with('client', 'book'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('journal', [
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Admin::find()->with('user'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $link = Yii::$app->urlManager->createUrl(['form/admin-new']);
        $newLink = "<a href='$link'>New</a>";

        return $this->render('admins', [
            'dataProvider' => $dataProvider,
            'newLink' => $newLink
        ]);
    }

    public function actionPersonalArea()
    {
        $client = Client::findOne(['user_id' => Yii::$app->user->identity]);
        $debtBook = Journal::findAll([
            'date_fact_return' => null,
            'client_id' => $client->client_id
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => Journal::find()->where('date_fact_return is not null')->andWhere(['client_id' => $client->client_id]),
            'pagination' => [
                'pageSize' => 15
            ],
        ]);

        return $this->render('clientArea', [
            'client' => $client,
            'debtBook' => $debtBook,
            'dataProvider' => $dataProvider
        ]);
    }
}