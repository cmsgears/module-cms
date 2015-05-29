<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\NamedCmgEntity;

class Widget extends NamedCmgEntity {
	
	public $metaMap;

	// Instance Methods --------------------------------------------

	public function generateJsonFromMap() {

		$metaJson	= json_encode( $this->metaMap );
		$metaJson	= "{ \"metaMap\" : $metaJson }";

		return $metaJson;
	}

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

			array_push( $widgetsList, $widget->sidebarId );
		}

		return $widgetsList;
	}

	public function getTemplate() {

		return $this->hasOne( Template::className(), [ 'id' => 'templateId' ] );
	}

	public function getTemplateName() {

		$template = $this->template;
		
		if( isset( $template ) ) {
			
			return $template->name;
		}
		else {
			
			return '';
		}
	}

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public function rules() {

        return [
            [ 'name', 'required', 'on' => [ 'create', 'update' ] ],
            [ [ 'id', 'templateId', 'description', 'meta' ], 'safe' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ 'metaMap', 'required', 'on' => [ 'meta' ] ]
        ];
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels() {

		return [
			'templateId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_TEMPLATE ),
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

		return CmsTables::TABLE_WIDGET;
	}

	// Widget ----------------------------

}

?>