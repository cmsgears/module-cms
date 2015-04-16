<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

use cmsgears\cms\common\models\entities\Menu;
use cmsgears\cms\common\models\entities\MenuPage;

class MenuService extends \cmsgears\cms\common\services\MenuService {

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
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Menu(), [ 'sort' => $sort, 'search-col' => 'name' ] );
	}

	// Create -----------

	public static function create( $menu ) {

		$menu->save();

		return $menu;
	}

	// Update -----------

	public static function update( $menu ) {
		
		$menuToUpdate	= self::findById( $menu->id );
		
		$menuToUpdate->copyForUpdateFrom( $widget, [ 'name', 'description' ] );

		$menuToUpdate->update();

		return $menuToUpdate;
	}

	public static function bindPages( $binder ) {

		$menuId	= $binder->menuId;
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

	public static function delete( $menu ) {

		$existingMenu	= self::findById( $menu->id );

		// Delete Menu
		$existingMenu->delete();

		return true;
	}
}

?>