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
use cmsgears\cms\common\services\interfaces\entities\IArticleService;
use cmsgears\cms\common\services\interfaces\resources\IPageMetaService;

use cmsgears\core\common\services\traits\base\FeaturedTrait;

/**
 * ArticleService provide service methods of article model.
 *
 * @since 1.0.0
 */
class ArticleService extends \cmsgears\cms\common\services\base\ContentService implements IArticleService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\entities\Article';

	public static $parentType = CmsGlobal::TYPE_ARTICLE;

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

	// ArticleService ------------------------

	// Data Provider ------

	public function getPublicPage( $config = [] ) {

		$modelTable	= $this->getModelTable();

		$config[ 'route' ] = isset( $config[ 'route' ] ) ? $config[ 'route' ] : 'article';

		$config[ 'conditions' ][ "$modelTable.type" ] = static::$parentType;

		return parent::getPublicPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$avatar = isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;

		// Save Files
		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar ] );

		// Create Model
		return parent::create( $model, $config );
	}

	public function add( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$modelClass = static::$modelClass;

		$content 	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : new ModelContent();
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner 	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo 	= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		$galleryClass = $galleryService->getModelClass();

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Copy Template
			$config[ 'template' ] = $content->template;

			$this->copyTemplate( $model, $config );

			// Create Model
			$model = $this->create( $model, $config );

			// Create Gallery
			if( isset( $gallery ) ) {

				$gallery->siteId	= $model->siteId;
				$gallery->type		= static::$parentType;
				$gallery->status	= $galleryClass::STATUS_ACTIVE;
				$gallery->name		= empty( $gallery->name ) ? $model->name : $gallery->name;

				$gallery = $galleryService->create( $gallery );
			}
			else {

				$gallery = $galleryService->createByParams([
					'siteId' => $model->siteId,
					'type' => static::$parentType, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->title
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => static::$parentType,
				'publish' => $publish,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo,
				'gallery' => $gallery
			]);

			$transaction->commit();
		}
		catch( Exception $e ) {

			$transaction->rollBack();

			return false;
		}

		return $model;
	}

	public function register( $model, $config = [] ) {

		$notify	= isset( $config[ 'notify' ] ) ? $config[ 'notify' ] : true;

		$modelClass = static::$modelClass;

		$content 	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : new ModelContent();
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner 	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo 	= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;
		$adminLink	= isset( $config[ 'adminLink' ] ) ? $config[ 'adminLink' ] : 'cms/article/review';

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		$galleryClass = $galleryService->getModelClass();

		$user = Yii::$app->core->getUser();

		$registered	= false;

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Copy Template
			$config[ 'template' ] = $content->template;

			$this->copyTemplate( $model, $config );

			// Create Model
			$model = $this->create( $model, $config );

			// Create Gallery
			if( isset( $gallery ) ) {

				$gallery->siteId	= $model->siteId;
				$gallery->type		= static::$parentType;
				$gallery->status	= $galleryClass::STATUS_ACTIVE;
				$gallery->name		= empty( $gallery->name ) ? $model->name : $gallery->name;

				$gallery = $galleryService->create( $gallery );
			}
			else {

				$gallery = $galleryService->createByParams([
					'siteId' => $model->siteId,
					'type' => static::$parentType, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->title
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => static::$parentType,
				'publish' => $publish,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo,
				'gallery' => $gallery
			]);

			$transaction->commit();

			$registered	= true;
		}
		catch( Exception $e ) {

			$transaction->rollBack();

			return false;
		}

		if( $registered ) {

			// Notify Site Admin
			if( $notify ) {

				$this->notifyAdmin( $model, [
					'template' => CmsGlobal::TPL_NOTIFY_ARTICLE_NEW,
					'adminLink' => "{$adminLink}?id={$model->id}"
				]);
			}
		}

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$content 	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;
		$publish	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$avatar 	= isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$banner 	= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner 	= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video 		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo 	= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery	= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'parentId', 'avatarId', 'name', 'slug', 'icon', 'texture',
			'title', 'description', 'visibility', 'content'
		];

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [
				'status', 'order', 'pinned', 'featured', 'comments'
			]);
		}

		// Copy Template
		if( isset( $content ) ) {

			$config[ 'template' ] = $content->template;

			if( $this->copyTemplate( $model, $config ) ) {

				$attributes[] = 'data';
			}
		}

		// Services
		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );

		// Save Files
		$this->fileService->saveFiles( $model, [ 'avatarId' => $avatar ] );

		// Create/Update gallery
		if( isset( $gallery ) ) {

			$gallery = $galleryService->createOrUpdate( $gallery );
		}

		// Update model content
		if( isset( $content ) ) {

			$modelContentService->update( $content, [
				'publish' => $publish,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo,
				'gallery' => $gallery
			]);
		}

		// Model Checks
		$oldStatus = $model->getOldAttribute( 'status' );

		$model = parent::update( $model, [
			'attributes' => $attributes
		]);

		// Check status change and notify User
		if( isset( $model->userId ) && $oldStatus != $model->status ) {

			$config[ 'users' ] = [ $model->userId ];

			$config[ 'data' ][ 'message' ] = 'Article status changed.';

			$this->checkStatusChange( $model, $oldStatus, $config );
		}

		return $model;
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$config[ 'hard' ] = $config[ 'hard' ] ?? !Yii::$app->core->isSoftDelete();

		if( $config[ 'hard' ] ) {

			$transaction = Yii::$app->db->beginTransaction();

			try {

				// Delete metas
				$this->metaService->deleteByModelId( $model->id );

				// Delete files
				$this->fileService->deleteMultiple( ArrayHelper::merge( $model->files, [ $model->avatar ] ) );

				// Delete File Mappings of Shared Files
				Yii::$app->factory->get( 'modelFileService' )->deleteMultiple( $model->modelFiles );

				// Delete Model Content
				Yii::$app->factory->get( 'modelContentService' )->delete( $model->modelContent );

				// Delete Option Mappings
				Yii::$app->factory->get( 'modelOptionService' )->deleteByParent( $model->id, static::$parentType );

				// Delete Comments
				Yii::$app->factory->get( 'modelCommentService' )->deleteByParent( $model->id, static::$parentType );

				// Delete Followers
				Yii::$app->factory->get( 'pageFollowerService' )->deleteByModelId( $model->id );

				// Commit
				$transaction->commit();
			}
			catch( Exception $e ) {

				$transaction->rollBack();

				throw new Exception( Yii::$app->coreMessage->getMessage( CoreGlobal::ERROR_DEPENDENCY )  );
			}
		}

		// Delete model
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		$config[ 'users' ] = isset( $config[ 'users' ] ) ? $config[ 'users' ] : ( isset( $model->userId ) ? [ $model->userId ] : [] );

		return parent::applyBulk( $model, $column, $action, $target, $config );
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ArticleService ------------------------

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
