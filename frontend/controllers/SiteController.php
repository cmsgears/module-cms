<?php
namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\services\entities\TemplateService;
use cmsgears\core\common\services\resources\CategoryService;
use cmsgears\core\common\services\resources\TagService;

use cmsgears\cms\common\services\entities\PageService;
use cmsgears\cms\frontend\services\entities\PostService;

class SiteController extends \cmsgears\cms\frontend\controllers\base\Controller {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );

		$this->layout	= WebGlobalCore::LAYOUT_PUBLIC;
	}

	// Instance Methods --------------------------------------------

	// SiteController
	/* 1. It finds the associated page for the given slug.
	 * 2. If page is found, the associated template will be used.
	 * 3. If no template found, the cmgcore module's SiteController will handle the request.
	 */
    public function actionIndex( $slug ) {

		$page 	= PageService::findBySlug( $slug );

		if( isset( $page ) ) {

			// Find Template
			$content	= $page->content;
			$template	= $content->template;

			// Page using Template
			if( isset( $template ) ) {

				return Yii::$app->templateSource->renderViewPublic( $template, [
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
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// SiteController
	/* 1. It finds the associated post.
	 * 2. If post is found, the associated template will be used.
	 */
    public function actionPost( $slug ) {

		$post 	= PostService::findBySlug( $slug );

		if( isset( $post ) ) {

			// Find Template
			$content	= $post->content;
			$template	= $content->template;

			// Post using Template
			if( isset( $template ) ) {

				return Yii::$app->templateSource->renderViewPublic( $template, [
		        	'page' => $post,
		        	'author' => $post->createdBy,
		        	'content' => $content,
		        	'banner' => $content->banner
		        ], [ 'page' => true ] );
			}

			return $this->render( 'post', [ CoreGlobal::FLASH_GENERIC => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) ] );
		}

		// Page not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	/*
	public function actionSearch() {

		$user			= Yii::$app->user->getIdentity();
		$dataProvider	= ListingService::getPaginationForSearch();
		$template		= TemplateService::findBySlug( CoreGlobal::TEMPLATE_DEFAULT );

		if( isset( $template ) ) {

			return Yii::$app->templateSource->renderViewSearch( $template, [
				'dataProvider' => $dataProvider
			]);
		}

		// Template not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
	}
	*/

	public function actionCategory( $slug ) {

		$category	= CategoryService::findBySlugType( $slug, CmsGlobal::TYPE_POST );

		if( isset( $category ) ) {

			$user			= Yii::$app->user->getIdentity();
			$template		= TemplateService::findBySlug( 'post' );

			if( isset( $template ) ) {

				return Yii::$app->templateSource->renderViewCategory( $template, [
					'category' => $category
				]);
			}

			// Template not found
			throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	public function actionTag( $slug ) {

		$tag	= TagService::findBySlug( $slug );

		if( isset( $tag ) ) {

			$user			= Yii::$app->user->getIdentity();
			$template		= TemplateService::findBySlug( 'post' );

			if( isset( $template ) ) {

				return Yii::$app->templateSource->renderViewTag( $template, [
					'tag' => $tag
				]);
			}

			// Template not found
			throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NO_TEMPLATE ) );
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>