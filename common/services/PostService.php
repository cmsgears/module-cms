<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\ModelCategory;
use cmsgears\cms\common\models\entities\Post;

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

		if( !isset( $post->order ) || strlen( $post->order ) <= 0 ) {

			$post->order = 0;
		}

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

		if( !isset( $postToUpdate->order ) || strlen( $postToUpdate->order ) <= 0 ) {

			$postToUpdate->order = 0;
		}

		$postToUpdate->update();

		return $postToUpdate;
	}

	// Delete -----------

	/**
	 * @param Post $post
	 * @return boolean
	 */
	public static function delete( $post ) {

		$existingPost	= self::findById( $post->id );

		// Delete Post
		$existingPost->delete();

		return true;
	}
}

?>