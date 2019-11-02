<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\resources;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\resources\IModelContentService;

use cmsgears\core\common\services\base\ModelResourceService;

use cmsgears\core\common\services\traits\resources\VisualTrait;
use cmsgears\core\common\services\traits\resources\DataTrait;

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

	use VisualTrait;
	use DataTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, $config = [] ) {

		$this->fileService = $fileService;

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
		$mbanner	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		// Publish
		if( $publish && empty( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		// Configure parent
		$model->parentId	= $parent->id;
		$model->parentType	= $config[ 'parentType' ];

		// Save resources
		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'mbannerId' => $mbanner, 'videoId' => $video ] );

		// Link gallery
		if( isset( $gallery ) && $gallery->id > 0 ) {

			$model->galleryId = $gallery->id;
		}

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		// Publish
		if( $publish && empty( $model->publishedAt ) ) {

			$model->publishedAt	= DateUtil::getDateTime();
		}

		// Save resources
		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'mbannerId' => $mbanner, 'videoId' => $video ] );

		// Link gallery
		if( empty( $model->galleryId ) ) {

			$this->linkModel( $model, 'galleryId', $gallery );
		}

		return parent::update( $model, [
			'attributes' => [
				'templateId', 'bannerId', 'mbannerId', 'videoId', 'galleryId', 'summary',
				'content', 'publishedAt', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot', 'seoSchema'
			]
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete resources
		$this->fileService->deleteMultiple( [ $model->banner, $model->video ] );

		// Delete Gallery
		if( isset( $model->gallery ) ) {

			Yii::$app->factory->get( 'galleryService' )->delete( $model->gallery );
		}

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
