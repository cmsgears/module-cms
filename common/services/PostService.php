<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\core\common\models\entities\ModelCategory;
use cmsgears\cms\common\models\entities\Post;

use cmsgears\core\admin\services\FileService;

class PostService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Post
	 */
	public static function findById( $id ) {

		return Post::findById( $id );
	}

	/**
	 * @param string $slug
	 * @return Post
	 */
    public static function findBySlug( $slug ) {

		return Post::findBySlug( $slug );
    }

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Post(), $config );
	}

	// Create -----------

	/**
	 * @param Post $post
	 * @param CmgFile $banner
	 * @return Post
	 */
	public static function create( $post ) {

		$post->type = CmsGlobal::TYPE_POST;

		// Create Post
		$post->save();

		return $post;
	}

	// Update -----------

	/**
	 * @param Post $post
	 * @param CmgFile $banner
	 * @return Post
	 */
	public static function update( $post ) {

		$postToUpdate	= self::findById( $post->id );

		$postToUpdate->copyForUpdateFrom( $post, [ 'parentId', 'name', 'status', 'visibility', 'order', 'featured' ] );

		$postToUpdate->update();

		return $postToUpdate;
	}

	/**
	 * @param Binder $binder
	 * @return boolean
	 */
	public static function bindCategories( $binder ) {

		$postId			= $binder->binderId;
		$categories		= $binder->bindedData;

		// Clear all existing mappings
		ModelCategory::deleteByParentIdType( $postId, CmsGlobal::TYPE_POST );

		if( isset( $categories ) && count( $categories ) > 0 ) {

			foreach ( $categories as $key => $value ) {

				if( isset( $value ) && $value > 0 ) {

					$toSave		= new ModelCategory();

					$toSave->parentId	= $postId;
					$toSave->parentType	= CmsGlobal::TYPE_POST;
					$toSave->categoryId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	/**
	 * @param Post $post
	 * @return boolean
	 */
	public static function delete( $post ) {

		$existingPost		= self::findById( $post->id );

		// Delete Post
		$existingPost->delete();

		return true;
	}
}

?>