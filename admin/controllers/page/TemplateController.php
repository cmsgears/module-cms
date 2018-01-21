<?php
namespace cmsgears\cms\admin\controllers\page;

// Yii Imports
use Yii;
use yii\helpers\Url;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class TemplateController extends \cmsgears\core\admin\controllers\base\TemplateController {

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

		// Type
		$this->type			= CmsGlobal::TYPE_PAGE;

		// Services
		$this->activityService	= Yii::$app->factory->get( 'activityService' );

		// Sidebar
		$this->sidebar		= [ 'parent' => 'sidebar-cms', 'child' => 'page-template' ];

		// Return Url
		$this->returnUrl	= Url::previous( 'templates' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/template/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'base' => [ [ 'label' => 'Pages', 'url' =>  [ '/cms/page/all' ] ] ],
			'all' => [ [ 'label' => 'Templates' ] ],
			'create' => [ [ 'label' => 'Templates', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Templates', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Templates', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// TemplateController --------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'templates' );

		return parent::actionAll();
	}
	
	public function afterAction( $action, $result ) {

		$parentType = $this->modelService->getParentType();
		
		switch( $action->id ) {

			case 'create':
			case 'update': {

				if( isset( $this->model ) ) {

					// Refresh Listing
					$this->model->refresh();

					// Activity
					if( $action->id == 'create' ) { 
					
						$this->activityService->createActivity( $this->model, $parentType );
					}
					
					if( $action->id == 'update' ) {
					
						$this->activityService->updateActivity( $this->model, $parentType );
					}
				}

				break;
			}
			case 'delete': {

				if( isset( $this->model ) ) {

					$this->activityService->deleteActivity( $this->model, $parentType );
				}

				break;
			}
		}

		return parent::afterAction( $action, $result );
	}
}
