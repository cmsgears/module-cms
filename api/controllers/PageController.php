<?php
namespace cmsgears\cms\api\controllers;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\utilities\AjaxUtil;

class PageController extends \cmsgears\core\api\controllers\BaseController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $pageService;
	
	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function init(){
		
		$this->pageService	= Yii::$app->factory->get( 'pageService' );
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------
	
	public function actionSingle( $slug, $type ) {

		$errors = '';
		
		$models = $this->pageService->getBySlugType( $slug, $type );

		if( isset( $models ) ) {

			$response = [];
			
			foreach( $models as $model ) {
				
				$response[] = $model->getAttributes();
			}
			
			return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
		}
		
		$errors = "";
		
		// Trigger Ajax Failure
		return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ), $errors );
	}
}
