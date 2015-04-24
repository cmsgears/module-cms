<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\CmgEntity;

class PostCategory extends CmgEntity {

	// Instance Methods --------------------------------------------

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function tableName() {

		return CmsTables::TABLE_POST_CATEGORY;
	}

	// PostCategory ----------------------

	// Delete

	public static function deleteByPostId( $postId ) {

		self::deleteAll( 'postId=:id', [ ':id' => $postId ] );
	}

	public static function deleteByCategoryId( $categoryId ) {

		self::deleteAll( 'categoryId=:id', [ ':id' => $categoryId ] );
	}
}

?>