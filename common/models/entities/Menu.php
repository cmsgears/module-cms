<?php
namespace cmsgears\modules\cms\common\models\entities;

// CMG Imports
use cmsgears\modules\core\common\models\entities\NamedActiveRecord;

class Menu extends NamedActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->menu_id;
	}

	public function getParentId() {

		return $this->menu_parent;
	}

	public function setParentId( $parentId ) {

		$this->menu_parent = $parentId;
	}

	public function getName() {

		return $this->menu_name;	
	}

	public function setName( $name ) {
		
		$this->menu_name = $name;	
	}

	public function getDesc() {

		return $this->menu_desc;	
	}

	public function setDesc( $desc ) {

		$this->menu_desc = $desc;	
	}

	public function getPages() {

    	return $this->hasMany( Page::className(), [ 'page_id' => 'page_id' ] )
					->viaTable( CMSTables::TABLE_MENU_PAGE, [ 'menu_id' => 'menu_id' ] );
	}

	public function getPagesMap() {

    	return $this->hasMany( MenuPage::className(), [ 'menu_id' => 'menu_id' ] );
	}

	public function getPagesIdList() {

    	$pages 		= $this->pagesMap;
		$pagesList	= array();

		foreach ( $pages as $page ) {

			array_push( $pagesList, $page->page_id );
		}

		return $pagesList;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'menu_name' ], 'required' ],
            [ 'menu_name', 'alphanumspace' ],
            [ 'menu_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'menu_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'menu_desc' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'menu_name' => 'Name',
			'menu_desc' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_MENU;
	}

	// Menu

	public static function findById( $id ) {

		return Menu::find()->where( 'menu_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Menu::find()->where( 'menu_name=:name', [ ':name' => $name ] )->one();
	}
}

?>