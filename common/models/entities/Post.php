<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\TabTrait;
use cmsgears\core\common\models\traits\resources\CommentTrait;
use cmsgears\core\common\models\traits\mappers\CategoryTrait;
use cmsgears\core\common\models\traits\mappers\FileTrait;
use cmsgears\core\common\models\traits\mappers\TagTrait;
use cmsgears\cms\common\models\traits\resources\ContentTrait;
use cmsgears\cms\common\models\traits\mappers\BlockTrait;

class Post extends Content {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Pre-Defined Status
	const STATUS_BASIC		=  20;
	const STATUS_MEDIA		=  40;
	const STATUS_ATTRIBUTES	= 480;
	const STATUS_SETTINGS	= 490;
	const STATUS_REVIEW		= 499;

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $modelType		= CmsGlobal::TYPE_POST;

	public $categoryType	= CmsGlobal::TYPE_POST;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use BlockTrait;
	use CommentTrait;
	use ContentTrait;
	use CategoryTrait;
	use FileTrait;
	use TabTrait;
	use TagTrait;

	// Constructor and Initialisation ------------------------------

	public function init() {

		parent::init();

		$this->tabStatus	= [ 'basic' => self::STATUS_BASIC, 'media' => self::STATUS_MEDIA, 'attributes' => self::STATUS_ATTRIBUTES, 'settings' => self::STATUS_SETTINGS, 'review' => self::STATUS_REVIEW ];

		$this->nextStatus	= [ self::STATUS_BASIC => self::STATUS_MEDIA, self::STATUS_MEDIA => self::STATUS_ATTRIBUTES, self::STATUS_ATTRIBUTES => self::STATUS_SETTINGS, self::STATUS_SETTINGS => self::STATUS_REVIEW ];

		$this->previousTab	= [ 'media' => 'basic', 'attributes' => 'media', 'settings' => 'attributes', 'review' => 'settings' ];

		$this->nextTab		= [ 'basic' => 'media', 'media' => 'attributes', 'attributes' => 'settings', 'settings' => 'review' ];
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

	/**
	 * @inheritdoc
	 */
	public static function find() {

		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => CmsGlobal::TYPE_POST ] );
	}

	// CMG parent classes --------------------

	// Post ----------------------------------

	// Read - Query -----------

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------

}

Post::$statusMap[ Post::STATUS_BASIC ]		= 'Reg - Basic';
Post::$statusMap[ Post::STATUS_MEDIA ]		= 'Reg - Media';
Post::$statusMap[ Post::STATUS_ATTRIBUTES ]	= 'Reg - Attributes';
Post::$statusMap[ Post::STATUS_SETTINGS ]	= 'Reg - Settings';
Post::$statusMap[ Post::STATUS_REVIEW ]		= 'Reg - Review';
