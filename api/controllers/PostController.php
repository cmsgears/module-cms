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
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\utilities\AjaxUtil;

class PostController extends \cmsgears\core\api\controllers\base\Controller {

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
		$this->modelService	= Yii::$app->factory->get( 'postService' );
	}

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// PostController ------------------------

	public function actionAll() {

		$dataprovider = $this->modelService->getPageForSearch([
			'route' => 'blog/search', 'searchContent' => true,
			'searchCategory' => true, 'searchTag' => true,  'public' => true
		]);

		$models = $dataprovider->getModels();

		$response = [];

		foreach( $models as $model ) {

			$modelContent = $model->modelContent;

			$attributes = $model->getAttributes();

			$attributes[ 'content' ] = $modelContent->content;
			$attributes[ 'bannerUrl' ] = $modelContent->bannerUrl;

			$response[] = $attributes;
		}

		return AjaxUtil::generateSuccess( Yii::$app->coreMessage->getMessage( CoreGlobal::MESSAGE_REQUEST ), $response );
	}

	public function actionSearch() {

		$dataprovider = $this->modelService->getPageForSearch([
			'route' => 'blog/search', 'searchContent' => true,
			'searchCategory' => true, 'searchTag' => true, 'public' => true
		]);

		$models = $dataprovider->getModels();

		$response = [];

		if( isset( $models ) ) {

			foreach( $models as $model ) {

				$modelContent = $model->modelContent;

				$attributes = $model->getAttributes();

				$attributes[ 'content' ] = $modelContent->content;
				$attributes[ 'bannerUrl' ] = $modelContent->bannerUrl;

				$response[] = $attributes;
			}
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
