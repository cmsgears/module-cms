<?php
namespace cmsgears\cms\common\services\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class SectionService extends \cmsgears\core\common\services\entities\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_SECTION );
	}

	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_SECTION );
	}

	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_SECTION );
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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_SECTION;

		return self::getDataProvider( new Widget(), $config );
	}
}

?>