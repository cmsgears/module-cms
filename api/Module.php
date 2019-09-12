<?php
/**
 * This file is part of project Cmsgears. Please view License file distributed
 * with the source code for license details.
 *
 * @copyright Copyright (c) 2019
 */

namespace cmsgears\cms\api;

/**
 * The api module component of cms module.
 *
 * @since 1.0.0
 */
class Module extends \cmsgears\core\common\base\Module {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $controllerNamespace = 'cmsgears\cms\api\controllers';

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->setViewPath( '@cmsgears/module-cms/api/views' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Module --------------------------------

}
