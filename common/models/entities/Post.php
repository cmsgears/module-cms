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

use cmsgears\core\common\models\interfaces\base\ITab;
use cmsgears\core\common\models\interfaces\mappers\ICategory;
use cmsgears\core\common\models\interfaces\mappers\ITag;

use cmsgears\core\common\models\traits\base\TabTrait;
use cmsgears\core\common\models\traits\mappers\CategoryTrait;
use cmsgears\core\common\models\traits\mappers\TagTrait;

/**
 * Post represents pages used for blog posts.
 *
 * @since 1.0.0
 */
class Post extends Content implements ICategory, ITab, ITag {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Pre-Defined Status
	const STATUS_BASIC		= 100;
	const STATUS_MEDIA		= 120;
	const STATUS_ELEMENTS	= 140;
	const STATUS_BLOCKS		= 160;
	const STATUS_ATTRIBUTES	= 470;
	const STATUS_SETTINGS	= 480;
	const STATUS_REVIEW		= 499;

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelType = CmsGlobal::TYPE_POST;

	// Private ----------------

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use TabTrait;
	use TagTrait;

	// Constructor and Initialisation ------------------------------

	public function init() {

		$this->tabStatus = [
			'basic' => self::STATUS_BASIC, 'media' => self::STATUS_MEDIA,
			'elements' => self::STATUS_ELEMENTS, 'blocks' => self::STATUS_BLOCKS,
			'attributes' => self::STATUS_ATTRIBUTES,
			'settings' => self::STATUS_SETTINGS, 'review' => self::STATUS_REVIEW
		];

		$this->nextStatus = [
			self::STATUS_NEW => self::STATUS_BASIC, self::STATUS_BASIC => self::STATUS_MEDIA,
			self::STATUS_MEDIA => self::STATUS_ELEMENTS, self::STATUS_ELEMENTS => self::STATUS_BLOCKS,
			self::STATUS_BLOCKS => self::STATUS_ATTRIBUTES,
			self::STATUS_ATTRIBUTES => self::STATUS_SETTINGS, self::STATUS_SETTINGS => self::STATUS_REVIEW
		];

		$this->previousTab = [
			'media' => 'basic',
			'elements' => 'media',
			'blocks' => 'elements',
			'attributes' => 'blocks',
			'settings' => 'attributes',
			'review' => 'settings'
		];

		$this->nextTab = [
			'basic' => 'media',
			'media' => 'elements',
			'elements' => 'blocks',
			'blocks' => 'attributes',
			'attributes' => 'settings',
			'settings' => 'review'
		];
	}

	// Instance methods --------------------------------------------

	// Yii interfaces ------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// yii\base\Model ---------

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// Validators ----------------------------

	// Post ----------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

	// CMG parent classes --------------------

	// Post ----------------------------------

	// Read - Query -----------

	// Read - Find ------------

	/**
	 * @inheritdoc
	 */
	public static function find() {

		$table = static::tableName();

		return parent::find()->where( [ "$table.type" => CmsGlobal::TYPE_POST ] );
	}

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}

Post::$statusMap[ Post::STATUS_BASIC ]		= 'Basic';
Post::$statusMap[ Post::STATUS_MEDIA ]		= 'Media';
Post::$statusMap[ Post::STATUS_ELEMENTS ]	= 'Elements';
Post::$statusMap[ Post::STATUS_BLOCKS ]		= 'Blocks';
Post::$statusMap[ Post::STATUS_ATTRIBUTES ]	= 'Attributes';
Post::$statusMap[ Post::STATUS_SETTINGS ]	= 'Settings';
Post::$statusMap[ Post::STATUS_REVIEW ]		= 'Review';
