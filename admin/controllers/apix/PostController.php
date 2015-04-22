<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\admin\models\forms\PostCategoryBinderForm;

use cmsgears\cms\admin\services\PostService;

use cmsgears\core\common\utilities\AjaxUtil;

class PostController extends Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// yii\base\Component

    public function behaviors() {

        return [
            'rbac' => [
                'class' => Yii::$app->cmgCore->getRbacFilterClass(),
                'actions' => [
	                'bindCategories'  => [ 'permission' => CmsGlobal::PERM_CMS ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'bindCategories'  => ['post']
                ]
            ]
        ];
    }

	// PostController

	public function actionBindCategories() {

		$binder = new PostCategoryBinderForm();

		if( $binder->load( Yii::$app->request->post(), "" ) ) {

			if( PostService::bindCategories( $binder ) ) {

				// Trigger Ajax Success
				AjaxUtil::generateSuccess( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Trigger Ajax Failure
        AjaxUtil::generateFailure( Yii::$app->cmgCoreMessageSource->getMessage( CoreGlobal::ERROR_REQUEST ) );
	}
}

?>