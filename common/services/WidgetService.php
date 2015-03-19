<?php
namespace cmsgears\modules\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\modules\cms\common\models\entities\Widget;

use cmsgears\modules\core\common\services\Service;

class WidgetService extends Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return Widget::findById( $id );
	}

	public static function findByName( $name ) {

		return Widget::findByName( $name );
	}

	public static function getIdList() {

		$widgetsList	= array();

		// Execute the command
		$widgets 		= Widget::find()->all();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->getId() );
		}

		return $widgetsList;
	}

	public static function getIdNameMap() {

		$widgetsMap 	= array();

		// Execute the command
		$widgets 		= Widget::find()->all();

		foreach ( $widgets as $widget ) {

			$widgetsMap[] = [ "id" => $widget->getId(), "name" => $widget->getName() ];
		}

		return $widgetsMap;
	}
}

?>