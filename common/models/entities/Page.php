<?php
namespace cmsgears\cms\common\models\entities;

class Page extends Content {

	// Instance Methods --------------------------------------------

	public function getMenus() {

    	return $this->hasMany( Menu::className(), [ 'id' => 'menuId' ] )
					->viaTable( CmsTables::TABLE_MENU_PAGE, [ 'pageId' => 'id' ] );
	}

	public function getMenusMap() {
	
    	return $this->hasMany( MenuPage::className(), [ 'pageId' => 'id' ] );
	}

	public function getMenusIdList() {

    	$menus 		= $this->menusMap;
		$menusList	= array();

		foreach ( $menus as $menu ) {

			array_push( $menusList, $menu->menuId );
		}

		return $menusList;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function find() {

		return parent::find()->where( [ 'type' => self::TYPE_PAGE ] );
	}

	// Page ------------------------------
	
	/**
	 * @return Page - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}
}

?>