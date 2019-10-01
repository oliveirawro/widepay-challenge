<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Url;
use app\models\UrlSearch;
use yii\web\NotFoundHttpException;
use app\common\Util;

/**
 * UrlController implements the CRUD actions for Url model.
 */
class UrlController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
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
     * Lists all Url models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UrlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Url model.
     * @param integer $EnterpriseCode
     * @param integer $Code
     * @param string $Address
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($EnterpriseCode, $Code, $Address)
    {
        return $this->render('view', [
            'model' => $this->findModel($EnterpriseCode, $Code, $Address),
        ]);
    }

    /**
     * Creates a new Url model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Url();

        if ($model->load(Yii::$app->request->post())) {

            $model->EnterpriseCode = Yii::$app->user->identity->EnterpriseCode;
            $model->UserCode = Yii::$app->user->identity->Code;
            $model->Code = Util::getNewIdTable('Url','Code');

            $model->DateTimeCreate = date("Y-m-d H:i:s");

            if ($model->save()){
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }




    /**
     * Updates an existing Url model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $EnterpriseCode
     * @param integer $Code
     * @param string $Address
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    public function actionUpdate($EnterpriseCode, $Code, $Address)
    {
        $model = $this->findModel($EnterpriseCode, $Code, $Address);


        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()){
                return $this->redirect(['index']);
            }

        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing Url model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $EnterpriseCode
     * @param integer $Code
     * @param string $Address
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($EnterpriseCode, $Code, $Address)
    {
        $this->findModel($EnterpriseCode, $Code, $Address)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Url model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $EnterpriseCode
     * @param integer $Code
     * @param string $Address
     * @return Url the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($EnterpriseCode, $Code, $Address)
    {
        if (($model = Url::findOne(['EnterpriseCode' => $EnterpriseCode, 'Code' => $Code, 'Address' => $Address])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }





}
