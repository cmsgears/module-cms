<?php
namespace cmsgears\modules\cms\common\models\entities;

// CMG Imports
use cmsgears\modules\core\common\models\entities\NamedActiveRecord;

class Sidebar extends NamedActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->sidebar_id;
	}

	public function getName() {

		return $this->sidebar_name;	
	}

	public function setName( $name ) {
		
		$this->sidebar_name = $name;	
	}

	public function getDesc() {

		return $this->sidebar_desc;	
	}

	public function setDesc( $desc ) {

		$this->sidebar_desc = $desc;	
	}

	public function isActive() {

		return $this->sidebar_active;	
	}

	public function getActiveStr() {

		return $this->sidebar_active ? "Yes" : "No";	
	}

	public function setActive( $active ) {

		$this->sidebar_active = $active;	
	}

	public function getWidgets() {

    	return $this->hasMany( Widget::className(), [ 'widget_id' => 'widget_id' ] )
					->viaTable( CMSTables::TABLE_SIDEBAR_WIDGET, [ 'sidebar_id' => 'sidebar_id' ] );
	}

	public function getWidgetsMap() {

    	return $this->hasMany( SidebarWidget::className(), [ 'sidebar_id' => 'sidebar_id' ] );
	}

	public function getWidgetsIdList() {

    	$widgets 		= $this->widgetsMap;
		$widgetsList	= array();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->widget_id );
		}

		return $widgetsList;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ [ 'sidebar_name' ], 'required' ],
            [ 'sidebar_name', 'alphanumhyphen' ],
            [ 'sidebar_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'sidebar_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ [ 'sidebar_desc', 'sidebar_active' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'sidebar_name' => 'Name',
			'sidebar_desc' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_SIDEBAR;
	}

	// Sidebar

	public static function findById( $id ) {

		return Sidebar::find()->where( 'sidebar_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Sidebar::find()->where( 'sidebar_name=:name', [ ':name' => $name ] )->one();
	}
}

?>