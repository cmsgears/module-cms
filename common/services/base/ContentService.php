<?php
namespace cmsgears\cms\common\services\base;

// Yii Imports
use \Yii;

use yii\db\Query;
use yii\data\ActiveDataProvider;

use yii\helpers\HtmlPurifier;
use yii\helpers\ArrayHelper;

// CMG Imports
use cmsgears\core\common\models\base\CoreTables;
use cmsgears\cms\common\models\base\CmsTables;

/**
 * The class Service defines several useful methods used for pagination and generating map and list by specifying the columns.
 */
abstract class ContentService extends \cmsgears\core\common\services\base\OService {

	// Variables ---------------------------------------------------

	// Constants/Statics --

	// Public -------------

	// Private/Protected --

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance Methods --------------------------------------------

	// OService --------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create ----------------

	// Update ----------------

	// Delete ----------------

	// Static Methods ----------------------------------------------

	// < parent class > ------------------

	// <Service> -------------------------

	// Data Provider ------

	public static function findPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable 	= static::$modelTable;

		$contentTable 	= CmsTables::TABLE_MODEL_CONTENT;

	    $sort = new Sort([
	        'attributes' => [
	            'id' => [
	                'asc' => [ "$modelTable.id" => SORT_ASC ],
	                'desc' => [ "$modelTable.id" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Id'
	            ],
	            'cdate' => [
	                'asc' => [ "$contentTable.createdAt" => SORT_ASC ],
	                'desc' => [ "$contentTable.createdAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Created At',
	            ],
	            'pdate' => [
	                'asc' => [ "$contentTable.publishedAt" => SORT_ASC ],
	                'desc' => [ "$contentTable.publishedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Published At',
	            ],
	            'udate' => [
	                'asc' => [ "$contentTable.updatedAt" => SORT_ASC ],
	                'desc' => [ "$contentTable.updatedAt" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Updated At',
	            ]
	        ]
	    ]);

		if( !isset( $config[ 'query' ] ) ) {

			$modelClass 		= static::$modelClass;

			$config[ 'query' ] 	= $modelClass::queryWithAll();
		}

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		if( !isset( $config[ 'search-col' ] ) ) {

			$config[ 'search-col' ] = 'name';
		}

		return self::findDataProvider( $modelClass, $config );
	}

	/**
	 * Generate search query using content, tag and category tables.
	 */
	public static function findPageForSearch( $config = [] ) {

		$modelClass			= static::$modelClass;
		$modelTable 		= static::$modelTable;
		$parentType			= static::$parentType;

		// DB Tables
		$contentTable		= CmsTables::TABLE_MODEL_CONTENT;
		$mcategoryTable		= CoreTables::TABLE_MODEL_CATEGORY;
		$categoryTable		= CoreTables::TABLE_CATEGORY;
		$mtagTable			= CoreTables::TABLE_MODEL_TAG;
		$tagTable			= CoreTables::TABLE_TAG;

		// Search Query
		$query			 	= $modelClass::queryWithAll()->joinWith( 'content' );

		// Tag
		if( isset( $search ) || isset( $config[ 'tag' ] ) ) {

			$query->leftJoin( $mtagTable, "$modelTable.id=$mtagTable.parentId AND $mtagTable.parentType='$parentType' AND $mtagTable.active=TRUE" )
				->leftJoin( $tagTable, "$mtagTable.tagId=$tagTable.id" );
		}

		if( isset( $config[ 'tag' ] ) ) {

			$query->andWhere( "$tagTable.id=" . $config[ 'tag' ]->id );
		}

		// Category
		if( isset( $search ) || isset( $config[ 'category' ] ) ) {

			$query->leftJoin( "$mcategoryTable", "$modelTable.id=$mcategoryTable.parentId AND $mcategoryTable.parentType='$parentType' AND $mcategoryTable.active=TRUE" )
				->leftJoin( "$categoryTable", "$mcategoryTable.categoryId=$categoryTable.id" );
		}

		if( isset( $config[ 'category' ] ) ) {

			$query->andWhere( "$categoryTable.id=" . $config[ 'category' ]->id );
		}

		// Search
		$search 	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $search ) ) {

			$config[ 'search-col' ]	= [ "$contentTable.content", "$categoryTable.name", "$tagTable.name" ];
		}

		if( isset( $search ) || isset( $config[ 'category' ] ) ) {

			$query->groupBy( "$modelTable.id" );
		}

		$config[ 'query' ]	= $query;

		return static::findPage( $config );
	}

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------
}

?>