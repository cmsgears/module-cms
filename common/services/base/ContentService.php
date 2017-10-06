<?php
namespace cmsgears\cms\common\services\base;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\config\CacheProperties;

use cmsgears\core\common\models\base\CoreTables;
use cmsgears\core\common\models\resources\ModelComment;
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

	public function getPageForSimilar( $config = [] ) {

		$modelClass			= static::$modelClass;

		// Search Query - If hasOne config is passed, make sure that modelContent is listed in hasOne relationships
		$query				= isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::find()->joinWith( 'modelContent' );
		$config[ 'query' ]	= $query;

		return parent::getPageForSimilar( $config );
	}

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
		$modelTable		= static::$modelTable;

		$contentTable	= CmsTables::TABLE_MODEL_CONTENT;

		$sort			= isset( $config[ 'sort' ] ) ? $config[ 'sort' ] : false;

		if( !$sort ) {

			$sort = new Sort([
				'attributes' => [
					'id' => [
						'asc' => [ "$modelTable.id" => SORT_ASC ],
						'desc' => [ "$modelTable.id" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Id'
					],
					'rating' => [
						'asc' => [ "rating" => SORT_ASC ],
						'desc' => [ "rating" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Rating'
					],
					'cdate' => [
						'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
						'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Created At'
					],
					'udate' => [
						'asc' => [ "$modelTable.updatedAt" => SORT_ASC ],
						'desc' => [ "$modelTable.updatedAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Updated At'
					],
					'pdate' => [
						'asc' => [ "$contentTable.publishedAt" => SORT_ASC ],
						'desc' => [ "$contentTable.publishedAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Published At'
					]
				],
				'defaultOrder' => [
					'id' => SORT_DESC
				]
			]);

			$config[ 'sort' ]	= $sort;
		}

		return parent::findPage( $config );
	}

	/**
	 * Generate search query using tag and category tables.
	 */
	public static function findPageForSearch( $config = [] ) {

		// Search
		$searchContent	= isset( $config[ 'searchContent' ] ) ? $config[ 'searchContent' ] : false;
		$keywordsParam	= isset( $config[ 'search-param' ] ) ? $config[ 'search-param' ] : 'keywords';
		$keywords 		= Yii::$app->request->getQueryParam( $keywordsParam );

		// Sort
		$ratingComment	= isset( $config[ 'ratingComment' ] ) ? $config[ 'ratingComment' ] : false;
		$ratingReview	= isset( $config[ 'ratingReview' ] ) ? $config[ 'ratingReview' ] : false;

		// Filters
		$optionFilters	= isset( $config[ 'optionFilters' ] ) ? $config[ 'optionFilters' ] : [];

		$modelTable		= static::$modelTable;
		$parentType		= static::$parentType;

		// Search
		if( $searchContent && isset( $keywords ) ) {

			$cache	= CacheProperties::getInstance()->isCaching();

			// Search in model cache - full search
			if( $cache ) {

				$config[ 'search-col' ][] = "$modelTable.content";
			}
			// Search in model content cache - limited search
			else {

				// Search Query
				$modelClass			= static::$modelClass;
				$query				= isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::find()->joinWith( 'modelContent' );
				$config[ 'query' ]	= $query;

				// Search in model content
				$config[ 'search-col' ][] = 'modelContent.content';
			}
		}

		// Sort
		$sortParam	= Yii::$app->request->get( 'sort' );
		$sortParam	= preg_replace( '/-/', '', $sortParam );

		// Sort using ModelComment Table
		if( ( $ratingComment || $ratingReview ) && strcmp( $sortParam, 'rating' ) == 0 ) {

			$type	= '';
			$query	= $config[ 'query' ];

			// Sort by Rating using comments available in ModelComment table
			if( $ratingComment ) {

				$type = ModelComment::TYPE_COMMENT;
			}
			// Sort by Rating using reviews available in ModelComment table
			else if( $ratingReview ) {

				$type = ModelComment::TYPE_REVIEW;
			}

			$commentTable	= CoreTables::TABLE_MODEL_COMMENT;
			$approved		= ModelComment::STATUS_APPROVED;

			$query->leftJoin( $commentTable,
				"$commentTable.parentId=$modelTable.id AND $commentTable.parentType='$parentType' AND
				$commentTable.type='$type' AND $commentTable.status=$approved" );
		}

		// Option Filters
		if( count( $optionFilters ) > 0 ) {

			$query			= $config[ 'query' ];
			$optionTable	= CoreTables::TABLE_OPTION;
			$mOptionTable	= CoreTables::TABLE_MODEL_OPTION;

			foreach ( $optionFilters as $key => $option ) {

				$optionList = static::getOptions( $option );

				if( count( $optionList ) > 0 ) {

					$query->leftJoin( "$mOptionTable AS MC$key", "$modelTable.id=MC$key.parentId AND MC$key.parentType='$parentType'" )
						->leftJoin( "$optionTable AS O$key", "MC$key.modelId=O$key.id" )
						->andWhere( "MC$key.active=1" );

					$config[ 'filters' ][] = [ 'in', "O$key.id", $optionList ];
				}
			}
		}

		return parent::findPageForSearch( $config );
	}

	protected static function getOptions( $options ) {

		if( isset( $options ) ) {

			$options = preg_split( "/,/", $options );

			if( count( $options ) > 0 ) {

				return $options;
			}
		}

		return [];
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
