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
abstract class ContentService extends \cmsgears\core\common\services\base\EntityService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	// Read ---------------

    // Read - Models ---

    // Read - Lists ----

    // Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public static function findPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable 	= static::$modelTable;

		$contentTable 	= CmsTables::TABLE_MODEL_CONTENT;

		$sort		= isset( $config[ 'sort' ] ) ? $config[ 'sort' ] : false;

		if( !$sort ) {

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
		}

		return parent::findDataProvider( $config );
	}

	/**
	 * Generate search query using tag and category tables.
	 */
	public static function findPageForSearch( $config = [] ) {

		$modelClass			= static::$modelClass;
		$modelTable 		= static::$modelTable;
		$parentType			= static::$parentType;

		// DB Tables
		$mcategoryTable		= CoreTables::TABLE_MODEL_CATEGORY;
		$categoryTable		= CoreTables::TABLE_CATEGORY;
		$mtagTable			= CoreTables::TABLE_MODEL_TAG;
		$tagTable			= CoreTables::TABLE_TAG;

		$contentTable		= CmsTables::TABLE_MODEL_CONTENT;

		// Search Query
		$query			 	= $modelClass::queryWithAll()->joinWith( 'content' );

		// Params
		$searchParam		= isset( $config[ 'search-param' ] ) ? $config[ 'search-param' ] : 'keywords';
		$keywords 			= Yii::$app->request->getQueryParam( $searchParam );

		// Tag
		if( isset( $parentType ) && ( isset( $keywords ) || isset( $config[ 'tag' ] ) ) ) {

			$query->leftJoin( $mtagTable, "$modelTable.id=$mtagTable.parentId AND $mtagTable.parentType='$parentType' AND $mtagTable.active=TRUE" )
				->leftJoin( $tagTable, "$mtagTable.tagId=$tagTable.id" );
		}

		if( isset( $parentType ) && isset( $config[ 'tag' ] ) ) {

			$query->andWhere( "$tagTable.id=" . $config[ 'tag' ]->id );

			if( isset( $keywords ) ) {

				$config[ 'search-col' ][]	= "$tagTable.name";
			}
		}

		// Category
		if( isset( $parentType ) && ( isset( $keywords ) || isset( $config[ 'category' ] ) ) ) {

			$query->leftJoin( "$mcategoryTable", "$modelTable.id=$mcategoryTable.parentId AND $mcategoryTable.parentType='$parentType' AND $mcategoryTable.active=TRUE" )
				->leftJoin( "$categoryTable", "$mcategoryTable.categoryId=$categoryTable.id" );
		}

		if( isset( $parentType ) && isset( $config[ 'category' ] ) ) {

			$query->andWhere( "$categoryTable.id=" . $config[ 'category' ]->id );

			if( isset( $keywords ) ) {

				$config[ 'search-col' ][]	= "$categoryTable.name";
			}
		}

		if( isset( $keywords ) || isset( $config[ 'category' ] ) ) {

			$query->groupBy( "$modelTable.id" );
		}

		if( isset( $keywords ) ) {

			$config[ 'search-col' ][]	= "$contentTable.content";
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
