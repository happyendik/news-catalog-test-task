<?php

namespace backend\controllers;

use backend\models\News;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\base\InvalidConfigException;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class NewsController
 * @package backend\controllers
 */
class NewsController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id = 0)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save(false)) {
                Yii::$app->session->addFlash('success', 'Удачно');
            } else {
                Yii::$app->session->addFlash('warning', 'Что-то пошло не так');
            }

            $this->redirect(['news/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $model = News::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($model->delete()) {
            Yii::$app->session->addFlash('success', 'Успешно удалено');
        } else {
            Yii::$app->session->addFlash('warning', 'Что-то пошло не так.');
        }

        $this->redirect(['news/index']);
    }

    /**
     * @param int $id
     * @return News
     */
    protected function findModel(int $id): News
    {
        $model = News::findOne($id);
        if (!$model) {
            $model = new News();
        }

        return $model;
    }
}
