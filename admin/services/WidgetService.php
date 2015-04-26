<?php
namespace cmsgears\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\models\entities\Widget;
use cmsgears\cms\common\models\entities\SidebarWidget;

class WidgetService extends \cmsgears\cms\common\services\WidgetService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'name' => SORT_ASC ],
	                'desc' => ['name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Widget(), [ 'sort' => $sort, 'search-col' => 'name' ] );
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

		$widgetId	= $binder->widgetId;
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