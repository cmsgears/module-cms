<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\entities;

// Yii Imports
use Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\resources\Gallery;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPostService;

use cmsgears\cms\common\services\base\ContentService;

/**
 * PostService provide service methods of post model.
 *
 * @since 1.0.0
 */
class PostService extends ContentService implements IPostService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Post';

	public static $parentType	= CmsGlobal::TYPE_POST;

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

	// PostService ---------------------------

	// Data Provider ------

	public function getPublicPage( $config = [] ) {

		$config[ 'route' ] = isset( $config[ 'route' ] ) ? $config[ 'route' ] : 'blog';

		return parent::getPublicPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getFeatured() {

		$modelClass	= static::$modelClass;

		return $modelClass::find()->where( 'featured=:featured', [ ':featured' => true ] )->all();
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		if( !isset( $model->visibility ) ) {

			$model->visibility	= Post::VISIBILITY_PRIVATE;
		}

		return parent::create( $model, $config );
	}

	public function add( $model, $config = [] ) {

		return $this->register( $model, $config );
	}

	public function register( $model, $config = [] ) {

		$content 	= $config[ 'content' ];

		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : false;
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Create Model
			$this->create( $model, $config );

			// Refresh Model
			$model->refresh();

			// Create and attach gallery
			if( $gallery ) {

				$gallery = $galleryService->createByParams([
					'type' => CmsGlobal::TYPE_POST, 'status' => Gallery::STATUS_ACTIVE,
					'name' => $parent->name, 'title' => $parent->name,
					'siteId' => Yii::$app->core->siteId
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => CmsGlobal::TYPE_POST,
				'publish' => $publish,
				'banner' => $banner, 'video' => $video, 'gallery' => $gallery
			]);

			// Bind categories
			$modelCategoryService->bindCategories( $model->id, CmsGlobal::TYPE_POST );

			$model->refresh();

			$transaction->commit();

			return $model;
		}
		catch( Exception $e ) {

			$transaction->rollBack();
		}

		return false;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [ 'parentId', 'name', 'slug', 'icon', 'title', 'description', 'visibility', 'content' ];
		$admin 		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [ 'status', 'order', 'pinned', 'featured', 'comments' ] );
		}

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete dependent models
		Yii::$app->factory->get( 'modelContentService' )->delete( $model->modelContent );
		Yii::$app->factory->get( 'modelCategoryService' )->delete( $model->modelCategories );
		Yii::$app->factory->get( 'modelTagService' )->delete( $model->modelTags );

		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// PostService ---------------------------

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
