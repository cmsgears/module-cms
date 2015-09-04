<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Menu;
use cmsgears\cms\common\models\entities\MenuPage;

class MenuService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Menu
	 */
	public static function findById( $id ) {

		return Menu::findById( $id );
	}

	/**
	 * @param string $name
	 * @return Menu
	 */
	public static function findByName( $name ) {

		return Menu::findByName( $name );
	}

	/**
	 * @return array - of all menu ids
	 */
	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_MENU );
	}

	/**
	 * @return array - having menu id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_MENU );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Menu(), $config );
	}

	// Create -----------
	
	/**
	 * @param Menu $menu
	 * @return Menu
	 */
	public static function create( $menu ) {

		$menu->save();

		return $menu;
	}

	// Update -----------

	/**
	 * @param Menu $menu
	 * @return Menu
	 */
	public static function update( $menu ) {
		
		$menuToUpdate	= self::findById( $menu->id );
		
		$menuToUpdate->copyForUpdateFrom( $menu, [ 'name', 'description' ] );

		$menuToUpdate->update();

		return $menuToUpdate;
	}

	/**
	 * @param Binder $binder
	 * @return boolean
	 */
	public static function bindPages( $binder ) {

		$menuId	= $binder->binderId;
		$pages	= $binder->bindedData;

		// Clear all existing mappings
		MenuPage::deleteByMenuId( $menuId );

		if( isset( $pages ) && count( $pages ) > 0 ) {

			foreach ( $pages as $key => $value ) {

				if( isset( $value ) ) {

					$toSave	= new MenuPage();

					$toSave->menuId	= $menuId;
					$toSave->pageId = $value;
	
					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	/**
	 * @param Menu $menu
	 * @return boolean
	 */
	public static function delete( $menu ) {

		$existingMenu	= self::findById( $menu->id );

		// Delete Menu
		$existingMenu->delete();

		return true;
	}
}

?>