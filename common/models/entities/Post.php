<?php
namespace cmsgears\cms\common\models\entities;

// CMG Imports
use cmsgears\core\common\models\entities\Category;

class Post extends Content {

	// Instance Methods --------------------------------------------

	public function getCategories() {

    	return $this->hasMany( Category::className(), [ 'id' => 'categoryId' ] )
					->viaTable( CMSTables::TABLE_POST_CATEGORY, [ 'postId' => 'id' ] );
	}

	public function getCategoriesMap() {

    	return $this->hasMany( PostCategory::className(), [ 'postId' => 'id' ] );
	}

	public function getCategoriesIdList() {

    	$categories 		= $this->categoriesMap;
		$categoriesList		= array();

		foreach ( $categories as $category ) {

			array_push( $categoriesList, $category->categoryId );
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
		
		$postTable = CmsTables::TABLE_PAGE;
		
		return self::find()->joinWith( 'author' )->joinWith( 'author.avatar' )->joinWith( 'bannerWithAlias' )->joinWith( 'categories' )
							 ->where( [ "$postTable.type" => Page::TYPE_POST, "$postTable.status" => Content::STATUS_PUBLISHED, "$postTable.visibility" => Content::VISIBILITY_PUBLIC ] );
	}

	public static function findBySlug( $slug ) {

		return self::find()->where( 'slug=:slug', [ ':slug' => $slug ] )->one();
	}

	public static function findByCategoryName( $name ) {

		return self::find()->joinWith( 'categories' )->where( 'name=:name', [ ':name' => $name ] )->all();
	}
}

?>