<?php
namespace cmsgears\cms\common\models\entities;

class Page extends Content {

	// Instance Methods --------------------------------------------

	public function getMenus() {

    	return $this->hasMany( Menu::className(), [ 'id' => 'menuId' ] )
					->viaTable( CmsTables::TABLE_MENU_PAGE, [ 'pageId' => 'id' ] );
	}

	public function getMenuMappingList() {

    	return $this->hasMany( MenuPage::className(), [ 'pageId' => 'id' ] );
	}

	public function getMenusIdList() {

    	$menus 		= $this->menuMappingList;
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

		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => Page::TYPE_PAGE ] );
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