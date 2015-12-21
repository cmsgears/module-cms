<?php
namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;
use cmsgears\cms\common\config\CmsGlobal;
use cmsgears\cms\frontend\config\WebGlobalCms;

use cmsgears\cms\common\services\PageService;
use cmsgears\cms\common\services\PostService;

use cmsgears\core\common\utilities\MessageUtil;

class SiteController extends \cmsgears\core\frontend\controllers\base\Controller {

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

				$layout			= $template->layout;
				$view			= $template->viewPath . "/$template->frontendView";
				$this->layout	= "//$layout";

				// Render using Template
				if( isset( $layout ) && isset( $view ) ) {

			        return $this->render( $view, [
			        	'page' => $page,
			        	'author' => $page->createdBy,
			        	'content' => $content,
			        	'banner' => $content->banner
			        ]);
				}
				else {

					return $this->render( 'index', [ CoreGlobal::FLASH_GENERIC => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::ERROR_NO_VIEW ) ] );
				}
			}
			// Page without Template - Redirect to System Pages
			else {

				return $this->redirect( 'site/' . $page->slug );
			}
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

			// Page using Template
			if( isset( $template ) ) {

				$layout			= $template->layout;
				$view			= $template->viewPath . "/$template->frontendView";
				$this->layout	= "//$layout";

				// Render using Template
				if( isset( $layout ) && isset( $view ) ) {

			        return $this->render( $view, [
			        	'page' => $post,
			        	'author' => $post->createdBy,
			        	'content' => $content,
			        	'banner' => $content->banner
			        ]);
				}
				else {

					return $this->render( 'index', [ CoreGlobal::FLASH_GENERIC => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::ERROR_NO_VIEW ) ] );
				}
			}
			else {

				return $this->render( 'post', [ CoreGlobal::FLASH_GENERIC => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::ERROR_NO_TEMPLATE ) ] );
			}
		}

		// Page not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>