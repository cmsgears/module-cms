<?php
namespace cmsgears\cms\common\services\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\SidebarWidget;
use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

use cmsgears\core\common\utilities\SortUtil;

class SidebarService extends \cmsgears\core\common\services\entities\ObjectDataService {

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

	public static function getWidgets( $sidebar, $associative = false ) {

		$objectData		= $sidebar->generateObjectFromJson();
		$widgets		= $objectData->widgets;
		$widgetObjects	= [];
		$sidebarWidgets	= [];

		foreach ( $widgets as $widget ) {

			$sidebarWidget		= new SidebarWidget( $widget );
			$widgetObjects[]	= $sidebarWidget;

			if( $associative ) {

				$sidebarWidgets[ $sidebarWidget->widgetId ]	= $sidebarWidget;
			}
		}

		if( $associative ) {

			return $sidebarWidgets;
		}

		return $widgetObjects;
	}

	public static function getWidgetsForUpdate( $sidebar, $widgets ) {

		$sidebarWidgets	= self::getWidgets( $sidebar, true );
		$keys			= array_keys( $sidebarWidgets );
		$widgetObjects	= [];

		foreach ( $widgets as $widget ) {

			if( in_array( $widget[ 'id' ], $keys ) ) {

				$sidebarWidget			= $sidebarWidgets[ $widget[ 'id' ] ];
				$sidebarWidget->name	= $widget[ 'name' ];
				$widgetObjects[]		= $sidebarWidget;
			}
			else {

				$sidebarWidget				= new SidebarWidget();
				$sidebarWidget->widgetId	= $widget[ 'id' ];
				$sidebarWidget->name		= $widget[ 'name' ];
				$widgetObjects[]			= $sidebarWidget;
			}
		}

		return $widgetObjects;
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
	 * @param array $widgets
	 * @return boolean
	 */
	public static function updateWidgets( $sidebar, $widgets ) {

		$sidebar	= self::findById( $sidebar->id );
		$objectData	= $sidebar->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->widgets	= [];

		// Add Widgets
		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $widget ) {

				if( isset( $widget->widget ) && $widget->widget ) {

					if( !isset( $widget->order ) || strlen( $widget->order ) == 0 ) {

						$widget->order	= 0;
					}

					$objectData->widgets[] 	= $widget;
				}
			}
		}

		$objectData->widgets	= SortUtil::sortObjectArrayByNumber( $objectData->widgets, 'order', true );

		$sidebar->generateJsonFromObject( $objectData );

		$sidebar->update();

		return true;
	}
}

?>