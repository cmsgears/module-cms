<?php
namespace cmsgears\cms\common\services;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Template;

use cmsgears\core\common\services\Service;

class TemplateService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Template::findById( $id );
	}

	public static function getIdNameMap() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE );
	}

	public static function getIdNameMapForPages() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE, [ 'type' => Template::TYPE_PAGE ] );
	}

	public static function getIdNameMapForWidgets() {

		return self::findMap( "id", "name", CmsTables::TABLE_TEMPLATE, [ 'type' => Template::TYPE_WIDGET ] );
	}
}

?>