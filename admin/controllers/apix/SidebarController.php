<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class SidebarController extends \cmsgears\core\admin\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $activityService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'sidebarService' );
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
				
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
				
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			
			'bulk' => [ 'class' => 'cmsgears\core\common\actions\grid\Bulk' ],
			'delete' => [ 'class' => 'cmsgears\core\common\actions\grid\Delete' ]
		];
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
	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarController ---------------------

}
