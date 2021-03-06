<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\actions\gallery;

// Yii Imports
use Yii;
use yii\web\NotFoundHttpException;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\resources\Gallery;

/**
 * The Manage action create the gallery if not exist and than render the view to manage it.
 *
 * @since 1.0.0
 */
class Manage extends \cmsgears\core\common\base\Action {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public $viewPath = '@cmsgears/module-core/admin/views/gallery';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $modelService;

	// Protected --------------

	protected $galleryService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->modelService		= empty( $this->modelService ) ? Yii::$app->controller->modelService : $this->modelService;
		$this->galleryService 	= Yii::$app->factory->get( 'galleryService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Manage --------------------------------

	public function run( $id, $config = [] ) {

		// Find Model
		$model = $this->modelService->getById( $id );

		// Delete/Render if exist
		if( isset( $model ) ) {

			$type = $this->modelService->getParentType();

			$gallery = $model->modelContent->gallery;

			if( empty( $gallery ) ) {

				$name	= !empty( $model->name ) ? $model->name : $model->title;
				$title	= !empty( $model->title ) ? $model->title : $name;

				$gallery = $this->galleryService->createByParams([
					'type' => $type, 'status' => Gallery::STATUS_ACTIVE,
					'name' => $name, 'title' => $title,
					'siteId' => Yii::$app->core->siteId
				]);

				Yii::$app->factory->get( 'modelContentService' )->linkModel( $model->modelContent, 'galleryId', $gallery );
			}

			return $this->controller->render( 'items', [
				'parent' => $model,
				'gallery' => $gallery,
				'items' => $gallery->files
			]);
		}

		// Model not found
		throw new NotFoundHttpException( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_NOT_FOUND ) );
	}

}
