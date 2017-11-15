<?php
namespace cmsgears\cms\admin\controllers;

// Yii Imports
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\resources\ModelContent;

class PageController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;
	protected $modelContentService;
	protected $activityService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission		= CmsGlobal::PERM_BLOG_ADMIN;

		// Service
		$this->modelService			= Yii::$app->factory->get( 'pageService' );
		$this->templateService		= Yii::$app->factory->get( 'templateService' );
		$this->modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$this->activityService		= Yii::$app->factory->get( 'activityService' );
		
		// Sidebar
		$this->sidebar		= [ 'parent' => 'sidebar-cms', 'child' => 'page' ];

		// Return Url
		$this->returnUrl	= Url::previous( 'pages' );
		$this->returnUrl	= isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/page/all' ], true );

		// Breadcrumbs
		$this->breadcrumbs	= [
			'all' => [ [ 'label' => 'Pages' ] ],
			'create' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Add' ] ],
			'update' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Update' ] ],
			'delete' => [ [ 'label' => 'Pages', 'url' => $this->returnUrl ], [ 'label' => 'Delete' ] ]
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------

	public function actionAll() {

		Url::remember( [ 'page/all' ], 'pages' );

		$dataProvider = $this->modelService->getPage();

		return $this->render( 'all', [
			 'dataProvider' => $dataProvider
		]);
	}

	public function actionCreate() {

		$modelClass			= $this->modelService->getModelClass();
		$model				= new $modelClass;
		$model->siteId		= Yii::$app->core->siteId;
		$model->comments	= false;
		$content			= new ModelContent();
		$banner				= File::loadFile( null, 'Banner' );
		$video				= File::loadFile( null, 'Video' );

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->modelService->create( $model, [ 'admin' => true ] );

			$this->modelContentService->create( $content, [ 'parent' => $model, 'parentType' => CmsGlobal::TYPE_PAGE, 'publish' => $model->isActive(), 'banner' => $banner, 'video' => $video ] );

			$model->refresh();

			$this->model = $model;

			return $this->redirect( "all" );
		}

		$visibilityMap	= Page::$visibilityMap;
		$statusMap		= Page::$statusMap;
		$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_PAGE, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'content' => $content,
			'banner' => $banner,
			'video' => $video,
			'visibilityMap' => $visibilityMap,
			'statusMap' => $statusMap,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id ) {

		// Find Model
		$model		= $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$banner		= File::loadFile( $content->banner, 'Banner' );
			$video		= File::loadFile( $content->video, 'Video' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->modelService->update( $model, [ 'admin' => true ] );

				$this->modelContentService->update( $content, [ 'publish' => $model->isActive(), 'banner' => $banner, 'video' => $video ] );

				$model->refresh();
			
				$this->model = $model;

				return $this->redirect( "all" );
			}

			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_PAGE, [ 'default' => true ] );

			return $this->render( 'update', [
				'model' => $model,
				'content' => $content,
				'banner' => $banner,
				'video' => $video,
				'visibilityMap' => $visibilityMap,
				'statusMap' => $statusMap,
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

			$content		= $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				$this->modelService->delete( $model );

				$this->modelContentService->delete( $content );

				$model->refresh();

				$this->model = $model;

				return $this->redirect( $this->returnUrl );
			}

			$visibilityMap	= Page::$visibilityMap;
			$statusMap		= Page::$statusMap;
			$templatesMap	= $this->templateService->getIdNameMapByType( CmsGlobal::TYPE_PAGE, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'content' => $content,
				'banner' => $content->banner,
				'video' => $content->video,
				'visibilityMap' => $visibilityMap,
				'statusMap' => $statusMap,
				'templatesMap' => $templatesMap
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
