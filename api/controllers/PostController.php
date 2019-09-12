<?php
namespace cmsgears\cms\api\controllers;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\utilities\AjaxUtil;
use cmsgears\core\common\config\CoreGlobal;

class PostController extends \cmsgears\core\api\controllers\BaseController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $modelService;
	
	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function init(){
		
		$this->modelService	= Yii::$app->factory->get( 'postService' );
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PageController ------------------------
	
	public function actionAll(){
	
		$dataprovider = $this->modelService->getPage();
		
		$models =  $dataprovider->getModels();
		
		$response = [];
		
		foreach( $models as $model ){
			
			$modelContent = $model->modelContent;
			
			$attributes = $model->getAttributes();
			
			$attributes[ 'content' ] = $modelContent->content;
			$attributes[ 'bannerUrl' ] = $modelContent->bannerUrl;
			
			$response[] = $attributes;
		}
		
		return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
	}
	
	public function actionSingle( $slug, $type ) {

		$model = $this->modelService->getBySlugType( $slug, $type );

		$response = [];

		if( isset( $model ) ) {

			$modelContent = $model->modelContent;
			
			$attributes = $model->getAttributes();
			
			$attributes[ 'content' ] = $modelContent->content;
			$attributes[ 'bannerUrl' ] = $modelContent->bannerUrl;
			
			$response[] = $attributes;
		}
		
		return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
	}
}

