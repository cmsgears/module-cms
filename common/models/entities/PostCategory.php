<?php
namespace cmsgears\modules\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

class PostCategory extends ActiveRecord {

	// Instance Methods --------------------------------------------

	// db columns

	public function getPostId() {

		return $this->post_id;
	}

	public function setPostId( $postId ) {

		$this->post_id = $postId;
	}

	public function getCategoryId() {

		return $this->category_id;
	}

	public function setCategoryId( $categoryId ) {

		$this->category_id = $categoryId;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord

	public static function tableName() {

		return CMSTables::TABLE_POST_CATEGORY;
	}

	// Delete

	public static function deleteByPostId( $postId ) {

		self::deleteAll( 'post_id=:id', [ ':id' => $postId ] );
	}

	public static function deleteByCategoryId( $categoryId ) {

		self::deleteAll( 'category_id=:id', [ ':id' => $categoryId ] );
	}
}

?>