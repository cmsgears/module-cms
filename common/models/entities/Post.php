<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\Category;

class Post extends Content {

	// Instance Methods --------------------------------------------

	public function getCategories() {

    	return $this->hasMany( Category::className(), [ 'id' => 'categoryId' ] )
					->viaTable( CMSTables::TABLE_POST_CATEGORY, [ 'pageId' => 'id' ] );
	}

	public function getCategoriesMap() {

    	return $this->hasMany( PostCategory::className(), [ 'pageId' => 'id' ] );
	}

	public function getCategoriesIdList() {

    	$categories 		= $this->categoriesMap;
		$categoriesList		= array();

		foreach ( $categories as $category ) {

			array_push( $categoriesList, $category->id );
		}

		return $categoriesList;
	}

	public function getCategoriesIdNameMap() {

		$categories 	= $this->categories;
		$categoriesMap	= array();

		foreach ( $categories as $category ) {

			$categoriesMap[] = [ 'id' => $category->id, 'name' => $category->name ];
		}

		return $categoriesMap;
	}

	// Static Methods ----------------------------------------------

	// yii\db\ActiveRecord ---------------

	public static function find() {

		return parent::find()->where( [ 'page_type' => Page::TYPE_POST ] );
	}

	// Post ------------------------------

	public static function blogQuery() {

		return self::find()->joinWith('author')->joinWith('author.avatarId')->joinWith('bannerWithAlias')->joinWith('categories')->joinWith('categories.categoryId')
							 ->where( [ 'type' => Page::TYPE_POST, 'status' => Content::STATUS_PUBLISHED, 'visibility' => Content::VISIBILITY_PUBLIC ] );
	}

	public static function findBySlug( $slug ) {

		return self::find()->where( 'page_slug=:slug', [ ':slug' => $slug ] )->one();
	}

	public static function findByCategoryName( $name ) {

		return self::find()->joinWith( 'categories' )->where( 'name=:name', [ ':name' => $name ] )->all();
	}
}

?>