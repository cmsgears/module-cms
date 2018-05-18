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
use cmsgears\core\common\models\resources\Form as BaseForm;

use cmsgears\cms\common\models\interfaces\resources\IPageContent;
use cmsgears\cms\common\models\interfaces\mappers\IBlock;
use cmsgears\cms\common\models\interfaces\mappers\IElement;
use cmsgears\cms\common\models\interfaces\mappers\IWidget;

use cmsgears\cms\common\models\traits\resources\PageContentTrait;
use cmsgears\cms\common\models\traits\mappers\BlockTrait;
use cmsgears\cms\common\models\traits\mappers\ElementTrait;
use cmsgears\cms\common\models\traits\mappers\WidgetTrait;

/**
 * @inheritdoc
 */
class Form extends BaseForm implements IBlock, IElement, IPageContent, IWidget {

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

	// Category ------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Category ------------------------------

	// Read - Query -----------

	/**
	 * @inheritdoc
	 */
	public static function queryWithHasOne( $config = [] ) {

		$relations = isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'site', 'modelContent', 'creator', 'modifier' ];

		$config[ 'relations' ] = $relations;

		return parent::queryWithAll( $config );
	}

	/**
	 * Return query to find the model with content.
	 *
	 * @param array $config
	 * @return \yii\db\ActiveQuery to query with content.
	 */
	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent', 'modelContent.template' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
