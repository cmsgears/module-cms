<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Sidebar;
use cmsgears\cms\common\models\entities\SidebarWidget;

class SidebarService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Sidebar
	 */
	public static function findById( $id ) {

		return Sidebar::findOne( $id );
	}

	/**
	 * @return array - of all sidebar ids
	 */
	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_SIDEBAR );
	}

	/**
	 * @return array - having page id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_SIDEBAR );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Sidebar(), $config );
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

		$sidebarToUpdate->copyForUpdateFrom( $sidebar, [ 'name', 'description' ] );

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

		// Clear all existing mappings
		SidebarWidget::deleteBySidebarId( $sidebarId );

		if( isset( $widgets ) && count( $widgets ) > 0 ) {

			foreach ( $widgets as $key => $value ) {

				if( isset( $value ) ) {

					$toSave	= new SidebarWidget();

					$toSave->sidebarId	= $sidebarId;
					$toSave->widgetId	= $value;
	
					$toSave->save();
				}
			}
		}

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