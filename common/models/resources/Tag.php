<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\resources;

// CMG Imports
use cmsgears\core\common\models\resources\Tag as BaseTag;

use cmsgears\cms\common\models\interfaces\mappers\IBlock;
use cmsgears\cms\common\models\interfaces\mappers\IElement;
use cmsgears\cms\common\models\interfaces\mappers\IWidget;
use cmsgears\cms\common\models\interfaces\resources\IPageContent;

use cmsgears\cms\common\models\traits\mappers\BlockTrait;
use cmsgears\cms\common\models\traits\mappers\ElementTrait;
use cmsgears\cms\common\models\traits\mappers\WidgetTrait;
use cmsgears\cms\common\models\traits\resources\PageContentTrait;

/**
 * @inheritdoc
 */
class Tag extends BaseTag implements IBlock, IElement, IPageContent, IWidget {

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

	use BlockTrait;
	use ElementTrait;
	use PageContentTrait;
	use WidgetTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Tag -----------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Tag -----------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
