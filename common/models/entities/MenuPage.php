<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

class MenuPage extends ActiveRecord {

	// Instance Methods --------------------------------------------


	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_MENU_PAGE;
	}
	
	// MenuPage --------------------------

	// Delete

	public static function deleteByMenuId( $menuId ) {

		self::deleteAll( 'menuId=:id', [ ':id' => $menuId ] );
	}

	public static function deleteByPageId( $pageId ) {

		self::deleteAll( 'pageId=:id', [ ':id' => $pageId ] );
	}
}

?>