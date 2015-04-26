<?php
namespace cmsgears\cms\common\services;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Page;

use cmsgears\core\common\services\Service;

class PageService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Page::findOne( $id );
	}

    public static function findBySlug( $slug ) {

		return Page::findBySlug( $slug );
    }

	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_PAGE );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_PAGE );
	}
}

?>