<?php
namespace cmsgears\modules\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

use cmsgears\modules\cms\common\models\entities\Menu;
use cmsgears\modules\cms\common\models\entities\MenuPage;

class MenuService extends \cmsgears\modules\cms\common\services\MenuService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'menu_name' => SORT_ASC ],
	                'desc' => ['menu_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Menu(), [ 'sort' => $sort, 'search-col' => 'menu_name' ] );
	}

	// Create -----------

	public static function create( $menu ) {

		$menu->save();

		return true;
	}

	// Update -----------

	public static function update( $menu ) {
		
		$menuToUpdate	= self::findById( $menu->getId() );
		
		$menuToUpdate->setName( $menu->getName() );
		$menuToUpdate->setDesc( $menu->getDesc() );

		$menuToUpdate->update();

		return true;
	}

	public static function bindPages( $binder ) {

		$menuId	= $binder->menuId;
		$pages	= $binder->bindedData;
		
		// Clear all existing mappings
		MenuPage::deleteByMenu( $menuId );

		if( isset( $pages ) && count( $pages ) > 0 ) {

			foreach ( $pages as $key => $value ) {
				
				if( isset( $value ) ) {

					$toSave	= new MenuPage();
	
					$toSave->setMenuId( $menuId );
					$toSave->setPageId( $value );
	
					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $menu ) {

		$menuId			= $menu->getId();
		$existingMenu	= self::findById( $menuId );

		// Delete Menu
		$existingMenu->delete();

		return true;
	}
}

?>