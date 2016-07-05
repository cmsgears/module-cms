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

use cmsgears\cms\common\services\interfaces\entities\ISidebarService;

class SidebarService extends \cmsgears\core\common\services\entities\ObjectDataService implements ISidebarService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $parentType	= CmsGlobal::TYPE_SIDEBAR;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// SidebarService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_SIDEBAR;

		return parent::getPage( $config );
	}

	// Read ---------------

    // Read - Models ---

	public function getByName( $name, $first = false ) {

		return $this->getByNameType( $name, CmsGlobal::TYPE_SIDEBAR );
	}

	public function getWidgets( $sidebar, $associative = false ) {

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

	public function getWidgetsForUpdate( $sidebar, $widgets ) {

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

    // Read - Lists ----

	public function getIdList( $config = [] ) {

		return $this->getIdListByType( CmsGlobal::TYPE_SIDEBAR, $config );
	}

	public function getIdNameList( $config = [] ) {

		return $this->getIdNameListByType( CmsGlobal::TYPE_SIDEBAR, $config );
	}

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	/**
	 * @param array $widgets
	 * @return boolean
	 */
	public function updateWidgets( $sidebar, $widgets ) {

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

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// SidebarService ------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}

?>