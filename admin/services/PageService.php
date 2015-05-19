<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\models\entities\CmgFile;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\MenuPage;

use cmsgears\core\admin\services\FileService;

use cmsgears\core\common\utilities\CodeGenUtil;
use cmsgears\core\common\utilities\DateUtil;

class PageService extends \cmsgears\cms\common\services\PageService {

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

		return self::getPaginationDetails( new Page(), [ 'conditions' => [ 'type' => Page::TYPE_PAGE ], 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $page, $banner ) {
		
		// Create Page		
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		$page->createdAt	= $date;
		$page->type 		= Page::TYPE_PAGE;
		$page->status 		= Page::STATUS_NEW;
		$page->visibility 	= Page::VISIBILITY_PRIVATE;
		$page->authorId		= $user->id;
		$page->slug			= CodeGenUtil::generateSlug( $page->name );

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $page, 'attribute' => 'bannerId' ] );

		// commit page
		$page->save();

		return $page;
	}

	// Update -----------

	public static function update( $page, $banner ) {

		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$pageToUpdate	= self::findById( $page->id );

		$pageToUpdate->copyForUpdateFrom( $page, [ 'name', 'description', 'keywords', 'templateId', 'summary', 'content', 'bannerId', 'visibility', 'status' ] );

		$pageToUpdate->updatedAt	= $date;
		$pageToUpdate->slug			= CodeGenUtil::generateSlug( $page->name );
		$publishDate				= $pageToUpdate->publishedAt;

    	if( $pageToUpdate->isPublished() && !isset( $publishDate ) ) {

    		$pageToUpdate->publishedAt	= $date;
    	}

		// Save Banner
		FileService::saveImage( $banner, $user, [ 'model' => $pageToUpdate, 'attribute' => 'bannerId' ] );

		$pageToUpdate->update();

		return $pageToUpdate;
	}

	public static function bindMenus( $binder ) {

		$pageId	= $binder->pageId;
		$menus	= $binder->bindedData;

		// Clear all existing mappings
		MenuPage::deleteByPageId( $pageId );

		if( isset( $menus ) && count( $menus ) > 0 ) {

			foreach ( $menus as $key => $value ) {

				if( isset( $value ) ) {

					$toSave			= new MenuPage();

					$toSave->pageId	= $pageId;
					$toSave->menuId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $page ) {

		$existingPage	= self::findById( $page->id );

		// Delete Page
		$existingPage->delete();

		return true;
	}
}

?>