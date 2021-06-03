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

use cmsgears\cms\common\models\resources\ModelContent;

use cmsgears\core\common\services\interfaces\resources\IFileService;
use cmsgears\cms\common\services\interfaces\entities\IPostService;
use cmsgears\cms\common\services\interfaces\resources\IPageMetaService;
use cmsgears\cms\common\services\interfaces\mappers\IPageFollowerService;

use cmsgears\core\common\services\traits\base\SimilarTrait;
use cmsgears\core\common\services\traits\mappers\CategoryTrait;

/**
 * PostService provide service methods of post model.
 *
 * @since 1.0.0
 */
class PostService extends \cmsgears\cms\common\services\base\ContentService implements IPostService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\entities\Post';

	public static $parentType = CmsGlobal::TYPE_POST;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $fileService;
	protected $metaService;
	protected $followerService;

	// Private ----------------

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use SimilarTrait;

	// Constructor and Initialisation ------------------------------

	public function __construct( IFileService $fileService, IPageMetaService $metaService, IPageFollowerService $followerService, $config = [] ) {

		$this->fileService	= $fileService;
		$this->metaService 	= $metaService;

		$this->followerService = $followerService;

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

		$modelClass	= static::$modelClass;

		$config[ 'query' ] = isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::queryWithContent();
		$config[ 'query' ] = $this->generateSimilarQuery( $config );

		return $this->getPublicPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	public function getEmail( $model ) {

		return isset( $model->userId ) ? $model->user->email : $model->creator->email;
	}

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
		$parentType	= static::$parentType;

		$content		= isset( $config[ 'content' ] ) ? $config[ 'content' ] : new ModelContent();
		$publish		= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner			= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner		= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video			= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo			= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery		= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;
		$mappingsType	= isset( $config[ 'mappingsType' ] ) ? $config[ 'mappingsType' ] : static::$parentType;

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );
		$modelTagService		= Yii::$app->factory->get( 'modelTagService' );

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
				$gallery->type		= $parentType;
				$gallery->status	= $galleryClass::STATUS_ACTIVE;
				$gallery->name		= empty( $gallery->name ) ? $model->name : $gallery->name;

				$gallery = $galleryService->create( $gallery );
			}
			else {

				$gallery = $galleryService->createByParams([
					'siteId' => $model->siteId,
					'type' => $parentType, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->title
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => $parentType,
				'publish' => $publish,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo,
				'gallery' => $gallery
			]);

			// Bind categories
			$modelCategoryService->bindModels( $model->id, $mappingsType, [ 'binder' => 'CategoryBinder' ] );

			// Bind tags
			$modelTagService->bindTags( $model->id, $mappingsType, [ 'binder' => 'TagBinder' ] );

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
		$mail	= isset( $config[ 'mail' ] ) ? $config[ 'mail' ] : true;
		$user	= isset( $config[ 'user' ] ) ? $config[ 'user' ] : Yii::$app->core->getUser();

		$modelClass = static::$modelClass;
		$parentType	= static::$parentType;

		$content		= isset( $config[ 'content' ] ) ? $config[ 'content' ] : new ModelContent();
		$publish		= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$banner			= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner		= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video			= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo			= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery		= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;
		$mappingsType	= isset( $config[ 'mappingsType' ] ) ? $config[ 'mappingsType' ] : static::$parentType;
		$adminLink		= isset( $config[ 'adminLink' ] ) ? $config[ 'adminLink' ] : 'cms/post/review';

		$galleryService			= Yii::$app->factory->get( 'galleryService' );
		$modelContentService	= Yii::$app->factory->get( 'modelContentService' );
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );
		$modelTagService		= Yii::$app->factory->get( 'modelTagService' );

		$galleryClass = $galleryService->getModelClass();

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
				$gallery->type		= $parentType;
				$gallery->status	= $galleryClass::STATUS_ACTIVE;
				$gallery->name		= empty( $gallery->name ) ? $model->name : $gallery->name;

				$gallery = $galleryService->create( $gallery );
			}
			else {

				$gallery = $galleryService->createByParams([
					'siteId' => $model->siteId,
					'type' => $parentType, 'status' => $galleryClass::STATUS_ACTIVE,
					'name' => $model->name, 'title' => $model->title
				]);
			}

			// Create and attach model content
			$modelContentService->create( $content, [
				'parent' => $model, 'parentType' => $parentType,
				'publish' => $publish,
				'banner' => $banner, 'mbanner' => $mbanner,
				'video' => $video, 'mvideo' => $mvideo,
				'gallery' => $gallery
			]);

			// Bind categories
			$modelCategoryService->bindModels( $model->id, $mappingsType, [ 'binder' => 'CategoryBinder' ] );

			// Bind tags
			$modelTagService->bindTags( $model->id, $mappingsType, [ 'binder' => 'TagBinder' ] );

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
					'template' => CmsGlobal::TPL_NOTIFY_POST_NEW,
					'adminLink' => "{$adminLink}?id={$model->id}"
				]);
			}

			// Email Post Admin
			if( $mail ) {

				Yii::$app->cmsMailer->sendRegisterPostMail( $model );
			}
		}

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$admin = isset( $config[ 'admin' ] ) ? $config[ 'admin' ] : false;

		$content		= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;
		$publish		= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : false;
		$avatar			= isset( $config[ 'avatar' ] ) ? $config[ 'avatar' ] : null;
		$banner			= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$mbanner		= isset( $config[ 'mbanner' ] ) ? $config[ 'mbanner' ] : null;
		$video			= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;
		$mvideo			= isset( $config[ 'mvideo' ] ) ? $config[ 'mvideo' ] : null;
		$gallery		= isset( $config[ 'gallery' ] ) ? $config[ 'gallery' ] : null;
		$mappingsType	= isset( $config[ 'mappingsType' ] ) ? $config[ 'mappingsType' ] : static::$parentType;

		$attributes	= isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'parentId', 'avatarId', 'name', 'slug', 'icon', 'texture',
			'title', 'description', 'visibility', 'content'
		];

		if( $admin ) {

			$attributes	= ArrayHelper::merge( $attributes, [
				'status', 'order', 'pinned', 'featured', 'popular', 'comments'
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
		$modelCategoryService	= Yii::$app->factory->get( 'modelCategoryService' );
		$modelTagService		= Yii::$app->factory->get( 'modelTagService' );

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

		// Bind categories
		$modelCategoryService->bindModels( $model->id, $mappingsType, [ 'binder' => 'CategoryBinder' ] );

		// Bind tags
		$modelTagService->bindTags( $model->id, $mappingsType, [ 'binder' => 'TagBinder' ] );

		// Model Checks
		$oldStatus = $model->getOldAttribute( 'status' );

		$model = parent::update( $model, [
			'attributes' => $attributes
		]);

		// Check status change and notify User
		if( isset( $model->userId ) && $oldStatus != $model->status ) {

			$config[ 'users' ] = [ $model->userId ];

			$config[ 'data' ][ 'message' ] = 'Post status changed.';

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

				// Delete Meta
				$this->metaService->deleteByModelId( $model->id );

				// Delete files
				$this->fileService->deleteMultiple( ArrayHelper::merge( $model->files, [ $model->avatar ] ) );

				// Delete File Mappings of Shared Files
				Yii::$app->factory->get( 'modelFileService' )->deleteMultiple( $model->modelFiles );

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
