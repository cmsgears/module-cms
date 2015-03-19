<?php
namespace cmsgears\modules\cms\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;

use cmsgears\modules\cms\admin\models\forms\MenuBinderForm;
use cmsgears\modules\cms\common\models\entities\CMSPermission;

use cmsgears\modules\cms\admin\services\PageService;

use cmsgears\modules\core\common\utilities\MessageUtil;
use cmsgears\modules\core\common\utilities\AjaxUtil;

class PageController extends Controller {

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
                'permissions' => [
	                'bindMenus'  => CMSPermission::PERM_CMS_PAGE
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
	                'bindMenus'  => ['post']
                ]
            ]
        ];
    }

	// PageController

	public function actionBindMenus() {

		$binder = new MenuBinderForm();

		if( $binder->load( Yii::$app->request->post(), "" ) ) {

			if( PageService::bindMenus( $binder ) ) {

				// Trigger Ajax Success
				AjaxUtil::generateSuccess( MessageUtil::getMessage( CoreGlobal::MESSAGE_REQUEST ) );
			}
		}

		// Trigger Ajax Failure
        AjaxUtil::generateFailure( MessageUtil::getMessage( CoreGlobal::ERROR_REQUEST ) );
	}
}

?>