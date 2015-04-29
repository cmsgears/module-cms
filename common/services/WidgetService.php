<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Widget;

use cmsgears\core\common\services\Service;

class WidgetService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Widget::findById( $id );
	}

	public static function findByName( $name ) {

		return Widget::findByName( $name );
	}

	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_WIDGET );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_WIDGET );
	}
}

?>