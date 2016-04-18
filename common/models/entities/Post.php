<?php
namespace cmsgears\cms\common\models\entities;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\cms\common\models\base\CmsTables;

use cmsgears\core\common\models\traits\CategoryTrait;
use cmsgears\core\common\models\traits\TagTrait;
use cmsgears\core\common\models\traits\FileTrait;
use cmsgears\core\common\models\traits\CommentTrait;
use cmsgears\cms\common\models\traits\ContentTrait;
use cmsgears\cms\common\models\traits\BlockTrait;

class Post extends Content {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	public $parentType		= CmsGlobal::TYPE_POST;
	public $categoryType	= CmsGlobal::TYPE_POST;

	// Private/Protected --

	// Traits ------------------------------------------------------

	use CategoryTrait;
	use TagTrait;
	use FileTrait;
	use CommentTrait;
	use ContentTrait;
	use BlockTrait;

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// yii\base\Component ----------------

	// yii\base\Model --------------------

	// Post ------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function find() {

		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => CmsGlobal::TYPE_POST ] );
	}

	// Post ------------------------------

	// Create -------------

	// Read ---------------

	/**
	 * @return array - Post - All posts having author details.
	 */
	public static function findWithAuthor() {

		$postTable 	= CmsTables::TABLE_PAGE;

		return self::find()->joinWith( 'content' )->joinWith( 'creator' )->joinWith( [ 'creator.avatar'  => function ( $query ) {
			$fileTable	= CoreTables::TABLE_FILE;
			$query->from( "$fileTable avatar" ); }
		]);
	}

	/**
	 * @return Post - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug AND siteId=:siteId', [ ':slug' => $slug, ':siteId' => Yii::$app->cmgCore->siteId ] )->one();
	}

	// Update -------------

	// Delete -------------
}

?>