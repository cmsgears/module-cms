<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CoreTables;
use cmsgears\core\common\models\entities\ObjectData;

class WidgetService extends \cmsgears\core\common\services\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	public static function findById( $id ) {

		return ObjectData::findById( $id );
	}

	public static function findByName( $name ) {

		return ObjectData::findByNameType( $name, CmsGlobal::TYPE_WIDGET );
	}

	public static function getIdList() {

		return self::findList( "id", CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_WIDGET ] ] );
	}

	public static function getIdNameList() {

		return self::findIdNameList( "id", "name", CoreTables::TABLE_OBJECT_DATA, [ 'conditions' => [ 'type' => CmsGlobal::TYPE_WIDGET ] ] );
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

		$config[ 'conditions' ][ 'type' ] =  CmsGlobal::TYPE_WIDGET;

		return self::getDataProvider( new Widget(), $config );
	}

	// Create -----------

	public static function create( $widget, $meta ) {

		if( $widget->templateId <= 0 ) {

			unset( $widget->templateId );
		}

		$widget->generateJsonFromObject( $meta );

		$widget->save();

		return $widget;
	}

	// Update -----------

	public static function update( $widget, $meta ) {

		if( $widget->templateId <= 0 ) {

			unset( $widget->templateId );
		}

		$widgetToUpdate	= self::findById( $widget->id );

		$widgetToUpdate->copyForUpdateFrom( $widget, [ 'name', 'description', 'templateId' ] );
		
		$widgetToUpdate->generateJsonFromObject( $meta );
		
		$widgetToUpdate->update();

		return $widgetToUpdate;
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