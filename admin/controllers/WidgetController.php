<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\cms\admin\models\forms\WidgetForm;

class WidgetController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;
	protected $activityService;
	
	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permissions
		$this->crudPermission	= CmsGlobal::PERM_BLOG_ADMIN;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'widgetService' );

		$this->templateService	= Yii::$app->factory->get( 'templateService' );
		$this->activityService  = Yii::$app->factory->get( 'activityService' );

		// Sidebar
		$this->sidebar			= [ 'parent' => 'sidebar-cms', 'child' => 'widget' ];

		// Return Url
		$this->returnUrl		= Url::previous( 'widgets' );
		$this->returnUrl		= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/widget/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs		= [
			'all' => [ [ 'label' => 'Widgets' ] ],
			'create' => [ [ 'label' => 'Widgets', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Widgets', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Widgets', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ],
			'settings' => [ [ 'label' => 'Widgets', 'url' => $this->returnUrl ], [ 'label' => 'Settings' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors	= parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'settings' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'settings' ] = [ 'get', 'post' ];

		return $behaviors;
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// WidgetController ----------------------

	public function actionAll() {

		Url::remember( Yii::$app->request->getUrl(), 'widgets' );

		return parent::actionAll();
	}

	public function actionCreate() {

		$modelClass		= $this->modelService->getModelClass();
		$model			= new $modelClass;
		$model->siteId	= Yii::$app->core->siteId;
		$model->type	= CmsGlobal::TYPE_WIDGET;
		$meta			= new WidgetForm();

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

			$this->modelService->create( $model, [ 'data' => $meta ] );

			$model->refresh();

			$this->model = $model;

			return $this->redirect( "all" );
		}

		$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'meta' => $meta,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $meta->load( Yii::$app->request->post(), 'WidgetForm' ) && $model->validate() ) {

				$this->modelService->update( $model, [ 'data' => $meta ] );

				$model->refresh();

				$this->model = $model;

				return $this->redirect( "all" );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'meta' => $meta,
				'templatesMap' => $templatesMap
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

			$meta	= new WidgetForm( $model->data );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$model->refresh();

				$this->model = $model;

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_WIDGET, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'meta' => $meta,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSettings( $id ) {

		// Find Model
		$model	= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$meta	= new WidgetForm( $model->data );

			if( $meta->load( Yii::$app->request->post(), 'WidgetForm' ) ) {

				$this->modelService->update( $model, [ 'data' => $meta ] );

				return $this->redirect( $this->returnUrl );
			}

			return $this->render( 'settings', [
				'model' => $model,
				'meta' => $meta
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
