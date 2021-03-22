<?php
namespace cmsgears\cms\common\actions\link\mapper;

// Yii Imports
use Yii;

/**
 * Assign action maps existing link to model in action using ModelLink mapper.
 */
class Assign extends \cmsgears\core\common\actions\mapper\Assign {

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

	// Assign --------------------------------

}
