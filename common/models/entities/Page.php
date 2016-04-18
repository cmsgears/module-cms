<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\FileTrait;
use cmsgears\core\common\models\traits\CommentTrait;
use cmsgears\cms\common\models\traits\ContentTrait;
use cmsgears\cms\common\models\traits\BlockTrait;

class Page extends Content {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	public $parentType	= CmsGlobal::TYPE_PAGE;

	// Private/Protected --

	// Traits ------------------------------------------------------

	use FileTrait;
	use CommentTrait;
	use ContentTrait;
	use BlockTrait;

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

	// Page ------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function find() {

		$pageTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$pageTable.type" => CmsGlobal::TYPE_PAGE ] );
	}

	// Page ------------------------------

	// Create -------------

	// Read ---------------

	/**
	 * @return Page - by slug
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug AND siteId=:siteId', [ ':slug' => $slug, ':siteId' => Yii::$app->cmgCore->siteId ] )->one();
	}

	// Update -------------

	// Delete -------------
}

?>