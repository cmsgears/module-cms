<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\forms\Binder;

use cmsgears\core\common\utilities\AjaxUtil;

class WidgetController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $activityService;
	
	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();
		
		// Permission
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;
		
		// Service
		$this->modelService		= Yii::$app->factory->get( 'widgetService' );
		$this->activityService	= Yii::$app->factory->get( 'activityService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		return [
			'rbac' => [
				'class' => Yii::$app->core->getRbacFilterClass(),
				'actions' => [
					'bindSidebars' => [ 'permission' => $this->crudPermission ],
					
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'bindSidebars' => [ 'post' ],
					
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// WidgetController ----------------------

	public function actions() {

		return [
			
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
	}
	
	public function actionBindSidebars() {

		$binder = new Binder();

		if( $binder->load( Yii::$app->request->post(), 'Binder' ) ) {

			$this->modelService->bindSidebars( $binder );

			// Trigger Ajax Success
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ) );
		}

		// Trigger Ajax Failure
		return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ) );
	}
	
	public function beforeAction( $action ) {

		$id	= Yii::$app->request->get( 'id' ) != null ? Yii::$app->request->get( 'id' ) : null;

		if( isset( $id ) ) {

			$model	= $this->modelService->getById( $id );
		
			$parentType = $this->modelService->getParentType();

			switch( $action->id ) {

				case 'delete': {

					if( isset( $model ) ) {

						$this->activityService->deleteActivity( $model, $parentType );
					}

					break;
				}
			}
		}
		return parent::beforeAction( $action);
	}
}
