<?php
namespace cmsgears\cms\common\components;

// Yii Imports
use \Yii;
use yii\base\Component;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

class MessageSourceCms extends Component {

	// Variables ---------------------------------------------------

	public $errorsDb = [
		// Errors - Generic
		// Messages - Generic
	];

	/**
	 * Initialise the Cms Message DB Component.
	 */
    public function init() {

        parent::init();
    }

	public function getMessage( $messageKey ) {

		return $this->errorsDb[ $messageKey ];
	}
}

?>