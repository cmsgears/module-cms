<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;

class Menu extends NamedCmgEntity {

	// Instance Methods --------------------------------------------

	public function getPages() {

    	return $this->hasMany( Page::className(), [ 'id' => 'pageId' ] )
					->viaTable( CMSTables::TABLE_PAGE, [ 'menuId' => 'id' ] );
	}

	public function getPagesMap() {

    	return $this->hasMany( MenuPage::className(), [ 'menuId' => 'pageId' ] );
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