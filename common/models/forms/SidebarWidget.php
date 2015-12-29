<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class SidebarWidget extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Public Variables --------------------
	
	public $widget;
	public $widgetId;
	public $htmlOptions;
	public $icon;
	public $order;
	
	public $name; // used for update

	// Constructor -------------------------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Model

	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'widget', 'widgetId', 'htmlOptions', 'icon', 'order' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
			[ [ 'widget', 'widgetId', 'htmlOptions', 'icon', 'order' ], 'safe' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'widgetId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_WIDGET ),
			'htmlOptions' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}
}

?>