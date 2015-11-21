<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Page;
use cmsgears\cms\common\models\entities\MenuPage;

use cmsgears\core\common\services\FileService;

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

    public static function getMenuPages( $pages ) {

		return Page::find()->andFilterWhere( [ 'in', 'id', $pages ] )->all();
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
	public static function create( $page ) {

		$page->type 		= CmsGlobal::TYPE_PAGE;
		$page->status 		= Page::STATUS_NEW;
		$page->visibility 	= Page::VISIBILITY_PRIVATE;

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
	public static function update( $page ) {

		$pageToUpdate	= self::findById( $page->id );

		$pageToUpdate->copyForUpdateFrom( $page, [ 'parentId', 'name', 'status', 'visibility', 'order', 'featured' ] );

		$pageToUpdate->update();

		return $pageToUpdate;
	}

	// Delete -----------

	/**
	 * @param Page $page
	 * @return boolean
	 */
	public static function delete( $page ) {

		$existingPage		= self::findById( $page->id );

		// Delete Page
		$existingPage->delete();

		return true;
	}
}

?>