<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class MenuService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findById( $id ) {

		return ObjectData::findById( $id );
	}

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findByName( $name ) {

		return ObjectData::findByNameType( $name, CmsGlobal::TYPE_MENU );
	}

	/**
	 * @return array - of all menu ids
	 */
	public static function getIdList() {

		return self::findList( 'id', CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_MENU ] ] );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( 'id', 'name', CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_MENU ] ] );
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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_MENU;

		return self::getDataProvider( new ObjectData(), $config );
	}

	// Create -----------

	/**
	 * @param ObjectData $menu
	 * @return ObjectData
	 */
	public static function create( $menu ) {

		$menu->save();

		return $menu;
	}

	// Update -----------

	/**
	 * @param ObjectData $menu
	 * @return ObjectData
	 */
	public static function update( $menu ) {

		$menuToUpdate	= self::findById( $menu->id );

		$menuToUpdate->copyForUpdateFrom( $menu, [ 'name', 'description', 'data' ] );

		$menuToUpdate->update();

		return $menuToUpdate;
	}

	/**
	 * @param Binder $binder
	 * @return boolean
	 */
	public static function bindPages( $binder ) {

		$menuId		= $binder->binderId;
		$pages		= $binder->bindedData;
		$menu		= self::findById( $menuId );
		$objectData	= $menu->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->pages	= [];

		if( isset( $pages ) && count( $pages ) > 0 ) {

			foreach ( $pages as $key => $value ) {

				if( isset( $value ) ) {

					$objectData->pages[] = $value;
				}
			}
		}

		$menu->generateJsonFromObject( $objectData );

		$menu->update();

		return true;
	}

	// Delete -----------

	/**
	 * @param ObjectData $menu
	 * @return boolean
	 */
	public static function delete( $menu ) {

		$existingMenu	= self::findById( $menu->id );

		// Delete Menu
		$existingMenu->delete();

		return true;
	}
}

?>