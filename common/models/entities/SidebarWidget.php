<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

class SidebarWidget extends ActiveRecord {

	// Instance Methods --------------------------------------------


	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_SIDEBAR_WIDGET;
	}

	// SidebarWidget ---------------------

	// Delete

	public static function deleteBySidebarId( $sidebarId ) {

		self::deleteAll( 'sidebarId=:id', [ ':id' => $sidebarId ] );
	}

	public static function deleteByWidgetId( $widgetId ) {

		self::deleteAll( 'widgetId=:id', [ ':id' => $widgetId ] );
	}
}

?>