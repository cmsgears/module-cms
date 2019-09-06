<?php
namespace cmsgears\cms\api\controllers;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\utilities\AjaxUtil;

class PostController extends \cmsgears\core\api\controllers\BaseController {

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
		
		$this->modelService	= Yii::$app->factory->get( 'modelService' );
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------
	
	public function actionSingle( $slug, $type ) {

		$errors = '';
		
		$models = $this->modelService->getBySlugType( $slug, $type );

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
