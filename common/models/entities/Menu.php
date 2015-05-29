<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

use cmsgears\core\common\models\traits\MetaTrait;

class Menu extends NamedCmgEntity {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_MENU;

	// Instance Methods --------------------------------------------

	public function getPages() {

    	return $this->hasMany( Page::className(), [ 'id' => 'pageId' ] )
					->viaTable( CmsTables::TABLE_PAGE, [ 'menuId' => 'id' ] );
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

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
            [ [ 'id', 'description' ], 'safe' ],
            [ 'name', 'alphanumspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'name' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_NAME ),
			'description' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_DESCRIPTION )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_MENU;
	}

	// Menu

}

?>