<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\MenuPage;
use cmsgears\cms\common\models\entities\ModelContent;

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
	public static function create( $page, $content, $banner = null ) {

		$user					= Yii::$app->user->getIdentity();

		$page->type 			= CmsGlobal::TYPE_PAGE;
		$page->status 			= Page::STATUS_NEW;
		$page->visibility 		= Page::VISIBILITY_PRIVATE;
		$page->createdBy		= $user->id;

		// Create Page
		$page->save();

		$content->parentId		= $page->id;
		$content->parentType	= CmsGlobal::TYPE_PAGE;

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $content, 'attribute' => 'bannerId' ] );
		}
		
		// Create Content
		$content->save();

		return $page;
	}

	// Update -----------

	/**
	 * @param Page $page
	 * @param CmgFile $banner
	 * @return Page
	 */
	public static function update( $page, $content, $banner = null ) {

		$date 				= DateUtil::getDateTime();
		$user				= Yii::$app->user->getIdentity();
		$pageToUpdate		= self::findById( $page->id );
		$contentToUpdate	= ModelContent::findById( $content->id );

		$pageToUpdate->copyForUpdateFrom( $page, [ 'parentId', 'name', 'status', 'visibility' ] );

		$pageToUpdate->modifiedBy	= $user->id;

		$contentToUpdate->copyForUpdateFrom( $content, [ 'bannerId', 'templateId', 'summary', 'content', 'seoName', 'seoDescription', 'seoKeywords', 'seoRobot' ] );

    	if( $pageToUpdate->isPublished() && !isset( $contentToUpdate->publishedAt ) ) {

    		$contentToUpdate->publishedAt	= $date;
    	}

		// Save Banner
		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $contentToUpdate, 'attribute' => 'bannerId' ] );
		}

		$pageToUpdate->update();

		$contentToUpdate->update();

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
	public static function delete( $page, $content ) {

		$existingPage		= self::findById( $page->id );
		$existingContent	= ModelContent::findById( $content->id );

		// Delete Page
		$existingPage->delete();

		// Delete Content
		$existingContent->delete();

		return true;
	}
}

?>