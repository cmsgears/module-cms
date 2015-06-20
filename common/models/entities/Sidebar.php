<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

use cmsgears\core\common\models\traits\MetaTrait;

/**
 * Sidebar Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Sidebar extends NamedCmgEntity {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_SIDEBAR;

	// Instance Methods --------------------------------------------

	public function getWidgets() {

    	return $this->hasMany( Widget::className(), [ 'id' => 'widgetId' ] )
					->viaTable( CMSTables::TABLE_SIDEBAR_WIDGET, [ 'sidebarId' => 'id' ] );
	}

	public function getWidgetMappingList() {

    	return $this->hasMany( SidebarWidget::className(), [ 'sidebarId' => 'id' ] );
	}

	public function getWidgetsIdList() {

    	$widgets 		= $this->widgetMappingList;
		$widgetsList	= array();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->widgetId );
		}

		return $widgetsList;
	}

	// yii\base\Model --------------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
            [ [ 'id', 'description' ], 'safe' ],
            [ 'name', 'alphanumhyphenspace' ],
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

		return CmsTables::TABLE_SIDEBAR;
	}

	// Sidebar --------------------------

}

?>