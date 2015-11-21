<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class Link extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	public $address;	
	public $label;
	public $relative;

	// Constructor -------------------------------------------------

	// Instance Methods --------------------------------------------
	
	// yii\base\Model

	public function rules() {
		
		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'address', 'label', 'relative' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
			[ [ 'address', 'label', 'relative' ], 'safe' ]
		];


		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'address' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LINK ),
			'label' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LABEL ),
			'relative' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_URL_RELATIVE )
		];
	}
}

?>