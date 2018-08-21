<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\actions\data;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\base\Action;

/**
 * The Config action save model config using Config Data Form to the data column.
 */
class Config extends Action {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Config --------------------------------

	public function run( $id ) {

		$modelService = $this->controller->modelService;

		// Find Model
		$model		= $modelService->getById( $id );
		$template	= isset( $model->modelContent->template ) ? $model->modelContent->template : Yii::$app->factory->get( 'templateService' )->getGlobalBySlugType( CoreGlobal::TEMPLATE_DEFAULT, $modelService->getParentType() );

		// Update/Render if exist
		if( isset( $model ) && isset( $template ) ) {

			$configClass	= $template->configPath;
			$config			= new $configClass( $model->getDataMeta( 'config' ) );

			$this->controller->setViewPath( $template->configForm );

			if( $config->load( Yii::$app->request->post(), $config->getClassName() ) && $config->validate() ) {

				$modelService->updateDataMeta( $model, 'config', $config );

				return $this->controller->redirect( $this->controller->returnUrl );
			}

			return $this->controller->render( 'config', [
				'model' => $model,
				'config' => $config
			]);
		}

		// Model not found
		throw new NotFoundHttpException( 'Either model or template not found.' );
	}

}
