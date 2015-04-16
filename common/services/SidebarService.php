<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Sidebar;

use cmsgears\modules\core\common\services\Service;

class SidebarService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Sidebar::findOne( $id );
	}

	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_SIDEBAR );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_SIDEBAR );
	}
}

?>