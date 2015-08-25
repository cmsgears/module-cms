<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;
use yii\validators\FilterValidator;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

use cmsgears\core\common\models\traits\MetaTrait;

/**
 * Menu Entity
 *
 * @property int $id
 * @property int $parentId
 * @property string $name
 * @property string $description
 */
class Menu extends NamedCmgEntity {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_MENU;

	// Instance Methods --------------------------------------------

	public function getPages() {

    	return $this->hasMany( Page::className(), [ 'id' => 'pageId' ] )
					->viaTable( CmsTables::TABLE_PAGE, [ 'menuId' => 'id' ] );
	}

	public function getPageMappingList() {

    	return $this->hasMany( MenuPage::className(), [ 'menuId' => 'id' ] );
	}

	public function getPagesIdList() {

    	$pages 		= $this->pageMappingList;
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

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ [ 'name' ], 'required' ],
            [ [ 'id', 'description' ], 'safe' ],
            [ 'name', 'alphanumspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ]
        ];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
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