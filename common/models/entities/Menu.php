<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

use cmsgears\core\common\models\traits\MetaTrait;

class Menu extends NamedCmgEntity {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_MENU;

	// Instance Methods --------------------------------------------

	public function getPages() {

    	return $this->hasMany( Page::className(), [ 'id' => 'pageId' ] )
					->viaTable( CMSTables::TABLE_PAGE, [ 'menuId' => 'id' ] );
	}

	public function getPagesMap() {

    	return $this->hasMany( MenuPage::className(), [ 'menuId' => 'id' ] );
	}

	public function getPagesIdList() {

    	$pages 		= $this->pagesMap;
		$pagesList	= array();

		foreach ( $pages as $page ) {

			array_push( $pagesList, $page->pageId );
		}

		return $pagesList;
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
            [ 'name', 'alphanumspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'id', 'description' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'name' => 'Name',
			'description' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_MENU;
	}

	// Menu

}

?>