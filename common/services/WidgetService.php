<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class WidgetService extends \cmsgears\core\common\services\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_WIDGET );
	}

	public static function findBySlug( $slug ) {

		return self::findBySlugType( $slug, CmsGlobal::TYPE_WIDGET );
	}

	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_WIDGET );
	}

	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_WIDGET );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		if( !isset( $config[ 'conditions' ] ) ) {

			$config[ 'conditions' ]	= [];
		}

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_WIDGET;

		return self::getDataProvider( new Widget(), $config );
	}
}

?>