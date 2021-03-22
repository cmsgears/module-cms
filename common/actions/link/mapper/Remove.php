<?php
namespace cmsgears\cms\common\actions\link\mapper;

// Yii Imports
use Yii;

/**
 * Remove action disable the link mapping for model by de-activating it.
 */
class Remove extends \cmsgears\core\common\actions\mapper\Remove {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->modelMapperService = Yii::$app->factory->get( 'modelLinkService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Remove --------------------------------

}
