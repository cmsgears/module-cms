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
		CmsGlobal::FIELD_TEMPLATE => "Template",
		CmsGlobal::FIELD_MENU => "Menu",
		CmsGlobal::FIELD_PAGE => "Page",
		CmsGlobal::FIELD_WIDGET => "Widget",
		CmsGlobal::FIELD_SIDEBAR => "Sidebar",
		// Content Fields
		CmsGlobal::FIELD_KEYWORDS => "Keywords"
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