<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\CoreGlobalWeb;

use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\Article;

/**
 * ArticleController provides actions specific to article pages.
 *
 * @since 1.0.0
 */
class ArticleController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $metaService;

	// Protected --------------

	protected $templateService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

		// Config
		$this->layout = CoreGlobalWeb::LAYOUT_PUBLIC;

		// Services
		$this->modelService = Yii::$app->factory->get( 'articleService' );
		$this->metaService	= Yii::$app->factory->get( 'pageMetaService' );

		$this->templateService = Yii::$app->factory->get( 'templateService' );
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
					// secure actions
					'all' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'all' => [ 'get' ],
					'search' => [ 'get' ],
					'author' => [ 'get' ],
					'single' => [ 'get' ]
				]
			]
		];
	}

	// yii\base\Controller ----

	public function actions() {

		if ( !Yii::$app->user->isGuest ) {

			$this->layout = CoreGlobalWeb::LAYOUT_PRIVATE;
		}

		return [
			'error' => [
				'class' => 'yii\web\ErrorAction'
			]
		];
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ArticleController ---------------------

	public function actionAll( $status = null ) {

		$this->layout = CoreGlobalWeb::LAYOUT_PRIVATE;

		$user = Yii::$app->core->getUser();

		$dataProvider = null;

		if( isset( $status ) ) {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id, [ 'status' => Article::$urlRevStatusMap[ $status ] ] );
		}
		else {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id );
		}

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'status' => $status
		]);
	}

	public function actionSearch() {

		$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_ARTICLE );

		if( isset( $template ) ) {

			// View Params
			$model = $this->modelService->getBySlugType( CmsGlobal::PAGE_SEARCH_ARTICLES, CmsGlobal::TYPE_PAGE );

			$this->view->params[ 'model' ] = $model;

			$data = isset( $model ) ? json_decode( $model->data ) : [];

			$this->view->params[ 'data' ]		= isset( $data->data ) ? $data->data : [];
			$this->view->params[ 'attributes' ]	= isset( $data->attributes ) ? $data->attributes : [];
			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];
			$this->view->params[ 'plugins' ] 	= isset( $data->plugins ) ? $data->plugins : [];

			$dataProvider = $this->modelService->getPageForSearch([
				'route' => 'article/search', 'searchContent' => true
			]);

			return Yii::$app->templateManager->renderViewSearch( $template, [
				'dataProvider' => $dataProvider,
				'template' => $template
			]);
		}

		// Error - Template not defined
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionAuthor( $slug ) {

		$author = Yii::$app->factory->get( 'userService' )->getBySlug( $slug );

		if( isset( $author ) ) {

			// View Params
			$this->view->params[ 'model' ] = $author;

			$data = json_decode( $author->data );

			$this->view->params[ 'data' ]		= isset( $data->data ) ? $data->data : [];
			$this->view->params[ 'attributes' ]	= isset( $data->attributes ) ? $data->attributes : [];
			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];
			$this->view->params[ 'plugins' ] 	= isset( $data->plugins ) ? $data->plugins : [];

			$template = $this->templateService->getGlobalBySlugType( CmsGlobal::TEMPLATE_AUTHOR, CmsGlobal::TYPE_ARTICLE );

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'author' => $author,
					'template' => $template
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSingle( $slug, $amp = false ) {

		$model = $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_ARTICLE );

		if( isset( $model ) ) {

			$this->model = $model;

			$user = Yii::$app->core->getUser();

			// No user & Protected
			if( empty( $user ) && $model->isVisibilityProtected() ) {

				// Error- Not allowed
				throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_ALLOWED ) );
			}
			// Published
			else if( !$model->isPublished() ) {

				// Error- No access
				throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_ACCESS ) );
			}

			// View Params
			$data = json_decode( $model->data );

			$this->view->params[ 'model' ]		= $model;
			$this->view->params[ 'data' ]		= isset( $data->data ) ? $data->data : [];
			$this->view->params[ 'attributes' ]	= isset( $data->attributes ) ? $data->attributes : [];
			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];
			$this->view->params[ 'plugins' ] 	= isset( $data->plugins ) ? $data->plugins : [];

			// Find Template
			$content	= $model->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_ARTICLE );
			}

			// Render Template
			if( isset( $template ) ) {

				if( $amp ) {

					return Yii::$app->templateManager->renderViewAmp( $template, [
						'modelService' => $this->modelService,
						'metaService' => $this->metaService,
						'template' => $template,
						'model' => $model,
						'author' => $model->createdBy,
						'content' => $content,
						'banner' => $content->banner
					], [ 'page' => true ] );
				}
				else {

					return Yii::$app->templateManager->renderViewPublic( $template, [
						'modelService' => $this->modelService,
						'metaService' => $this->metaService,
						'template' => $template,
						'model' => $model,
						'author' => $model->createdBy,
						'content' => $content,
						'banner' => $content->banner
					], [ 'page' => true, 'viewPath' => $content->viewPath ] );
				}
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
