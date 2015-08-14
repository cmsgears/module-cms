<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgEntity;

/**
 * MenuPage Entity
 *
 * @property int $menuId
 * @property int $pageId
 * @property int $order
 */
class MenuPage extends CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return Menu - from the mapping.
	 */
	public function getMenu() {

		return $this->hasOne( Menu::className(), [ 'id' => 'menuId' ] );
	}

	/**
	 * @return Page - from the mapping.
	 */
	public function getPage() {

		return $this->hasOne( Page::className(), [ 'id' => 'pageId' ] );
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'menuId', 'pageId' ], 'required' ],
            [ 'order', 'safe' ],
            [ [ 'menuId', 'pageId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'menuId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_MENU ),
			'pageId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_PAGE ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::TABLE_MENU_PAGE;
	}
	
	// MenuPage --------------------------

	// Delete ----

	/**
	 * Delete all entries for the given menu id.
	 */
	public static function deleteByMenuId( $menuId ) {

		self::deleteAll( 'menuId=:id', [ ':id' => $menuId ] );
	}

	/**
	 * Delete all entries for the given page id.
	 */
	public static function deleteByPageId( $pageId ) {

		self::deleteAll( 'pageId=:id', [ ':id' => $pageId ] );
	}
}

?>