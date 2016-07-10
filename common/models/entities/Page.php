<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\resources\CommentTrait;
use cmsgears\core\common\models\traits\mappers\FileTrait;
use cmsgears\cms\common\models\traits\resources\ContentTrait;
use cmsgears\cms\common\models\traits\mappers\BlockTrait;

class Page extends Content {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	public $mParentType	= CmsGlobal::TYPE_PAGE;

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

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

	// Page ----------------------------------

	// Static Methods ----------------------------------------------

	// Yii parent classes --------------------

	// yii\db\ActiveRecord ----

    /**
     * @inheritdoc
     */
	public static function find() {

		$pageTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$pageTable.type" => CmsGlobal::TYPE_PAGE ] );
	}

	// CMG parent classes --------------------

	// Page ----------------------------------

	// Read - Query -----------

	public static function queryWithAll( $config = [] ) {

		$relations				= isset( $config[ 'relations' ] ) ? $config[ 'relations' ] : [ 'modelContent' ];
		$config[ 'relations' ]	= $relations;

		return parent::queryWithAll( $config );
	}

	public static function queryWithContent( $config = [] ) {

		$config[ 'relations' ]	= [ 'modelContent' ];

		return parent::queryWithAll( $config );
	}

	// Read - Find ------------

	// Create -----------------

	// Update -----------------

	// Delete -----------------
}
