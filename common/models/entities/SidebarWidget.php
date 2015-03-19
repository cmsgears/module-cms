<?php
namespace cmsgears\modules\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

class SidebarWidget extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getSidebarId() {

		return $this->sidebar_id;
	}

	public function setSidebarId( $sidebarId ) {

		$this->sidebar_id = $sidebarId;
	}

	public function getWidgetId() {

		return $this->widget_id;
	}

	public function setWidgetId( $widgetId ) {

		$this->widget_id = $widgetId;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_SIDEBAR_WIDGET;
	}

	// Delete

	public static function deleteBySidebar( $sidebarId ) {

		self::deleteAll( 'sidebar_id=:id', [ ':id' => $sidebarId ] );
	}

	public static function deleteByWidget( $widgetId ) {

		self::deleteAll( 'widget_id=:id', [ ':id' => $widgetId ] );
	}
}

?>