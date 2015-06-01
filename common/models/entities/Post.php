<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\traits\CategoryTrait;
use cmsgears\core\common\models\traits\TagTrait;

class Post extends Content {

	use CategoryTrait;

	public $categoryType	= CmsGlobal::TYPE_POST;

	use TagTrait;

	public $tagType			= CmsGlobal::TYPE_POST;

	// Instance Methods --------------------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

    /**
     * @inheritdoc
     */
	public static function find() {
		
		$postTable = CmsTables::TABLE_PAGE;

		return parent::find()->where( [ "$postTable.type" => Page::TYPE_POST ] );
	}

	// Post ------------------------------

	/**
	 * @return array - Post - All posts having author details.
	 */
	public static function findWithAuthor() {

		$postTable = CmsTables::TABLE_PAGE;

		return self::find()->joinWith( 'banner' )->joinWith( 'author' )->joinWith( 'author.avatar' );
	}

	/**
	 * @return Post - by slug.
	 */
	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}
}

?>