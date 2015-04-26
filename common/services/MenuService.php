<?php
namespace cmsgears\cms\common\services;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Menu;

use cmsgears\core\common\services\Service;

class MenuService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Menu::findOne( $id );
	}

	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_MENU );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_MENU );
	}
}

?>