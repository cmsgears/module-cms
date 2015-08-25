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
use cmsgears\core\common\models\entities\Template;

/**
 * Widget Entity
 *
 * @property int $id
 * @property int $templateId
 * @property string $name
 * @property string $description
 * @property string $meta
 */
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

	public function getSidebarMappingList() {

    	return $this->hasMany( SidebarWidget::className(), [ 'widgetId' => 'id' ] );
	}

	public function getSidebarsIdList() {

    	$sidebars 		= $this->sidebarMappingList;
		$sidebarsList	= array();

		foreach ( $sidebars as $sidebar ) {

			array_push( $sidebarsList, $sidebar->sidebarId );
		}

		return $sidebarsList;
	}

	public function getTemplate() {

		return $this->hasOne( Template::className(), [ 'id' => 'templateId' ] );
	}

	public function getTemplateName() {

		$template = $this->template;

		if( isset( $template ) ) {

			return $template->name;
		}

		return '';
	}

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'name', 'description' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
            [ 'name', 'required', 'on' => [ 'create', 'update' ] ],
            [ [ 'id', 'templateId', 'description', 'meta' ], 'safe' ],
            [ 'name', 'alphanumhyphenspace' ],
            [ 'name', 'validateNameCreate', 'on' => [ 'create' ] ],
            [ 'name', 'validateNameUpdate', 'on' => [ 'update' ] ],
            [ 'metaMap', 'required', 'on' => [ 'meta' ] ]
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
			'templateId' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_TEMPLATE ),
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