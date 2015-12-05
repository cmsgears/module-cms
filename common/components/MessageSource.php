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
		CmsGlobal::FIELD_MENU => 'Menu',
		CmsGlobal::FIELD_PAGE => 'Page',
		CmsGlobal::FIELD_BLOCK => 'Block',
		CmsGlobal::FIELD_WIDGET => 'Widget',
		CmsGlobal::FIELD_SIDEBAR => 'Sidebar',
		CmsGlobal::FIELD_URL_RELATIVE => 'Relative URL',
		// Errors
		CmsGlobal::ERROR_NO_TEMPLATE => 'No teplate defined.',
		CmsGlobal::ERROR_NO_VIEW => 'Layout or view is missing.',
		// Content Fields
		CmsGlobal::FIELD_KEYWORDS => 'Keywords',
		// SEO
		CmsGlobal::FIELD_SEO_NAME => 'SEO Name',
		CmsGlobal::FIELD_SEO_DESCRIPTION => 'SEO Description',
		CmsGlobal::FIELD_SEO_KEYWORDS => 'SEO Keywords',
		CmsGlobal::FIELD_SEO_ROBOT => 'SEO Robot',
		// Block Fields
		CmsGlobal::FIELD_BACKGROUND => 'Background',
		CmsGlobal::FIELD_TEXTURE => 'Texture'
	];

	/**
	 * Initialise the Cms Message DB Component.
	 */
    public function init() {

        parent::init();
    }

	public function getMessage( $messageKey, $params = [], $language = null ) {

		return $this->messageDb[ $messageKey ];
	}
}

?>