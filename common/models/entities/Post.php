<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\core\common\models\entities\CategoryTrait;

class Post extends Content {

	use CategoryTrait;

	public $parentType	= CmsGlobal::CATEGORY_TYPE_POST;

	// Instance Methods --------------------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function find() {

		return parent::find()->where( [ 'page_type' => Page::TYPE_POST ] );
	}

	// Post ------------------------------

	public static function blogQuery() {
		
		$postTable = CmsTables::TABLE_PAGE;
		
		return self::find()->joinWith( 'author' )->joinWith( 'author.avatar' )->joinWith( 'bannerWithAlias' )->joinWith( 'categories' )
							 ->where( [ "$postTable.type" => Page::TYPE_POST, "$postTable.status" => Content::STATUS_PUBLISHED, "$postTable.visibility" => Content::VISIBILITY_PUBLIC ] );
	}

	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}

	public static function findByAuthorId( $id ) {

		return self::find()->where( 'authorId=:id', [ ':id' => $id ] )->all();
	}

	public static function findByCategoryName( $name ) {

		return self::find()->joinWith( 'categories' )->where( 'name=:name', [ ':name' => $name ] )->all();
	}
}

?>