<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class SidebarService extends \cmsgears\core\common\services\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_SIDEBAR );
	}

	/**
	 * @return array - of all sidebar ids
	 */
	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_SIDEBAR );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_SIDEBAR );
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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_SIDEBAR;

		return self::getDataProvider( new ObjectData(), $config );
	}

	// Update -----------

	/**
	 * @param Binder $binder
	 * @return boolean
	 */
	public static function bindWidgets( $binder ) {

		$sidebarId	= $binder->binderId;
		$widgets	= $binder->bindedData;
		$sidebar	= self::findById( $sidebarId );
		$objectData	= $sidebar->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->widgets	= [];

		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $key => $value ) {

				if( isset( $value ) ) {

					$objectData->widgets[] = $value;
				}
			}
		}

		$sidebar->generateJsonFromObject( $objectData );

		$sidebar->update();

		return true;
	}
}

?>