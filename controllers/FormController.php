<?php
/**
 * Created by PhpStorm.
 * User: himmel
 * Date: 14.03.17
 * Time: 16:38
 */

namespace app\controllers;

use app\models\db\Admin;
use app\models\db\Book;
use app\models\db\Category;
use app\models\db\Cell;
use app\models\db\Client;
use app\models\db\Journal;
use app\models\db\Role;
use app\models\db\User;
use app\models\forms\AdminForm;
use app\models\forms\AuthorForm;
use app\models\forms\BookForm;
use app\models\forms\CellForm;
use app\models\forms\ClientForm;
use app\models\forms\IssueBookForm;
use app\models\forms\TakeBookForm;
use Yii;
use app\models\db\Author;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class FormController extends Controller
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
                            $name = explode(" ", $action->id)[0];
                            if (!Yii::$app->user->isGuest) {
                                return $name === 'admin' ?
                                    Yii::$app->user->identity->can('Director') :
                                    Yii::$app->user->identity->can('Administrator');
                            } else return false;
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


    /** ---------------------------------------------------Author--------------------------------------------------- */
    public function actionAuthorNew() {
        return $this->actionAuthorUpdate(null);
    }

    public function actionAuthorUpdate($id) {
        $form = new AuthorForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->getAuthor()->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        if ($id != null)
            $form = AuthorForm::getForm(Author::findOne($id));
        return $this->render('formAuthor', ['model' => $form]);
    }

    public function actionAuthorDelete($id) {
        $element = Author::findOne($id);
        $element->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }


    /** ----------------------------------------------------Book---------------------------------------------------- */
    public function actionBookNew() {
        return $this->actionBookUpdate(null);
    }

    public function actionBookUpdate($id) {
        $form = new BookForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $form->getBook();

            $category = Category::findOne(['name' => $form->category]);
            if ($category == null) {
                $category = new Category();
                $category->name = $form->category;
                $category->save();
            }
            $model->category_id = $category->category_id;
            $model->save();

            static::unlinkAllAuthors($model);
            $authors = Author::findAll($form->authors);
            foreach ($authors as $author) {
                $model->link('authors', $author);
            }

            $cell = Cell::findOne(['book_id' => $model->book_id]);
            if ($cell != null && $cell->cell_id != $form->cell) {
                $cell->book_id = null;
                $cell->save();
            }
            $cell = Cell::findOne($form->cell);
            if ($cell != null) {
                $cell->book_id = $model->book_id;
                $cell->save();
            }

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        if ($id != null)
            $form = BookForm::getForm(Book::findOne($id));
        return $this->render('formBook', ['model' => $form]);
    }

    public function actionBookDelete($id) {
        $element = Book::findOne($id);

        $cell = Cell::findOne(['book_id' => $element->book_id]);
        if ($cell != null) {
            $cell->unlink('book', $element);
        }

        static::unlinkAllAuthors($element);

        $element->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    private static function unlinkAllAuthors(Book $book) {
        (new Query())->createCommand()->delete('book_author', ['book_id' => $book->book_id])->execute();
    }


    /** ----------------------------------------------------Cell---------------------------------------------------- */
    public function actionCellNew() {
        return $this->actionCellUpdate(null);
    }

    public function actionCellUpdate($id) {
        $form = new CellForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $form->getCell();
            $model->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        $query = new Query();
        $query->select(["concat('[', code1, '] ', '[', code2, ']', ' ', name)", 'book_id'])->from('book')
            ->where(['not in', 'book_id', Journal::find()->select('book_id')->where(['date_fact_return' => null])->all()])
            ->andWhere(['not in', 'book_id', Cell::find()->select('book_id')->where('book_id is not null')]);
        if ($id != null) {
            $form = CellForm::getForm(Cell::findOne($id));
            if ($form->book != null)
                $query->orWhere(['book_id' => $form->book->book_id]);
        }
        $query->indexBy('book_id');

        return $this->render('formCell', [
            'model' => $form,
            'column' => $query->column()
        ]);
    }

    public function actionCellDelete($id) {
        $element = Cell::findOne($id);
        $element->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }


    /** ---------------------------------------------------Client--------------------------------------------------- */
    public function actionClientNew() {
        $form = new ClientForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $form->getUser();
            $user->save();
            $user->link('roles', Role::findOne(['role_name' => 'Reader']));
            $model = $form->getClient();
            $model->user_id = $user->user_id;
            $model->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        return $this->render('formClient', [
            'model' => $form,
        ]);
    }

    public function actionClientUpdate($id) {
        $form = new ClientForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $form->getUser();
            $user->save();
            $model = $form->getClient();
            $model->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        $form = ClientForm::getForm(Client::findOne($id));

        return $this->render('formClient', [
            'model' => $form,
        ]);
    }

    public function actionClientDelete($id) {
        $element = User::findOne(Client::findOne($id)->user_id);
        $element->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }


    /** ---------------------------------------------OperationWithBook---------------------------------------------- */
    public function actionIssueBook() {
        $form = new IssueBookForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $admin = Admin::findOne(['user_id' => Yii::$app->user->identity->user_id]);
            $record = $form->getJournalRecord($admin->admin_id);

            $cell = Cell::findOne(['book_id' => $record->book_id]);
            $cell->book_id = null;
            $cell->save();

            $record->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        $columnBook = Book::find()->select(["concat('[', code1, '] [', code2, '] ', name)", 'book_id'])
            ->where(['not in', 'book_id', Journal::find()->select('book_id')->where('date_fact_return is null')->all()])
            ->indexBy('book_id')->column();

        $columnClient = Client::find()->select(["concat('[', passport_id, '] ',last_name, ' ', first_name)", "client_id"])
            ->where(['not in', 'client_id', Journal::find()->select('client_id')->where(['date_fact_return' => null])
                ->groupBy(['client_id'])->having(['>', 'COUNT( client_id )', '1'])
            ])->indexBy('client_id')->column();

        return $this->render('formIssueBook',[
            'model' => $form,
            'columnBook' => $columnBook,
            'columnClient' => $columnClient
        ]);
    }

    public function actionTakeBook() {
        $form = new TakeBookForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $record = Journal::findOne($form->recordId);
            $record->date_fact_return = $form->dateFactReturn;

            $cell = Cell::findOne($form->cell);
            $cell->book_id = $record->book_id;
            $cell->save();

            $record->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        $dataProvider = new ActiveDataProvider([
            'query' => Journal::find()->with('admin', 'client', 'book')->where(['date_fact_return' => null]),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('formTakeBook', [
            "model" => $form,
            "dataProvider" => $dataProvider
        ]);
    }

    public function actionRecordView($id) {
        return $this->render('formRecord', [
            "record" => Journal::find()->with('client', 'admin', 'book')->where(['record_id' => $id])->one()
        ]);
    }


    /** ----------------------------------------------------Admin--------------------------------------------------- */
    public function actionAdminNew() {
        return $this->actionAdminUpdate(null);
    }

    public function actionAdminUpdate($id) {
        $form = new AdminForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user = $form->getUser();
            $user->save();
            static::unlinkAllRoles($user);
            foreach ($form->roles as $role_id) {
                $user->link('roles', Role::findOne($role_id));
            }
            $model = $form->getAdmin();
            $model->user_id = $user->user_id;
            $model->save();

            return $this->redirect(Url::previous());
        }

        Url::remember(Yii::$app->request->referrer);

        if ($id != null)
            $form = AdminForm::getForm(Admin::findOne($id));

        return $this->render('formAdmin', [
            'model' => $form,
        ]);
    }

    public function actionAdminDelete($id) {
        $element = User::findOne(Admin::findOne($id)->user_id);
        $element->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    private static function unlinkAllRoles(User $user) {
        (new Query())->createCommand()->delete('user_role', ['user_id' => $user->user_id,])->execute();
    }
}