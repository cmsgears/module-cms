<?php
namespace cmsgears\cms\frontend\controllers\base;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsProperties;

class Controller extends \cmsgears\core\common\controllers\Controller {

	private $_cmsProperties;

	// Constructor and Initialisation ------------------------------

 	public function __construct( $id, $module, $config = [] ) {

        parent::__construct( $id, $module, $config );
	}

	// Instance Methods --------------------------------------------

	public function getCmsProperties() {

		if( !isset( $this->_cmsProperties ) ) {

			$this->_cmsProperties	= CmsProperties::getInstance();
		}

		return $this->_cmsProperties;
	}
}

?>