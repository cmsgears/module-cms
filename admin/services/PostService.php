<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\Post;
use cmsgears\cms\common\models\entities\PostCategory;

use cmsgears\core\admin\services\FileService;

use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil;

class PostService extends \cmsgears\cms\common\services\PostService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'slug' => [
	                'asc' => [ 'slug' => SORT_ASC ],
	                'desc' => ['slug' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'visibility' => [
	                'asc' => [ 'visibility' => SORT_ASC ],
	                'desc' => ['visibility' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'visibility',
	            ],
	            'status' => [
	                'asc' => [ 'status' => SORT_ASC ],
	                'desc' => ['status' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'status',
	            ],
	            'template' => [
	                'asc' => [ 'template' => SORT_ASC ],
	                'desc' => ['template' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'template',
	            ],
	            'cdate' => [
	                'asc' => [ 'createdAt' => SORT_ASC ],
	                'desc' => ['createdAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'pdate' => [
	                'asc' => [ 'publishedAt' => SORT_ASC ],
	                'desc' => ['publishedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'pdate',
	            ],
	            'udate' => [
	                'asc' => [ 'updatedAt' => SORT_ASC ],
	                'desc' => ['updatedAt' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Post(), [ 'conditions' => [ 'type' => Page::TYPE_POST ], 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $post, $banner ) {

		// Create Post
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		$post->createdAt	= $date;
		$post->type 		= Page::TYPE_POST;
		$post->status 		= Page::STATUS_NEW;
		$post->visibility 	= Page::VISIBILITY_PRIVATE;
		$post->authorId		= $user->id;
		$post->slug			= CodeGenUtil::generateSlug( $post->name );

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $post, 'attribute' => 'bannerId' ] );

		$post->save();

		return $post;
	}

	// Update -----------

	public static function update( $post, $banner ) {

		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$postToUpdate	= self::findById( $post->id );
		
		$postToUpdate->copyForUpdateFrom( $post, [ 'name', 'description', 'templateId', 'summary', 'content', 'bannerId', 'visibility', 'status' ] );

		$postToUpdate->updatedAt	= $date;
		$postToUpdate->slug			= CodeGenUtil::generateSlug( $post->name );
		$publishDate				= $postToUpdate->publishedAt;

    	if( $postToUpdate->isPublished() && !isset( $publishDate ) ) {

    		$postToUpdate->publishedAt	= $date;
    	}

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $postToUpdate, 'attribute' => 'bannerId' ] );

		$postToUpdate->update();

		return $postToUpdate;
	}

	public static function bindCategories( $binder ) {

		$postId			= $binder->pageId;
		$categories		= $binder->bindedData;

		// Clear all existing mappings
		PostCategory::deleteByPostId( $postId );

		if( isset( $categories ) && count( $categories ) > 0 ) {

			foreach ( $categories as $key => $value ) {

				if( isset( $value ) ) {

					$toSave		= new PostCategory();

					$toSave->postId		= $postId;
					$toSave->categoryId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $post ) {
		
		$existingPost	= self::findById( $post->id );

		// Delete Page
		$existingPost->delete();

		return true;
	}
}

?>