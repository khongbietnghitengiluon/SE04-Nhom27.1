<?php

namespace backend\controllers;

use Yii;
use backend\models\Enterprise;
use app\models\EnterpriseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnterpriseController implements the CRUD actions for Enterprise model.
 */
class HiController extends Controller
{
    public function actionHi()
    {
      echo "2";
    }
}
