<?php
namespace cmsgears\modules\cms\common\models\entities;

// CMG Imports
use cmsgears\modules\core\common\models\entities\NamedActiveRecord;

class Widget extends NamedActiveRecord {
	
	public $meta_map;

	// Instance Methods --------------------------------------------

	// db columns

	public function getId() {

		return $this->widget_id;
	}

	public function getName() {

		return $this->widget_name;	
	}

	public function setName( $name ) {
		
		$this->widget_name = $name;	
	}

	public function getDesc() {

		return $this->widget_desc;	
	}

	public function setDesc( $desc ) {

		$this->widget_desc = $desc;	
	}

	public function getTemplate() {

		return $this->widget_template;	
	}

	public function setTemplate( $template ) {

		$this->widget_template = $template;	
	}

	public function getMeta() {

		return $this->widget_meta;
	}

	public function setMeta( $meta ) {

		$this->widget_meta = $meta;
	}

	public function getMetaMap() {

		return $this->meta_map;
	}

	public function setMetaMap( $metaMap ) {

		$this->meta_map = $metaMap;
	}

	public function generateMapFromJson() {

		$obj 			= json_decode( $this->widget_meta, 'true' );
		$this->meta_map	= $obj[ 'metaMap' ];
	}

	public function getMetaObject() {

		if( !isset( $this->meta_map ) ) {

			$this->generateMapFromJson();
		}

		return (object)$this->meta_map;
	}

	public function getSidebars() {

    	return $this->hasMany( Sidebar::className(), [ 'sidebar_id' => 'sidebar_id' ] )
					->viaTable( CMSTables::TABLE_SIDEBAR_WIDGET, [ 'widget_id' => 'widget_id' ] );
	}

	public function getSidebarsMap() {

    	return $this->hasMany( SidebarWidget::className(), [ 'widget_id' => 'widget_id' ] );
	}

	public function getSidebarsIdList() {

    	$widgets 		= $this->sidebarsMap;
		$widgetsList	= array();

		foreach ( $widgets as $widget ) {

			array_push( $widgetsList, $widget->sidebar_id );
		}

		return $widgetsList;
	}

	// yii\base\Model

	public function rules() {

        return [
            [ 'widget_name', 'required', 'on' => [ 'create', 'update' ] ],
            [ 'widget_name', 'alphanumhyphenspace' ],
            [ 'widget_name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'widget_name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ 'widget_template', 'alphanumhyphen' ],
            [ 'meta_map', 'required', 'on' => [ 'meta' ] ],
            [ [ 'widget_desc', 'widget_meta', 'widget_template' ], 'safe' ]
        ];
    }

	public function attributeLabels() {

		return [
			'widget_name' => 'Name',
			'widget_desc' => 'Description',
			'widget_template' => 'Template'
		];
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord
	
	public static function tableName() {
		
		return CMSTables::TABLE_WIDGET;
	}

	// Widget

	public static function findById( $id ) {

		return Widget::find()->where( 'widget_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findByName( $name ) {

		return Widget::find()->where( 'widget_name=:name', [ ':name' => $name ] )->one();
	}
}

?>