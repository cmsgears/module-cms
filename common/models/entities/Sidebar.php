<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

use cmsgears\core\common\models\traits\MetaTrait;

class Sidebar extends NamedCmgEntity {

	use MetaTrait;

	public $metaType	= CmsGlobal::TYPE_SIDEBAR;

	// Instance Methods --------------------------------------------

	public function getActiveStr() {

		return $this->active ? "Yes" : "No";	
	}

	public function getWidgets() {

    	return $this->hasMany( Widget::className(), [ 'id' => 'widgetId' ] )
					->viaTable( CMSTables::TABLE_SIDEBAR_WIDGET, [ 'sidebarId' => 'id' ] );
	}

	public function getWidgetsMap() {

    	return $this->hasMany( SidebarWidget::className(), [ 'sidebarId' => 'id' ] );
	}

	public function getWidgetsIdList() {

    	$widgets 		= $this->widgetsMap;
		$widgetsList	= array();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->id );
		}

		return $widgetsList;
	}

	// yii\base\Model --------------------

	public function rules() {

        return [
            [ [ 'name' ], 'required' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'id', 'description', 'active' ], 'safe' ]
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

		return CmsTables::TABLE_SIDEBAR;
	}

	// Sidebar --------------------------

}

?>