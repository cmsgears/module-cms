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

use cmsgears\cms\frontend\controllers\base\Controller;

/**
 * ArticleController provides actions specific to article pages.
 *
 * @since 1.0.0
 */
class ArticleController extends Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

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

		$this->layout	= CoreGlobalWeb::LAYOUT_PRIVATE;

		$user			= Yii::$app->user->getIdentity();
		$dataProvider 	= null;

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
			$this->view->params[ 'model' ] = $this->modelService->getBySlugType( CmsGlobal::PAGE_SEARCH_ARTICLES, CmsGlobal::TYPE_PAGE );

			$dataProvider = $this->modelService->getPageForSearch([
				'route' => 'article/search', 'searchContent' => true
			]);

			return Yii::$app->templateManager->renderViewSearch( $template, [
				'dataProvider' => $dataProvider
			]);
		}

		// Error - Template not defined
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionSingle( $slug ) {

		$user	= Yii::$app->core->getUser();
		$model	= $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_ARTICLE );

		if( isset( $model ) ) {

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
			$this->view->params[ 'model' ] = $model;

			// Find Template
			$content	= $model->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_ARTICLE );
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
