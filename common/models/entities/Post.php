<?php
namespace cmsgears\modules\cms\common\models\entities;

// Yii Imports
use yii\db\ActiveRecord;

// CMG Imports
use cmsgears\modules\core\common\models\entities\Option;

class Post extends Content {

	// Instance Methods --------------------------------------------

	// db columns

	public function getCategories() {

    	return $this->hasMany( Option::className(), [ 'option_id' => 'category_id' ] )
					->viaTable( CMSTables::TABLE_POST_CATEGORY, [ 'post_id' => 'page_id' ] );
	}

	public function getCategoriesMap() {

    	return $this->hasMany( PostCategory::className(), [ 'post_id' => 'page_id' ] );
	}

	public function getCategoriesIdList() {

    	$categories 		= $this->categoriesMap;
		$categoriesList		= array();

		foreach ( $categories as $category ) {

			array_push( $categoriesList, $category->category_id );
		}

		return $categoriesList;
	}

	public function getCategoriesIdNameMap() {

		$categories 	= $this->categories;
		$categoriesMap	= array();

		foreach ( $categories as $category ) {

			$categoriesMap[] = [ 'id' => $category->getId(), 'name' => $category->getKey() ];
		}

		return $categoriesMap;
	}

	// Static Methods ----------------------------------------------

	// yii\db\BaseActiveRecord

	public static function find() {

		return parent::find()->where( [ 'page_type' => Page::TYPE_POST ] );
	}

	// Post

	public static function blogQuery() {

		return Post::find()->joinWith('author')->joinWith('author.avatar')->joinWith('bannerWithAlias')->joinWith('categories')->joinWith('categories.category')
							 ->where( [ 'page_type' => Page::TYPE_POST, 'page_status' => Content::STATUS_PUBLISHED, 'page_visibility' => Content::VISIBILITY_PUBLIC ] );
	}

	public static function findById( $id ) {

		return Post::find()->where( 'page_id=:id', [ ':id' => $id ] )->one();
	}

	public static function findBySlug( $slug ) {

		return Post::find()->where( 'page_slug=:slug', [ ':slug' => $slug ] )->one();
	}

	public static function findByName( $name ) {

		return Post::find()->where( 'page_name=:name', [ ':name' => $name ] )->one();
	}

	public static function findByCategoryName( $name ) {

		return Post::find()->joinWith( 'categories' )->where( 'option_key=:name', [ ':name' => $name ] )->all();
	}
}

?>