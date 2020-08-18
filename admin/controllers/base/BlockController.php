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

/**
 * BlockController provides actions specific to block model.
 *
 * @since 1.0.0
 */
class BlockController extends ObjectDataController {

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
		$this->setViewPath( '@cmsgears/module-cms/admin/views/block' );

		// Config
		$this->type			= CmsGlobal::TYPE_BLOCK;
		$this->templateType = CmsGlobal::TYPE_BLOCK;
		$this->title		= 'Block';

		// Services
		$this->modelService = Yii::$app->factory->get( 'blockService' );
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Controller ----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// BlockController -----------------------

}
