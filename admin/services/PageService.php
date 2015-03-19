<?php
namespace cmsgears\modules\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\core\common\models\entities\CmgFile;
use cmsgears\modules\cms\common\models\entities\Page;
use cmsgears\modules\cms\common\models\entities\MenuPage;

use cmsgears\modules\core\admin\services\FileService;

use cmsgears\modules\core\common\utilities\CodeGenUtil;
use cmsgears\modules\core\common\utilities\DateUtil;

class PageService extends \cmsgears\modules\cms\common\services\PageService {

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

		return self::getPaginationDetails( new Page(), [ 'conditions' => [ 'page_type' => Page::TYPE_PAGE ], 'sort' => $sort, 'search-col' => 'page_name' ] );
	}

	// Create -----------

	public static function create( $page, $banner ) {
		
		// Create Page		
		$date 		= DateUtil::getMysqlDate();
		$user		= Yii::$app->user->getIdentity();

		$page->setCreatedOn( $date );
		$page->setType( Page::TYPE_PAGE );
		$page->setStatus( Page::STATUS_NEW );
		$page->setVisibility( Page::VISIBILITY_PRIVATE );
		$page->setAuthorId( $user->getId() );
		$page->setSlug( CodeGenUtil::generateSlug( $page->getName() ) );

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$page->setBannerId( $banner->getId() );
		}

		// commit page
		$page->save();

		return true;
	}

	// Update -----------

	public static function update( $page, $banner ) {

		$date 			= DateUtil::getMysqlDate();
		$user			= Yii::$app->user->getIdentity();
		$pageToUpdate	= self::findById( $page->getId() );

		$pageToUpdate->setName( $page->getName() );
		$pageToUpdate->setDesc( $page->getDesc() );
		$pageToUpdate->setTemplate( $page->getTemplate() );
		$pageToUpdate->setMetaTags( $page->getMetaTags() );
		$pageToUpdate->setSummary( $page->getSummary() );
		$pageToUpdate->setContent( $page->getContent() );
		$pageToUpdate->setUpdatedOn( $date );
		$pageToUpdate->setBannerId( $page->getBannerId() );
		$pageToUpdate->setVisibility( $page->getVisibility() );
		$pageToUpdate->setStatus( $page->getStatus() );
		$pageToUpdate->setSlug( CodeGenUtil::generateSlug( $page->getName() ) );

		$publishDate	= $pageToUpdate->getPublishedOn();

    	if( $pageToUpdate->isPublished() && !isset( $publishDate ) ) {

    		$pageToUpdate->setPublishedOn( $date );
    	}

		// Save Banner
		FileService::saveImage( $banner, $user, Yii::$app->fileManager );

		// New Banner
		$bannerId 	= $banner->getId();

		if( isset( $bannerId ) && intval( $bannerId ) > 0 ) {

			$pageToUpdate->setBannerId( $bannerId );
		}

		$pageToUpdate->update();

		return true;
	}

	public static function bindMenus( $binder ) {

		$pageId	= $binder->pageId;
		$menus	= $binder->bindedData;

		// Clear all existing mappings
		MenuPage::deleteByPage( $pageId );

		if( isset( $menus ) && count( $menus ) > 0 ) {

			foreach ( $menus as $key => $value ) {

				if( isset( $value ) ) {

					$toSave				= new MenuPage();

					$toSave->setPageId( $pageId );
					$toSave->setMenuId( $value );

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $page ) {

		$pageId			= $page->getId();
		$existingPage	= self::findById( $pageId );

		// Delete Page
		$existingPage->delete();

		return true;
	}
}

?>