<?php
namespace cmsgears\modules\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\core\common\models\entities\CmgFile;
use cmsgears\modules\cms\common\models\entities\Page;
use cmsgears\modules\cms\common\models\entities\Post;
use cmsgears\modules\cms\common\models\entities\PostCategory;

use cmsgears\modules\core\admin\services\FileService;

use cmsgears\modules\core\common\utilities\CodeGenUtil;
use cmsgears\modules\core\common\utilities\DateUtil;

class PostService extends \cmsgears\modules\cms\common\services\PostService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'page_name' => SORT_ASC ],
	                'desc' => ['page_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'slug' => [
	                'asc' => [ 'page_slug' => SORT_ASC ],
	                'desc' => ['page_slug' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ],
	            'visibility' => [
	                'asc' => [ 'page_visibility' => SORT_ASC ],
	                'desc' => ['page_visibility' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'visibility',
	            ],
	            'status' => [
	                'asc' => [ 'page_status' => SORT_ASC ],
	                'desc' => ['page_status' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'status',
	            ],
	            'template' => [
	                'asc' => [ 'page_template' => SORT_ASC ],
	                'desc' => ['page_template' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'template',
	            ],
	            'cdate' => [
	                'asc' => [ 'page_created_on' => SORT_ASC ],
	                'desc' => ['page_created_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'cdate',
	            ],
	            'pdate' => [
	                'asc' => [ 'page_published_on' => SORT_ASC ],
	                'desc' => ['page_published_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'pdate',
	            ],
	            'udate' => [
	                'asc' => [ 'page_updated_on' => SORT_ASC ],
	                'desc' => ['page_updated_on' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'udate',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Post(), [ 'conditions' => [ 'page_type' => Page::TYPE_POST ], 'sort' => $sort, 'search-col' => 'page_name' ] );
	}

	// Create -----------

	public static function create( $post, $banner ) {

		// Create Post		
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		$post->setCreatedOn( $date );
		$post->setType( Page::TYPE_POST );
		$post->setStatus( Page::STATUS_NEW );
		$post->setVisibility( Page::VISIBILITY_PRIVATE );
		$post->setAuthorId( $user->getId() );
		$post->setSlug( CodeGenUtil::generateSlug( $post->getName() ) );

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$post->setBannerId( $banner->getId() );
		}

		$post->save();

		return true;
	}

	// Update -----------

	public static function update( $post, $banner ) {
		
		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$postToUpdate	= self::findById( $post->getId() );
		
		$postToUpdate->setName( $post->getName() );
		$postToUpdate->setDesc( $post->getDesc() );
		$postToUpdate->setTemplate( $post->getTemplate() );
		$postToUpdate->setMetaTags( $post->getMetaTags() );
		$postToUpdate->setSummary( $post->getSummary() );
		$postToUpdate->setContent( $post->getContent() );
		$postToUpdate->setUpdatedOn( $date );
		$postToUpdate->setBannerId( $post->getBannerId() );
		$postToUpdate->setVisibility( $post->getVisibility() );
		$postToUpdate->setStatus( $post->getStatus() );
		$postToUpdate->setSlug( CodeGenUtil::generateSlug( $post->getName() ) );

		$publishDate	= $postToUpdate->getPublishedOn();

    	if( $postToUpdate->isPublished() && !isset( $publishDate ) ) {

    		$postToUpdate->setPublishedOn( $date );
    	}

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$postToUpdate->setBannerId( $banner->getId() );
		}

		$postToUpdate->update();

		return true;
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

					$toSave->setPostId( $postId );
					$toSave->setCategoryId( $value );

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $post ) {

		// Delete Page
		$post->delete();

		return true;
	}
}

?>