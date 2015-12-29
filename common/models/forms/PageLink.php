<?php
namespace cmsgears\cms\common\models\forms;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

class PageLink extends \cmsgears\core\common\models\forms\JsonModel {

	// Variables ---------------------------------------------------

	// Public Variables --------------------

	public $link;
	public $pageId;
	public $htmlOptions;
	public $icon;
	public $order;

	public $type;	// used by service for create
	public $name;	// used for update

	// Constructor -------------------------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Model

	public function rules() {

		$trim		= [];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			$trim[] = [ [ 'link', 'pageId', 'htmlOptions', 'icon', 'order' ], 'filter', 'filter' => 'trim', 'skipOnArray' => true ];
		}

        $rules = [
			[ [ 'link', 'pageId', 'htmlOptions', 'icon', 'order' ], 'safe' ],
			[ 'order', 'number', 'integerOnly' => true ]
		];

		if( Yii::$app->cmgCore->trimFieldValue ) {

			return ArrayHelper::merge( $trim, $rules );
		}

		return $rules;
	}

	public function attributeLabels() {

		return [
			'link' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_LINK ),
			'pageId' => Yii::$app->cmgCmsMessage->getMessage( CmsGlobal::FIELD_PAGE ),
			'htmlOptions' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_HTML_OPTIONS ),
			'icon' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ICON ),
			'order' => Yii::$app->cmgCoreMessage->getMessage( CoreGlobal::FIELD_ORDER )
		];
	}
}

?>