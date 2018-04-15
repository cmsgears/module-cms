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
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPageService;
use cmsgears\cms\common\services\interfaces\resources\IPageMetaService;

use cmsgears\cms\common\services\base\ContentService;

use cmsgears\core\common\services\traits\base\FeaturedTrait;

/**
 * PageService provide service methods of page model.
 *
 * @since 1.0.0
 */
class PageService extends ContentService implements IPageService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Page';

	public static $parentType	= CmsGlobal::TYPE_PAGE;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;
	protected $metaService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use FeaturedTrait;

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

	// PageService ---------------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	public function getMenuPages( $ids, $map = false ) {

		if( count( $ids ) > 0 ) {

			$modelClass	= static::$modelClass;

			if( $map ) {

				$pages = $modelClass::find()->filterWhere( [ 'in', 'id', $ids ] )->all();

				$pageMap = [];

				foreach( $pages as $page ) {

					$pageMap[ $page->id ] = $page;
				}

				return $pageMap;
			}
			else {

				return $modelClass::find()->andFilterWhere( [ 'in', 'id', $ids ] )->all();
			}
		}

		return [];
	}

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

		$galleryClass = $galleryService->getModelClass();

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Create Model
			$model = $this->create( $model, $config );

			// Create and attach gallery
			if( $aGallery ) {

				$gallery = $galleryService->createByParams([
					'type' => CmsGlobal::TYPE_PAGE, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->name,
					'siteId' => Yii::$app->core->siteId
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => CmsGlobal::TYPE_PAGE,
				'publish' => $publish,
				'banner' => $banner, 'video' => $video, 'gallery' => $gallery
			]);

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

	// PageService ---------------------------

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
