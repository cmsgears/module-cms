<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\base;

// Yii Imports
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\File;

/**
 * PageController provides actions specific to page model.
 *
 * @since 1.0.0
 */
abstract class PageController extends \cmsgears\core\admin\controllers\base\CrudController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $title;
	public $comments;

	public $tagWidgetSlug;

	public $parentType;

	public $metaService;

	// Protected --------------

	protected $type;
	protected $templateType;
	protected $parentModel;

	protected $templateService;
	protected $modelContentService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/admin/views/page' );

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Config
		$this->type			= CmsGlobal::TYPE_PAGE;
		$this->parentType	= CmsGlobal::TYPE_PAGE;
		$this->templateType	= CmsGlobal::TYPE_PAGE;
		$this->comments		= false;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'pageService' );
		$this->metaService		= Yii::$app->factory->get( 'pageMetaService' );
		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		$this->modelContentService = Yii::$app->factory->get( 'modelContentService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function behaviors() {

		$behaviors = parent::behaviors();

		$behaviors[ 'rbac' ][ 'actions' ][ 'gallery' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'data' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'attributes' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'config' ] = [ 'permission' => $this->crudPermission ];
		$behaviors[ 'rbac' ][ 'actions' ][ 'settings' ] = [ 'permission' => $this->crudPermission ];

		$behaviors[ 'verbs' ][ 'actions' ][ 'gallery' ] = [ 'get' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'data' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'attributes' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'config' ] = [ 'get', 'post' ];
		$behaviors[ 'verbs' ][ 'actions' ][ 'settings' ] = [ 'get', 'post' ];

		return $behaviors;
	}

	// yii\base\Controller ----

	public function actions() {

		return [
			'gallery' => [ 'class' => 'cmsgears\cms\common\actions\gallery\Manage' ],
			'data' => [ 'class' => 'cmsgears\cms\common\actions\data\data\Form' ],
			'attributes' => [ 'class' => 'cmsgears\cms\common\actions\data\attribute\Form' ],
			'config' => [ 'class' => 'cmsgears\cms\common\actions\data\config\Form' ],
			'settings' => [ 'class' => 'cmsgears\cms\common\actions\data\setting\Form' ]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------

	public function actionAll( $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		$dataProvider = $this->modelService->getPageByType( $this->type );

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$subStatusMap,
			'filterStatusMap' => $modelClass::$filterSubStatusMap
		]);
	}

	public function actionCreate( $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		$model = new $modelClass;

		$model->siteId		= Yii::$app->core->siteId;
		$model->type		= $this->type;
		$model->comments	= $this->comments;

		$content = $this->modelContentService->getModelObject();

		$avatar		= File::loadFile( null, 'Avatar' );
		$banner		= File::loadFile( null, 'Banner' );
		$mbanner	= File::loadFile( null, 'MobileBanner' );
		$video		= File::loadFile( null, 'Video' );
		$mvideo		= File::loadFile( null, 'MobileVideo' );

		if( isset( $this->parentModel ) ) {

			$model->parentId = $this->parentModel->id;
		}

		if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
			$model->validate() && $content->validate() ) {

			$this->model = $this->modelService->add( $model, [
				'admin' => true, 'content' => $content,
				'publish' => $model->isActive(), 'avatar' => $avatar,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo
			]);

			if( $this->model ) {

				return $this->redirect( $this->returnUrl );
			}
		}

		$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

		return $this->render( 'create', [
			'model' => $model,
			'content' => $content,
			'avatar' => $avatar,
			'banner' => $banner,
			'mbanner' => $mbanner,
			'video' => $video,
			'mvideo' => $mvideo,
			'visibilityMap' => $modelClass::$visibilityMap,
			'statusMap' => $modelClass::$subStatusMap,
			'templatesMap' => $templatesMap
		]);
	}

	public function actionUpdate( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Update/Render if exist
		if( isset( $model ) ) {

			$content	= $model->modelContent;
			$template	= $content->template;

			$avatar		= File::loadFile( $model->avatar, 'Avatar' );
			$banner		= File::loadFile( $content->banner, 'Banner' );
			$mbanner	= File::loadFile( $content->mobileBanner, 'MobileBanner' );
			$video		= File::loadFile( $content->video, 'Video' );
			$mvideo		= File::loadFile( $content->mobileVideo, 'MobileVideo' );

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) && $content->load( Yii::$app->request->post(), $content->getClassName() ) &&
				$model->validate() && $content->validate() ) {

				$this->model = $this->modelService->update( $model, [
					'admin' => true, 'content' => $content,
					'publish' => $model->isActive(), 'oldTemplate' => $template,
					'avatar' => $avatar, 'banner' => $banner, 'mbanner' => $mbanner,
					'video' => $video, 'mvideo' => $mvideo
				]);

				return $this->redirect( $this->returnUrl );
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			$tagTemplate	= $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_TAG, $this->templateType );
			$tagTemplateId	= isset( $tagTemplate ) ? $tagTemplate->id : null;

			return $this->render( 'update', [
				'model' => $model,
				'content' => $content,
				'avatar' => $avatar,
				'banner' => $banner,
				'mbanner' => $mbanner,
				'video' => $video,
				'mvideo' => $mvideo,
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$subStatusMap,
				'templatesMap' => $templatesMap,
				'tagTemplateId' => $tagTemplateId
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionDelete( $id, $config = [] ) {

		$modelClass = $this->modelService->getModelClass();

		// Find Model
		$model = $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$content = $model->modelContent;

			if( $model->load( Yii::$app->request->post(), $model->getClassName() ) ) {

				try {

					$this->model = $model;

					$this->modelService->delete( $model, [ 'admin' => true ] );

					return $this->redirect( $this->returnUrl );
				}
				catch( Exception $e ) {

					throw new HttpException( 409, Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
				}
			}

			$templatesMap = $this->templateService->getIdNameMapByType( $this->templateType, [ 'default' => true ] );

			return $this->render( 'delete', [
				'model' => $model,
				'content' => $content,
				'avatar' => $model->avatar,
				'banner' => $content->banner,
				'mbanner' => $content->mobileBanner,
				'video' => $content->video,
				'mvideo' => $content->mobileVideo,
				'visibilityMap' => $modelClass::$visibilityMap,
				'statusMap' => $modelClass::$subStatusMap,
				'templatesMap' => $templatesMap
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
