<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\mappers\ModelBlock;

use cmsgears\cms\common\services\interfaces\entities\IBlockService;

use cmsgears\core\common\services\entities\ObjectDataService;

/**
 * BlockService provide service methods of block model.
 *
 * @since 1.0.0
 */
class BlockService extends ObjectDataService implements IBlockService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Block';

	public static $parentType	= CmsGlobal::TYPE_BLOCK;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlockService --------------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$texture	= isset( $config[ 'texture' ] ) ? $config[ 'texture' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'textureId' => $texture, 'videoId' => $video ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$texture	= isset( $config[ 'texture' ] ) ? $config[ 'texture' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'textureId' => $texture, 'videoId' => $video ] );

		return parent::update( $model, [
			'attributes' => [ 'templateId', 'bannerId', 'textureId', 'videoId', 'name', 'description', 'active', 'htmlOptions', 'title', 'icon', 'content', 'data' ]
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete files
		$this->fileService->deleteFiles( [ $model->banner, $model->texture, $model->video ] );

		// Delete mappings
		Yii::$app->get( 'modelBlockService' )->deleteByModelId( $model->id );

		// Delete model
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// BlockService --------------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
