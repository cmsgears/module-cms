<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class ElementService extends \cmsgears\core\common\services\entities\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_ELEMENT );
	}

	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_ELEMENT );
	}

	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_ELEMENT );
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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_ELEMENT;

		return self::getDataProvider( new ObjectData(), $config );
	}
}

?>