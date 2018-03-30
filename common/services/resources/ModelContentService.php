<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\resources;

// CMG Imports

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\resources\IModelContentService;

use cmsgears\core\common\services\base\ModelResourceService;

use cmsgears\core\common\utilities\DateUtil;

/**
 * ModelContentService provide service methods of model content.
 *
 * @since 1.0.0
 */
class ModelContentService extends ModelResourceService implements IModelContentService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\resources\ModelContent';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, $config = [] ) {

		$this->fileService	= $fileService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ModelContentService -------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$parent		= $config[ 'parent' ];
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		// publish
		if( $publish && !isset( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		// parent
		$model->parentId	= $parent->id;
		$model->parentType	= $config[ 'parentType' ];

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		// publish
		if( $publish && !isset( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'videoId' => $video ] );

		return parent::update( $model, [
			'attributes' => [ 'bannerId', 'videoId', 'templateId', 'summary', 'content', 'publishedAt', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ]
		]);
	}

	public function updateBanner( $model, $banner ) {

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner ] );

		return parent::update( $model, [
			'attributes' => [ 'bannerId' ]
		]);
	}

	public function updateViewCount( $model, $views ) {

		$model->views   = $views;

		$model->update();
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$this->fileService->deleteFiles( [ $model->banner, $model->video ] );

		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ModelContentService -------------------

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
