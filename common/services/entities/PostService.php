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
use yii\base\Exception;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPostService;
use cmsgears\cms\common\services\interfaces\resources\IPageMetaService;

use cmsgears\cms\common\services\base\ContentService;

use cmsgears\core\common\services\traits\base\FeaturedTrait;
use cmsgears\core\common\services\traits\base\SimilarTrait;
use cmsgears\core\common\services\traits\mappers\CategoryTrait;

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
	protected $metaService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use FeaturedTrait;
	use SimilarTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, IPageMetaService $metaService, $config = [] ) {

		$this->fileService	= $fileService;
		$this->metaService 	= $metaService;

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

		$modelTable	= $this->getModelTable();

		$config[ 'route' ] = isset( $config[ 'route' ] ) ? $config[ 'route' ] : 'blog';

		$config[ 'conditions' ][ "$modelTable.type" ] = static::$parentType;

		return parent::getPublicPage( $config );
	}

	public function getPageForSimilar( $config = [] ) {

		$modelTable	= $this->getModelTable();
		$modelClass	= static::$modelClass;

		$config[ 'query' ] = isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::queryWithContent();
		$config[ 'query' ] = $this->generateSimilarQuery( $config );

		$config[ 'conditions' ][ "$modelTable.type" ] = static::$parentType;

		return $this->getPublicPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$modelClass = static::$modelClass;

		if( !isset( $model->visibility ) ) {

			$model->visibility	= $modelClass::VISIBILITY_PRIVATE;
		}

		return parent::create( $model, $config );
	}

	public function add( $model, $config = [] ) {

		return $this->register( $model, $config );
	}

	public function register( $model, $config = [] ) {

		$gallery	= null;
		$content 	= $config[ 'content' ];

		$aGallery	= isset( $config[ 'attachGallery' ] ) ? $config[ 'attachGallery' ] : false;
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );
		$modelTagService		= Yii::$app->factory->get( 'modelTagService' );

		$galleryClass = $galleryService->getModelClass();

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Create Model
			$model = $this->create( $model, $config );

			// Create and attach gallery
			if( $aGallery ) {

				$gallery = $galleryService->createByParams([
					'type' => CmsGlobal::TYPE_POST, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->name,
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
			$modelCategoryService->bindCategories( $model->id, CmsGlobal::TYPE_POST, [ 'binder' => 'CategoryBinder' ] );

			// Bind tags
			$modelTagService->bindTags( $model->id, CmsGlobal::TYPE_POST, [ 'binder' => 'TagBinder' ] );

			$transaction->commit();

			return $model;
		}
		catch( Exception $e ) {
			var_dump( $e );
			$transaction->rollBack();
		}

		return false;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin 		= isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'parentId', 'name', 'slug', 'icon',
			'title', 'description', 'visibility', 'content'
		];

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [ 'status', 'order', 'pinned', 'featured', 'comments' ] );
		}

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Delete metas
			$this->metaService->deleteByModelId( $model->id );

			// Delete files
			$this->fileService->deleteFiles( $model->files );

			// Delete Model Content
			Yii::$app->factory->get( 'modelContentService' )->delete( $model->modelContent );

			// Delete Category Mappings
			Yii::$app->factory->get( 'modelCategoryService' )->deleteByParent( $model->id, static::$parentType );

			// Delete Tag Mappings
			Yii::$app->factory->get( 'modelTagService' )->deleteByParent( $model->id, static::$parentType );

			// Delete Option Mappings
			Yii::$app->factory->get( 'modelOptionService' )->deleteByParent( $model->id, static::$parentType );

			// Delete Comments
			Yii::$app->factory->get( 'modelCommentService' )->deleteByParent( $model->id, static::$parentType );

			// Delete Followers
			Yii::$app->factory->get( 'pageFollowerService' )->deleteByModelId( $model->id );

			$transaction->commit();

			// Delete model
			return parent::delete( $model, $config );
		}
		catch( Exception $e ) {

			$transaction->rollBack();

			throw new Exception( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
		}

		return false;
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
