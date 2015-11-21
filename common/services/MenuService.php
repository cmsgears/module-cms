<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\cms\common\models\forms\Link;

class MenuService extends \cmsgears\core\common\services\ObjectDataService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findByName( $name ) {

		return self::findByNameType( $name, CmsGlobal::TYPE_MENU );
	}

	/**
	 * @param integer $id
	 * @return ObjectData
	 */
	public static function findBySlug( $name ) {

		return self::findBySlugType( $name, CmsGlobal::TYPE_MENU );
	}

	/**
	 * @return array - of all menu ids
	 */
	public static function getIdList() {

		return self::getIdListByType( CmsGlobal::TYPE_MENU );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::getIdNameListByType( CmsGlobal::TYPE_MENU );
	}

	public static function getLinks( $menu ) {

		$objectData		= $menu->generateObjectFromJson();
		$links			= $objectData->links;
		$linkObjects	= [];

		foreach ( $links as $link ) {

			$linkObjects[]	= new Link( $link );
		}

		return $linkObjects;
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

	// Update -----------

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

				$objectData->pages[] = $value;
			}
		}

		$menu->generateJsonFromObject( $objectData );

		$menu->update();

		return true;
	}

	public static function updateLinks( $menu, $links ) {

		$menu		= self::findById( $menu->id );
		$objectData	= $menu->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->links	= [];

		if( isset( $links ) && count( $links ) > 0 ) {

			foreach ( $links as $link ) {

				if( isset( $link ) ) {

					$objectData->links[] = json_encode( $link );
				}
			}
		}

		$menu->generateJsonFromObject( $objectData );

		$menu->update();

		return true;
	}
}

?>