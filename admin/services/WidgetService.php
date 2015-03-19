<?php
namespace cmsgears\modules\cms\admin\services;

// Yii Imports
use \Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Widget;
use cmsgears\modules\cms\common\models\entities\SidebarWidget;

class WidgetService extends \cmsgears\modules\cms\common\services\WidgetService {

	// Static Methods ----------------------------------------------

	// Pagination -------

	public static function getPagination() {

	    $sort = new Sort([
	        'attributes' => [
	            'name' => [
	                'asc' => [ 'widget_name' => SORT_ASC ],
	                'desc' => ['widget_name' => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'name',
	            ]
	        ]
	    ]);

		return self::getPaginationDetails( new Widget(), [ 'sort' => $sort, 'search-col' => 'widget_name' ] );
	}

	// Create -----------

	public static function create( $widget ) {

		$widget->save();

		return true;
	}

	// Update -----------

	public static function update( $widget ) {

		$widgetToUpdate	= self::findById( $widget->getId() );

		$widgetToUpdate->setName( $widget->getName() );
		$widgetToUpdate->setDesc( $widget->getDesc() );
		$widgetToUpdate->setTemplate( $widget->getTemplate() );
		$widgetToUpdate->setMeta( $widget->getMeta() );

		$widgetToUpdate->update();

		return true;
	}

	public static function updateMeta( $widget ) {

		$widgetToUpdate	= self::findById( $widget->getId() );

		$meta 			= $widget->getMetaMap();
		$meta			= json_encode( $meta );
		$meta			= '{ "metaMap":' . $meta . '}';
		
		$widgetToUpdate->setMeta( $meta );

		$widgetToUpdate->update();

		return true;
	}

	public static function bindSidebars( $binder ) {

		$widgetId	= $binder->widgetId;
		$sidebars	= $binder->bindedData;
	
		// Clear all existing mappings
		SidebarWidget::deleteByWidget( $widgetId );

		if( isset( $sidebars ) && count( $sidebars ) > 0 ) {

			foreach ( $sidebars as $key => $value ) {
				
				if( isset( $value ) ) {

					$toSave	= new SidebarWidget();
	
					$toSave->setWidgetId( $widgetId );
					$toSave->setSidebarId( $value );
	
					$toSave->save();
				}
			}
		}

		return true;
	}

	// Delete -----------

	public static function delete( $widget ) {

		$widgetId		= $widget->getId();
		$existingWidget	= self::findById( $widgetId );

		// Delete Widget
		$existingWidget->delete();

		return true;
	}
}

?>