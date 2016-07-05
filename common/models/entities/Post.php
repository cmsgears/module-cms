<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\cms\common\models\base\CmsTables;

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

	// Public -----------------

	public $mParentType		= CmsGlobal::TYPE_POST;
	public $categoryType	= CmsGlobal::TYPE_POST;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use TagTrait;
	use FileTrait;
	use CommentTrait;
	use ContentTrait;
	use BlockTrait;

	// Constructor and Initialisation ------------------------------

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

	public static function queryWithAuthor() {

		$postTable 	= CmsTables::TABLE_PAGE;

		return self::find()->joinWith( 'content' )->joinWith( 'creator' )->joinWith( [ 'creator.avatar'  => function ( $query ) {
			$fileTable	= CoreTables::TABLE_FILE;
			$query->from( "$fileTable avatar" ); }
		]);
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}

?>