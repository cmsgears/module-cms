<?php
namespace cmsgears\cms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class MessageSource extends Component {

	// Variables ---------------------------------------------------

	private $messageDb = [
		// Generic Fields
		CoreGlobal::FIELD_TEMPLATE => "Template",
		CoreGlobal::FIELD_MENU => "Menu",
		CoreGlobal::FIELD_PAGE => "Page",
		CoreGlobal::FIELD_WIDGET => "Widget",
		CoreGlobal::FIELD_SIDEBAR => "Sidebar",
		// Content Fields
		CoreGlobal::FIELD_KEYWORDS => "Keywords",
		CoreGlobal::FIELD_SUMMARY => "Summary",
		CoreGlobal::FIELD_CONTENT => "Content"
	];

	/**
	 * Initialise the Cms Message DB Component.
	 */
    public function init() {

        parent::init();
    }

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->$messageDb[ $messageKey ];
	}
}

?>