<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CmgEntity;

/**
 * SidebarWidget Entity
 *
 * @property int $sidebarId
 * @property int $widgetId
 * @property int $order
 */
class SidebarWidget extends CmgEntity {

	// Instance Methods --------------------------------------------

	/**
	 * @return Sidebar - from the mapping.
	 */
	public function getSidebar() {

		return $this->hasOne( Sidebar::className(), [ 'id' => 'sidebarId' ] );
	}

	/**
	 * @return Widget - from the mapping.
	 */
	public function getWidget() {

		return $this->hasOne( Widget::className(), [ 'id' => 'widgetId' ] );
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'sidebarId', 'widgetId' ], 'required' ],
            [ 'order', 'safe' ],
            [ [ 'sidebarId', 'widgetId' ], 'number', 'integerOnly' => true, 'min' => 1 ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'sidebarId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_SIDEBAR ),
			'widgetId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_WIDGET ),
			'order' => Yii::$app->cmgCmsMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_SIDEBAR_WIDGET;
	}

	// SidebarWidget ---------------------

	// Delete ----
	
	/**
	 * Delete all entries having given sidebar id.
	 */
	public static function deleteBySidebarId( $sidebarId ) {

		self::deleteAll( 'sidebarId=:id', [ ':id' => $sidebarId ] );
	}

	/**
	 * Delete all entries having given widget id.
	 */
	public static function deleteByWidgetId( $widgetId ) {

		self::deleteAll( 'widgetId=:id', [ ':id' => $widgetId ] );
	}
}

?>