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
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\CoreGlobalWeb;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\Post;

/**
 * PostController consist of actions specific to blog posts.
 *
 * @since 1.0.0
 */
class PostController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $metaService;

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
		$this->layout	= CoreGlobalWeb::LAYOUT_PUBLIC;
		$this->baseUrl	= '/cms/post';
		$this->apixBase	= 'cms/post';

		// Services
		$this->modelService = Yii::$app->factory->get( 'postService' );
		$this->metaService	= Yii::$app->factory->get( 'pageMetaService' );

		$this->templateService = Yii::$app->factory->get( 'templateService' );

		$this->categoryService	= Yii::$app->factory->get( 'categoryService' );
		$this->tagService		= Yii::$app->factory->get( 'tagService' );

		// Return Url
		$this->returnUrl = Url::previous( 'posts' );
		$this->returnUrl = isset( $this->returnUrl ) ? $this->returnUrl : Url::toRoute( [ '/cms/post/all' ], true );
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
					'all' => [ 'permission' => $this->crudPermission ],
					'add' => [ 'permission' => $this->crudPermission ]
				]
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'home' => [ 'get' ],
					'all' => [ 'get' ],
					'add' => [ 'get' ],
					'search' => [ 'get' ],
					'category' => [ 'get' ],
					'tag' => [ 'get' ],
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

	// PostController ------------------------

	/**
	 * Redirects user to appropriate page according to the status.
	 */
	public function actionHome( $slug ) {

		$this->layout = CoreGlobalWeb::LAYOUT_PRIVATE;

		$user	= Yii::$app->core->getUser();
		$model	= $this->modelService->getFirstBySlug( $slug );

		if( isset( $model ) && $model->isOwner( $user ) ) {

			$content	= $model->modelContent;
			$template	= $content->template;

			if( isset( $template ) ) {

				return $this->redirect( [ "/cms/post/$template->slug/home?slug=$slug" ] );
			}

			throw new ForbiddenHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_ACCESS ) );
		}

		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionAll( $status = null ) {

		$this->layout = CoreGlobalWeb::LAYOUT_PRIVATE;

		$user = Yii::$app->core->getUser();

		$dataProvider = null;

		if( isset( $status ) ) {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id, [ 'status' => Post::$urlRevStatusMap[ $status ] ] );
		}
		else {

			$dataProvider = $this->modelService->getPageByOwnerId( $user->id );
		}

		return $this->render( 'all', [
			'dataProvider' => $dataProvider,
			'statusMap' => Post::$statusMap,
			'status' => $status
		]);
	}

	public function actionAdd() {

		$templatesMap = $this->templateService->getSlugModelMapByType( CmsGlobal::TYPE_POST );

		return $this->render( 'add', [
			'templatesMap' => $templatesMap
		]);
	}

	public function actionSearch() {

		$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_POST );

		if( isset( $template ) ) {

			// View Params
			$model = $this->modelService->getBySlugType( CmsGlobal::PAGE_SEARCH_POSTS, CmsGlobal::TYPE_PAGE );

			$this->view->params[ 'model' ] = $model;

			$data = isset( $model ) ? json_decode( $model->data ) : [];

			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

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

			$data = json_decode( $category->data );

			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

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

			$data = json_decode( $tag->data );

			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

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

	public function actionAuthor( $slug ) {

		$author = Yii::$app->factory->get( 'userService' )->getBySlug( $slug );

		if( isset( $author ) ) {

			// View Params
			$this->view->params[ 'model' ] = $author;

			$data = json_decode( $author->data );

			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

			$template = $this->templateService->getGlobalBySlugType( CmsGlobal::TEMPLATE_AUTHOR, CmsGlobal::TYPE_POST );

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
					'author' => $author
				]);
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSingle( $slug, $amp = false ) {

		$model = $this->modelService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $model ) ) {

			$user = Yii::$app->core->getUser();

			// No user & Protected/Private
			if( empty( $user ) && $model->isVisibilityProtected( false ) ) {

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

			$data = json_decode( $model->data );

			$this->view->params[ 'settings' ] 	= isset( $data->settings ) ? $data->settings : [];
			$this->view->params[ 'config' ] 	= isset( $data->config ) ? $data->config : [];

			// Find Template
			$content	= $model->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, CmsGlobal::TYPE_POST );
			}

			// Render Template
			if( isset( $template ) ) {

				if( $amp ) {

					return Yii::$app->templateManager->renderViewAmp( $template, [
						'modelService' => $this->modelService,
						'metaService' => $this->metaService,
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
						'model' => $model,
						'author' => $model->createdBy,
						'content' => $content,
						'banner' => $content->banner
					], [ 'page' => true ] );
				}
			}

			// Error - Template not defined
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Error- Post not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
