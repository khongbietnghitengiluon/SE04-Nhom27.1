<?php
namespace enterprise\controllers;

use Yii;
use enterprise\models\Capacity;
use common\models\OrganizationRequestAbilities;
use yii\web\UploadedFile;

use common\models\UploadForm;
use yii\web\Controller;
use yii\helpers\ArrayHelper ;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\OrganizationRequests;

/**
 * Site controller
 */
class HomeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * {@inheritdoc}
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
    public function actionCreate()
    {
        $model = new OrganizationRequests();
        $capacity = new Capacity();
        $organizationRequestAbilities=new OrganizationRequestAbilities();  
        $model->organization_id= Yii::$app->user->identity->id ;
        $model->status=2;  
       $model->imageFile=$this->actionUpload(); 
     //  phpinfo();
        if ($model->load(Yii::$app->request->post()) && $model->save()) { 
            if($organizationRequestAbilities->luu($model->id) ){
          return $this->redirect(['view', 'id' => $model->id]);
                      } 
     
   }
    return $this->render('create', [
        'model' => $model,
        'capacity'=>$capacity,
]);
}
public function actionUpload()
    {
        $model = new OrganizationRequests();  // đã từng lỗ ở đây
        $fileUpload = UploadedFile::getInstance($model, 'imageFile');
        if(isset($fileUpload->size)){
            $fileUpload->saveAs(Yii::getAlias('@uploads') . $fileUpload->baseName . '.' . $fileUpload->extension);
            return  $fileUpload->baseName. '.'.$fileUpload->extension;
          
        }

       
    }
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

 
}