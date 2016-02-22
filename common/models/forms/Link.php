<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class Link extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	public $address;	
	public $label;
	public $htmlOptions;
	public $urlOptions;
	public $private;
	public $relative;
	public $icon;
	public $order;

	public $type;

	// Constructor -------------------------------------------------

	// Instance Methods --------------------------------------------

	public function isPublic() {

		if( isset( $this->private ) && $this->private ) {

			return false;
		}

		return true;
	}

	// yii\base\Model

	public function rules() {

        $rules = [
			[ [ 'address', 'label', 'private', 'relative', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'safe' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'address', 'label', 'private', 'relative', 'htmlOptions', 'urlOptions', 'icon', 'order' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'address' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LINK ),
			'label' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LABEL ),
			'private' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_PRIVATE ),
			'relative' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_URL_RELATIVE ),
			'htmlOptions' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}
}

?>