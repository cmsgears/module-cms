<?php
namespace cmsgears\modules\cms\common\models\entities;

// Yii imports
use yii\db\ActiveRecord;

class MenuPage extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getMenuId() {

		return $this->menu_id;
	}

	public function setMenuId( $menuId ) {

		$this->menu_id = $menuId;
	}

	public function getPageId() {

		return $this->page_id;
	}

	public function setPageId( $pageId ) {

		$this->page_id = $pageId;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_MENU_PAGE;
	}
	
	// Delete
	
	public static function deleteByMenu( $menuId ) {

		self::deleteAll( 'menu_id=:id', [ ':id' => $menuId ] );
	}
	
	public static function deleteByPage( $pageId ) {

		self::deleteAll( 'page_id=:id', [ ':id' => $pageId ] );
	}
}

?>