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

use cmsgears\cms\common\models\entities\Post;

use cmsgears\cms\frontend\controllers\base\Controller;

/**
 * PostController consist of actions specific to blog posts.
 *
 * @since 1.0.0
 */
class PostController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	protected $categoryService;
	protected $tagService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CoreGlobal::PERM_USER;

		// Config
		$this->layout = CoreGlobalWeb::LAYOUT_PUBLIC;

		// Services
		$this->modelService		= Yii::$app->factory->get( 'postService' );

		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		$this->categoryService	= Yii::$app->factory->get( 'categoryService' );
		$this->tagService		= Yii::$app->factory->get( 'tagService' );
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
					'category' => [ 'get' ],
					'tag' => [ 'get' ],
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

	// PostController ------------------------

	public function actionAll( $status = null ) {

		$this->layout = CoreGlobalWeb::LAYOUT_PRIVATE;

		$user			= Yii::$app->user->getIdentity();
		$dataProvider 	= null;


		if( isset( $status ) ) {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id, [ 'status' => Post::$urlRevStatusMap[ $status ] ] );
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

		$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_POST );

		if( isset( $template ) ) {

			// View Params
			$this->view->params[ 'model' ] = $this->modelService->getBySlugType( CmsGlobal::PAGE_SEARCH_POSTS, CmsGlobal::TYPE_PAGE );

			$dataProvider = $this->modelService->getPageForSearch([
				'route' => 'blog/search', 'searchContent' => true,
				'searchCategory' => true, 'searchTag' => true
			]);

			return Yii::$app->templateManager->renderViewSearch( $template, [
				'dataProvider' => $dataProvider
			]);
		}

		// Error - Template not defined
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionCategory( $slug ) {

		$category = $this->categoryService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $category ) ) {

			$content	= $category->modelContent;
			$template	= $content->template;

			// View Params
			$this->view->params[ 'model' ] = $category;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_POST );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewCategory( $template, [
					'category' => $category
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionTag( $slug ) {

		$tag = $this->tagService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $tag ) ) {

			$content	= $tag->modelContent;
			$template	= $content->template;

			// View Params
			$this->view->params[ 'model' ] = $tag;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_POST );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewTag( $template, [
					'tag' => $tag
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSingle( $slug ) {

		$model = $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $model ) ) {

			if( !$model->isPublished() ) {

				// Error- Not allowed
				throw new UnauthorizedHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_ALLOWED ) );
			}

			// View Params
			$this->view->params[ 'model' ] = $model;

			// Find Template
			$content	= $model->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			// Render Template
			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'model' => $model,
					'author' => $model->createdBy,
					'content' => $content,
					'banner' => $content->banner
				], [ 'page' => true ] );
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
