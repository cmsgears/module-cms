<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class SidebarService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Sidebar
	 */
	public static function findById( $id ) {

		return ObjectData::findOne( $id );
	}

	/**
	 * @return array - of all sidebar ids
	 */
	public static function getIdList() {

		return self::findList( "id", CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_SIDEBAR ] ] );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_SIDEBAR ] ] );
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

	// Create -----------

	/**
	 * @param Sidebar $sidebar
	 * @return Sidebar
	 */
	public static function create( $sidebar ) {

		$sidebar->save();

		return $sidebar;
	}

	// Update -----------

	/**
	 * @param Sidebar $sidebar
	 * @return Sidebar
	 */
	public static function update( $sidebar ) {

		$sidebarToUpdate	= self::findById( $sidebar->id );

		$sidebarToUpdate->copyForUpdateFrom( $sidebar, [ 'name', 'description', 'data' ] );

		$sidebarToUpdate->update();

		return $sidebarToUpdate;
	}

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

	// Delete -----------

	/**
	 * @param Sidebar $sidebar
	 * @return boolean
	 */
	public static function delete( $sidebar ) {

		$existingSidebar	= self::findById( $sidebar->id );

		// Delete Sidebar
		$existingSidebar->delete();

		return true;
	}
}

?>