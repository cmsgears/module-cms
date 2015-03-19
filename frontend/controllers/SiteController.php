<?php
namespace cmsgears\modules\cms\frontend\controllers;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\modules\core\common\config\CoreGlobal;
use cmsgears\modules\core\frontend\config\WebGlobalCore;

use cmsgears\modules\cms\common\services\PageService;
use cmsgears\modules\cms\common\services\PostService;

use cmsgears\modules\core\frontend\controllers\BaseController;

use cmsgears\modules\core\common\utilities\MessageUtil;

class SiteController extends BaseController {

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	// SiteController
	/* 1. It finds the associated page. 
	 * 2. If page is found, the associated template will be used.
	 * 3. If no template found, the cmgcore module's SiteController will handle the request.
	 */
    public function actionIndex( $slug ) {

		$page 	= PageService::findBySlug( $slug );

		if( isset( $page ) ) {

			// Set Layout
			$template		= $page->getTemplate();

			if( isset( $template ) && strlen( $template ) > 0 ) {

				$this->layout	= "/layout-" . $template;

				// Render using Template
		        return $this->render( "template-" . $template, [ 'page' => $page ] );
			}
			else {

				return $this->redirect( "site/" . $page->getSlug() );
			}
		}

		// Page not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

	// SiteController
	/* 1. It finds the associated post.
	 * 2. If post is found, the associated template will be used.
	 */
    public function actionPost( $slug ) {

		$post 	= PostService::findBySlug( $slug );

		if( isset( $post ) ) {

			// Set Layout
			$template		= $post->getTemplate();

			if( isset( $template ) && strlen( $template ) > 0 ) {

				$this->layout	= "/layout-" . $template;

				// Render using Template
		        return $this->render( "template-" . $template, [ 'page' => $post ] );
			}
			else {

				echo "No template found having the name $template.";
			}
		}

		// Page not found
		throw new NotFoundHttpException( MessageUtil::getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}

?>