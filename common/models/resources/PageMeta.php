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
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Content;

/**
 * PageMeta stores meta and attributes specific to page and post.
 *
 * @inheritdoc
 */
class PageMeta extends \cmsgears\core\common\models\base\Meta {

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

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// PageMeta ------------------------------

	/**
	 * Return corresponding content.
	 *
	 * @return \cmsgears\cms\common\models\entities\Content
	 */
	public function getParent() {

		return $this->hasOne( Content::className(), [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	/**
	 * @inheritdoc
	 */
	public static function tableName() {

		return CmsTables::getTableName( CmsTables::TABLE_PAGE_META );
	}

	// CMG parent classes --------------------

	// PageMeta ------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
