<?php
namespace cmsgears\modules\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\modules\core\common\utilities\MessageUtil;

class Page extends Content {

	// Instance Methods --------------------------------------------
	
	// db columns

	public function getMenus() {

    	return $this->hasMany( Menu::className(), [ 'menu_id' => 'menu_id' ] )
					->viaTable( CMSTables::TABLE_MENU_PAGE, [ 'page_id' => 'page_id' ] );
	}

	public function getMenusMap() {
	
    	return $this->hasMany( MenuPage::className(), [ 'page_id' => 'page_id' ] );
	}

	public function getMenusIdList() {

    	$menus 		= $this->menusMap;
		$menusList	= array();

		foreach ( $menus as $menu ) {
			
			array_push( $menusList, $menu->menu_id );
		}

		return $menusList;
	}

	// Static Methods ----------------------------------------------

	public static function find() {
		
		return parent::find()->where( [ 'page_type' => self::TYPE_PAGE ] );
	}

	// Page

	public static function findById( $id ) {

		return Page::find()->where( 'page_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findBySlug( $slug ) {

		return Page::find()->where( 'page_slug=:slug', [ ':slug' => $slug ] )->one();
	}

	public static function findByName( $name ) {

		return Page::find()->where( 'page_name=:name', [ ':name' => $name ] )->one();
	}
}

?>