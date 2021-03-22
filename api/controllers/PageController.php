<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\api\controllers;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\utilities\AjaxUtil;

class PageController extends \cmsgears\core\api\controllers\base\Controller {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	public function init() {

		parent::init();

		// Services
		$this->modelService	= Yii::$app->factory->get( 'pageService' );
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
