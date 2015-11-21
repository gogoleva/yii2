<?php

namespace app\controllers;

use Yii;
use app\models\Books;
use app\models\BooksSearch;
use app\models\Authors;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'view' => ['get'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update', 'delete', 'index', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init() {
        parent::init();
        require(Yii::getAlias("@vendor/upload/class.upload.php"));
    }

    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new BooksSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5;

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'authors' => Authors::get()
        ]);
    }

    /**
     * Displays a single Books model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        if (Yii::$app->request->isAjax)
            echo $this->renderPartial('view', [
                'model' => $this->findModel($id),
            ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Books();
        if ($model->load(Yii::$app->request->post())) {
            $handle = new \upload($_FILES['preview']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = substr_replace(md5(microtime(true) . $handle->file_src_name_body), '', 10);
                $handle->image_convert = 'png';
                $handle->png_compression = 0;
                $handle->Process(Yii::getAlias('@webroot') . Yii::$app->params['filepath']);
                if ($handle->processed) {
                    $model->preview = str_replace(Yii::getAlias('@webroot'), '', $handle->file_dst_pathname);
                }
                $handle->Clean();
            }
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'authors' => Authors::get()
            ]);
        }
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $handle = new \upload($_FILES['preview']);
            if ($handle->uploaded) {
                $handle->file_new_name_body = substr_replace(md5(microtime(true) . $handle->file_src_name_body), '', 10);
                $handle->image_convert = 'png';
                $handle->png_compression = 0;
                $handle->Process(Yii::getAlias('@webroot') . Yii::$app->params['filepath']);
                if ($handle->processed) {
                    $model->preview = str_replace(Yii::getAlias('@webroot'), '', $handle->file_dst_pathname);
                }
                $handle->Clean();
            }
            $model->save();
            return $this->redirect(Yii::$app->request->get('params'));
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'authors' => Authors::get()
            ]);
        }
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Books model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Books the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Books::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
