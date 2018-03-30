<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\models\mappers;

// CMG Imports
use cmsgears\core\common\models\base\Follower;
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\entities\Content;

/**
 * PageFollower represents interest of user in page or post.
 *
 * @property int $id
 * @property int $modelId
 * @property int $followerId
 * @property string $type
 * @property boolean $active
 * @property int $createdAt
 * @property int $modifiedAt
 *
 * @since 1.0.0
 */
class PageFollower extends Follower {

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

	// PageFollower --------------------------

	/**
	 * Return corresponding page or post.
	 *
	 * @return \cmsgears\cms\common\models\entities\Content
	 */
	public function getModel() {

		return $this->hasOne( Content::class, [ 'id' => 'modelId' ] );
	}

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function tableName() {

		return CmsTables::getTableName( CmsTables::TABLE_PAGE_FOLLOWER );
	}

	// CMG parent classes --------------------

	// PageFollower --------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}
