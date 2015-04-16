<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\NamedCmgEntity;

class Widget extends NamedCmgEntity {
	
	public $metaMap;

	// Instance Methods --------------------------------------------

	public function generateMapFromJson() {

		$obj 			= json_decode( $this->meta, 'true' );
		$this->metaMap	= $obj[ 'metaMap' ];
	}

	public function getMetaObject() {

		if( !isset( $this->metaMap ) ) {

			$this->generateMapFromJson();
		}

		return (object)$this->metaMap;
	}

	public function getSidebars() {

    	return $this->hasMany( Sidebar::className(), [ 'id' => 'sidebarId' ] )
					->viaTable( CMSTables::TABLE_SIDEBAR_WIDGET, [ 'widgetId' => 'id' ] );
	}

	public function getSidebarsMap() {

    	return $this->hasMany( SidebarWidget::className(), [ 'widgetId' => 'id' ] );
	}

	public function getSidebarsIdList() {

    	$widgets 		= $this->sidebarsMap;
		$widgetsList	= array();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->id );
		}

		return $widgetsList;
	}

	// yii\db\ActiveRecord ---------------

	public function rules() {

        return [
            [ 'name', 'required', 'on' => [ 'create', 'update' ] ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ 'metaMap', 'required', 'on' => [ 'meta' ] ],
            [ [ 'id', 'templateId', 'description', 'meta' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'templateId' => 'Template',
			'name' => 'Name',
			'description' => 'Description'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_WIDGET;
	}

	// Widget ----------------------------

}

?>