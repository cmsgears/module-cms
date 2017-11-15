<?php
namespace cmsgears\cms\admin\controllers\apix;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class PostController extends \cmsgears\core\admin\controllers\base\Controller {

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
		$this->modelService		= Yii::$app->factory->get( 'postService' );
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
					'update-avatar' => [ 'permission' => $this->crudPermission ],
					'update-banner' => [ 'permission' => $this->crudPermission ],
					'assign-category' => [ 'permission' => $this->crudPermission ],
					'remove-category' => [ 'permission' => $this->crudPermission ],
					'assign-tags' => [ 'permission' => $this->crudPermission ],
					'remove-tag' => [ 'permission' => $this->crudPermission ],
					'add-meta' => [ 'permission' => $this->crudPermission ],
					'update-meta' => [ 'permission' => $this->crudPermission ],
					'delete-meta' => [ 'permission' => $this->crudPermission ],
					'bulk' => [ 'permission' => $this->crudPermission ],
					'delete' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'auto-search' => [ 'post' ],
					'update-avatar' => [ 'post' ],
					'update-banner' => [ 'post' ],
					'assign-category' => [ 'post' ],
					'remove-category' => [ 'post' ],
					'assign-tags' => [ 'post' ],
					'remove-tag' => [ 'post' ],
					'add-meta' => [ 'post' ],
					'update-meta' => [ 'post' ],
					'delete-meta' => [ 'post' ],
					'bulk' => [ 'post' ],
					'delete' => [ 'post' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'auto-search' => [ 'class' => 'cmsgears\core\common\actions\content\AutoSearch' ],
			'update-avatar' => [ 'class' => 'cmsgears\core\common\actions\content\UpdateAvatar' ],
			'update-banner' => [ 'class' => 'cmsgears\cms\common\actions\content\UpdateContentBanner' ],
			'assign-category' => [ 'class' => 'cmsgears\core\common\actions\category\Assign' ],
			'remove-category' => [ 'class' => 'cmsgears\core\common\actions\category\Remove' ],
			'assign-tags' => [ 'class' => 'cmsgears\core\common\actions\tag\Assign' ],
			'remove-tag' => [ 'class' => 'cmsgears\core\common\actions\tag\Remove' ],
			'add-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Create' ],
			'update-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Update' ],
			'delete-meta' => [ 'class' => 'cmsgears\core\common\actions\meta\Delete' ],
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

	// PostController ------------------------

}
