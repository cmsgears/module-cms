<?php
namespace cmsgears\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\core\frontend\config\WebGlobalCore;

use cmsgears\cms\common\services\PageService;
use cmsgears\cms\common\services\PostService;

use cmsgears\core\frontend\controllers\BaseController;

use cmsgears\core\common\utilities\MessageUtil;

class SiteController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
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

			// Set Layout
			$templateName	= $page->getTemplateName();

			// Page using Template
			if( isset( $templateName ) && strlen( $templateName ) > 0 ) {

				$this->layout	= "$templateName";
				$webProperties	= $this->getWebProperties();
				$themeName		= $webProperties->getTheme();

				// Render using Template
		        return $this->render( "@themes/$themeName/views/templates/" . $templateName, [ 'page' => $page ] );
			}
			// Page without Template
			else {

				return $this->redirect( "site/" . $page->getSlug() );
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

			// Set Layout
			$templateName	= $post->getTemplateName();

			if( isset( $templateName ) && strlen( $templateName ) > 0 ) {

				$this->layout	= "/$templateName";

				// Render using Template
		        return $this->render( "template-" . $templateName, [ 'page' => $post ] );
			}
			else {

				echo "No template found having the name $template.";
			}
		}

		// Page not found
		throw new NotFoundHttpException( Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>