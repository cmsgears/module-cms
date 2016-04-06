<?php
namespace cmsgears\cms\common\services\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\models\resources\Category;

/**
 * The class CategoryService is base class to perform database activities for Category Entity.
 */
class CategoryService extends \cmsgears\core\common\services\resources\CategoryService {

	// Static Methods ----------------------------------------------

	// Read ----------------

	// Read - Models ---

	public static function findById( $id ) {

		return Category::findById( $id );
	}

	public static function findByParentId( $id ) {

		return Category::findByParentId( $id );
	}

	public static function getFeatured() {

		return Category::findAll( [ 'featured' => 1 ] );
	}

	public static function findByName( $name ) {

		return Category::findByName( $name );
	}

	public static function findBySlug( $slug ) {

		return Category::findBySlug( $slug );
	}

	public static function findByType( $type ) {

		return Category::findByType( $type );
    }

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Category(), $config );
	}
}

?>