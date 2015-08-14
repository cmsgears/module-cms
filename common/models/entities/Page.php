<?php
namespace cmsgears\cms\common\models\entities;

use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\traits\MetaTrait;
use cmsgears\core\common\models\traits\FileTrait;
use cmsgears\cms\common\models\traits\ContentTrait;
use cmsgears\cms\common\models\traits\BlockTrait;

class Page extends Content {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_PAGE;

	use FileTrait;

	public $fileType	= CmsGlobal::TYPE_PAGE;

	use ContentTrait;

	public $contentType	= CmsGlobal::TYPE_PAGE;

	use BlockTrait;

	public $blockType	= CmsGlobal::TYPE_PAGE;

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

		return parent::find()->where( [ "$postTable.type" => CmsGlobal::TYPE_PAGE ] );
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