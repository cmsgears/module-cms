<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\MenuPage;

use cmsgears\core\common\services\FileService;

use cmsgears\core\common\utilities\DateUtil;

class PageService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------
	
	/**
	 * @param integer $id
	 * @return Page
	 */
	public static function findById( $id ) {

		return Page::findById( $id );
	}

	/**
	 * @param string $slug
	 * @return Page
	 */
    public static function findBySlug( $slug ) {

		return Page::findBySlug( $slug );
    }

	/**
	 * @return array - of all page ids
	 */
	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_PAGE );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_PAGE );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Page(), $config );
	}

	// Create -----------
	
	/**
	 * @param Page $page
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function create( $page, $banner = null ) {

		$user				= Yii::$app->user->getIdentity();

		$page->type 		= Page::TYPE_PAGE;
		$page->status 		= Page::STATUS_NEW;
		$page->visibility 	= Page::VISIBILITY_PRIVATE;
		$page->createdBy	= $user->id;

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $page, 'attribute' => 'bannerId' ] );
		}

		// Create Page
		$page->save();

		return $page;
	}

	// Update -----------

	/**
	 * @param Page $page
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function update( $page, $banner = null ) {

		$date 			= DateUtil::getDateTime();
		$user			= Yii::$app->user->getIdentity();
		$pageToUpdate	= self::findById( $page->id );

		$pageToUpdate->copyForUpdateFrom( $page, [ 'parentId', 'bannerId', 'templateId', 'name', 'status', 'visibility', 'summary', 'content', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ] );

    	if( $pageToUpdate->isPublished() && !isset( $pageToUpdate->publishedAt ) ) {

    		$pageToUpdate->publishedAt	= $date;
    	}

		$pageToUpdate->modifiedBy	= $user->id;

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $pageToUpdate, 'attribute' => 'bannerId' ] );
		}

		$pageToUpdate->update();

		return $pageToUpdate;
	}
	
	/**
	 * @param Binder $binder
	 * @return boolean
	 */
	public static function bindMenus( $binder ) {

		$pageId	= $binder->binderId;
		$menus	= $binder->bindedData;

		// Clear all existing mappings
		MenuPage::deleteByPageId( $pageId );

		if( isset( $menus ) && count( $menus ) > 0 ) {

			foreach ( $menus as $key => $value ) {

				if( isset( $value ) && $value > 0 ) {

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

	/**
	 * @param Page $page
	 * @return boolean
	 */
	public static function delete( $page ) {

		$existingPage	= self::findById( $page->id );

		// Delete Page
		$existingPage->delete();

		return true;
	}
}

?>