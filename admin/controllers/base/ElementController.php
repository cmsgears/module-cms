<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\admin\controllers\base;

// Yii Imports
use Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\admin\models\forms\ElementSettingsForm;

/**
 * ElementController provides actions specific to element model.
 *
 * @since 1.0.0
 */
class ElementController extends ObjectController {

	// Variables ---------------------------------------------------

	// Globals ----------------

	// Public -----------------

	public $title;

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		// Views
		$this->setViewPath( '@cmsgears/module-cms/admin/views/element' );

		// Config
		$this->type			= CmsGlobal::TYPE_ELEMENT;
		$this->templateType = CmsGlobal::TYPE_ELEMENT;
		$this->title		= 'Element';

		$this->settingsClass = ElementSettingsForm::class;

		// Services
		$this->modelService = Yii::$app->factory->get( 'elementService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ElementController ---------------------

}
