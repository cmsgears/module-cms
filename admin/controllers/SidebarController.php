<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\SidebarWidget;

class SidebarController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $widgetService;
	protected $activityService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'sidebarService' );
		$this->widgetService	= Yii::$app->factory->get( 'widgetService' );
		$this->activityService		= Yii::$app->factory->get( 'activityService' );
		
		// Sidebar
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'sdebar' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'sidebars' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/sidebar/all' ], true );
		
		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Sidebar' ] ],
			'create' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'items' => [ [ 'label' => 'Sidebar', 'url' => $this->returnUrl ], [ 'label' => 'Items' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarController ---------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'sidebars' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_SIDEBAR;
		$model->data	= "{ \"widgets\": {} }";
		$widgets		= $this->widgetService->getIdNameList();

		// Sidebar Widgets
		$sidebarWidgets	= [];

		for ( $i = 0, $j = count( $widgets ); $i < $j; $i++ ) {

			$sidebarWidgets[] = new SidebarWidget();
		}

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && SidebarWidget::loadMultiple( $sidebarWidgets, Yii::$app->request->post(), 'SidebarWidget' ) &&
			$model->validate() && SidebarWidget::validateMultiple( $sidebarWidgets ) ) {

			$this->modelService->create( $model );

			$this->modelService->updateWidgets( $model, $sidebarWidgets );

			$model->refresh();

			$this->model = $model;

			return $this->redirect( "all" );
		}

		return $this->render( 'create', [
			'model' => $model,
			'widgets' => $widgets,
			'sidebarWidgets' => $sidebarWidgets
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$widgets		= $this->modelService->getIdNameList();
			$sidebarWidgets	= $this->modelService->getWidgetsForUpdate( $model, $widgets );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && SidebarWidget::loadMultiple( $sidebarWidgets, Yii::$app->request->post(), 'SidebarWidget' ) &&
				$model->validate() && SidebarWidget::validateMultiple( $sidebarWidgets ) ) {

				$this->modelService->update( $model );

				$this->modelService->updateWidgets( $model, $sidebarWidgets );

				$model->refresh();

				$this->model = $model;

				return $this->redirect( "all" );
			}

			return $this->render( 'update', [
				'model' => $model,
				'widgets' => $widgets,
				'sidebarWidgets' => $sidebarWidgets
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$model->refresh();

				$this->model = $model;

				return $this->redirect( $this->returnUrl );
			}

			$widgets		= $this->modelService->getIdNameList();
			$sidebarWidgets	= $this->modelService->getWidgetsForUpdate( $model, $widgets );

			return $this->render( 'delete', [
				'model' => $model,
				'widgets' => $widgets,
				'sidebarWidgets' => $sidebarWidgets
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
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
