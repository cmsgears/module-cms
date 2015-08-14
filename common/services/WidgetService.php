<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Widget;
use cmsgears\cms\common\models\entities\SidebarWidget;

class WidgetService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Widget::findById( $id );
	}

	public static function findByName( $name ) {

		return Widget::findByName( $name );
	}

	public static function getIdList() {

		return self::findList( "id", CmsTables::TABLE_WIDGET );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CmsTables::TABLE_WIDGET );
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Widget(), $config );
	}

	// Create -----------

	public static function create( $widget ) {

		$widget->save();

		return $widget;
	}

	// Update -----------

	public static function update( $widget ) {

		$widgetToUpdate	= self::findById( $widget->id );
		
		$widgetToUpdate->copyForUpdateFrom( $widget, [ 'name', 'description', 'templateId', 'meta' ] );

		$widgetToUpdate->update();

		return $widgetToUpdate;
	}

	public static function updateMeta( $widget ) {

		$widgetToUpdate			= self::findById( $widget->id );
		$widgetToUpdate->meta 	= $widget->generateJsonFromMap();

		$widgetToUpdate->update();

		return $widgetToUpdate;
	}

	public static function bindSidebars( $binder ) {

		$widgetId	= $binder->binderId;
		$sidebars	= $binder->bindedData;

		// Clear all existing mappings
		SidebarWidget::deleteByWidgetId( $widgetId );

		if( isset( $sidebars ) && count( $sidebars ) > 0 ) {

			foreach ( $sidebars as $key => $value ) {

				if( isset( $value ) ) {

					$toSave	= new SidebarWidget();

					$toSave->widgetId	= $widgetId;
					$toSave->sidebarId	= $value;

					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $widget ) {

		$existingWidget	= self::findById( $widget->id );

		// Delete Widget
		$existingWidget->delete();

		return true;
	}
}

?>