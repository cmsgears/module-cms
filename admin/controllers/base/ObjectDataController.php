<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\base;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * ObjectDataController provides actions specific to object model.
 *
 * @since 1.0.0
 */
abstract class ObjectDataController extends \cmsgears\core\admin\controllers\base\ObjectDataController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Permission
		$this->crudPermission = CmsGlobal::PERM_BLOG_ADMIN;

		// Config
		$this->minStatusMap = true;

		// Notes: Configure sidebar and returnUrl exclusively in child classes. We can also change type and templateType in child classes.
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ObjectDataController ------------------

}
