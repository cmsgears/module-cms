<?php
namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\cms\common\config\CmsGlobal;

// TODO: Add options to allow user to configure template for search page. A default check in table might be the best option.

class SiteController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	protected $templateService;

	protected $pageService;
	protected $postService;

	protected $categoryService;
	protected $tagService;

	// Private ----------------

	// Constructor and Initialisation ------------------------------

 	public function init() {

		parent::init();

		$this->layout	= WebGlobalCore::LAYOUT_PUBLIC;

		$this->templateService	= Yii::$app->factory->get( 'templateService' );

		$this->pageService		= Yii::$app->factory->get( 'pageService' );
		$this->postService		= Yii::$app->factory->get( 'postService' );

		$this->categoryService	= Yii::$app->factory->get( 'categoryService' );
		$this->tagService		= Yii::$app->factory->get( 'tagService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SiteController ------------------------

	// Site Pages -------------

	/* 1. It finds the associated page for the given slug.
	 * 2. If page is found, the associated template will be used.
	 * 3. If no template found, the cmgcore module's SiteController will handle the request.
	 */
    public function actionIndex( $slug ) {

		$page 	= $this->pageService->getBySlugType( $slug, CmsGlobal::TYPE_PAGE );

		if( isset( $page ) ) {

			// Find Template
			$content	= $page->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_PAGE, CmsGlobal::TYPE_PAGE );
			}

			// Page using Template
			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
		        	'page' => $page,
		        	'author' => $page->createdBy,
		        	'content' => $content,
		        	'banner' => $content->banner
		        ], [ 'page' => true ] );
			}

			// Page without Template - Redirect to System Pages
			return $this->redirect( 'site/' . $page->slug );
		}

		// Page not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// Site Posts -------------

	/* 1. It finds the associated post.
	 * 2. If post is found, the associated template will be used.
	 */
    public function actionPost( $slug ) {

		$post 	= $this->postService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $post ) ) {

			// Find Template
			$content	= $post->modelContent;
			$template	= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			// Post using Template
			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewPublic( $template, [
		        	'page' => $post,
		        	'author' => $post->createdBy,
		        	'content' => $content,
		        	'banner' => $content->banner
		        ], [ 'page' => true ] );
			}

			return $this->render( 'post', [ CoreGlobal::FLASH_GENERIC => Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) ] );
		}

		// Page not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionSearch() {

		$user			= Yii::$app->user->getIdentity();
		$dataProvider	= $this->postService->getPageForSearch( [ 'route' => 'post/search' ] );
		$template		= $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );

		if( isset( $template ) ) {

			return Yii::$app->templateManager->renderViewSearch( $template, [
				'dataProvider' => $dataProvider
			]);
		}

		// Template not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}

	public function actionCategory( $slug ) {

		$category	= $this->categoryService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $category ) ) {

			$user			= Yii::$app->user->getIdentity();
			$content		= $category->modelContent;
			$template		= $content->template;

			// Fallback to default template
			if( empty( $template ) ) {

				$template = $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );
			}

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewCategory( $template, [
					'category' => $category
				]);
			}

			// Template not found
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionTag( $slug ) {

		$tag	= $this->tagService->getBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $tag ) ) {

			$user		= Yii::$app->user->getIdentity();
			$template	= $this->templateService->getBySlugType( CmsGlobal::TEMPLATE_POST, CmsGlobal::TYPE_POST );

			if( isset( $template ) ) {

				return Yii::$app->templateManager->renderViewTag( $template, [
					'tag' => $tag
				]);
			}

			// Template not found
			throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
