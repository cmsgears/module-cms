<?php
namespace cmsgears\modules\cms\common\services;

// Yii Imports
use \Yii;

use cmsgears\modules\cms\common\models\entities\Menu;

use cmsgears\modules\core\common\services\Service;

class MenuService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Menu::findOne( $id );
	}

	public static function getIdList() {

		$menusList	= array();

		// Execute the command
		$menus 		= Menu::find()->all();

		foreach ( $menus as $menu ) {
			
			array_push( $menusList, $menu->getId() );
		}

		return $menusList;
	}

	public static function getIdNameMap() {

		$menusMap 		= array();

		// Execute the command
		$menus 		= Menu::find()->all();

		foreach ( $menus as $menu ) {

			$menusMap[] = [ "id" => $menu->getId(), "name" => $menu->getName() ];
		}

		return $menusMap;
	}
}

?>