<?php
namespace cmsgears\cms\common\actions\content;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\File;

use cmsgears\core\common\utilities\AjaxUtil;

/**
 * UpdateBanner can be used to update banner of discovered model using corresponding model content.
 */
class UpdateBanner extends \cmsgears\core\common\actions\base\ModelAction {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $fileName	= 'Banner';

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// AssignTags ----------------------------

	public function run() {

		if( isset( $this->model ) ) {

			$modelContentService = Yii::$app->factory->get( 'modelContentService' );

			$content	= $this->model->modelContent;
			$banner		= File::loadFile( $content->banner, $this->fileName );

			if( $modelContentService->updateBanner( $content, $banner ) ) {

				$response	= [ 'fileUrl' => $banner->getFileUrl() ];

				// Trigger Ajax Success
				return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
			}

			// Trigger Ajax Failure
			return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_REQUEST ) );
		}

		// Trigger Ajax Failure
		return AjaxUtil::generateFailure( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}
}
