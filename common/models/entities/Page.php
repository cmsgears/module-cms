<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

/**
 * Page represents pages used for site page and articles.
 *
 * @since 1.0.0
 */
class Page extends Content {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmsGlobal::TYPE_PAGE;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	/**
	 * @inheritdoc
	 */
	public function rules() {

		$rules = parent::rules();

		$rules[] = [ 'parentId', 'validateParent' ];

		return $rules;
	}

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	public function validateParent( $attribute, $param ) {

		if( !$this->hasErrors() ) {

			if( isset( $this->parentId ) && isset( $this->id ) && $this->parentId == $this->id ) {

				$this->addError( 'parentId', 'Page cannot be parent of same.' );
			}
		}
	}

	// Page ----------------------------------

	public function getChildren() {

		return $this->hasMany( self::class, [ 'parentId' => 'id' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Page ----------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
