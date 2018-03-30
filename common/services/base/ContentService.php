<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\base;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\core\common\config\CacheProperties;

use cmsgears\core\common\models\resources\Option;
use cmsgears\core\common\models\resources\ModelComment;
use cmsgears\core\common\models\mappers\ModelOption;
use cmsgears\cms\common\models\resources\ModelContent;

use cmsgears\cms\common\services\interfaces\base\IContentService;

use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\services\traits\base\MultiSiteTrait;
use cmsgears\core\common\services\traits\base\NameTypeTrait;
use cmsgears\core\common\services\traits\base\SlugTypeTrait;

/**
 * ContentService is base service of page and post.
 *
 * @since 1.0.0
 */
abstract class ContentService extends EntityService implements IContentService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $typed = true;

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	// Private ----------------

	// Traits ------------------------------------------------------

	use MultiSiteTrait;
	use NameTypeTrait;
	use SlugTypeTrait;

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		// Model Class and Table
		$modelClass	= static::$modelClass;
		$modelTable = $modelClass::tableName();

		$contentTable = ModelContent::tableName();

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
				'template' => [
					'asc' => [ "$modelTable.templateId" => SORT_ASC ],
					'desc' => [ "$modelTable.templateId" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Template',
				],
				'name' => [
					'asc' => [ "$modelTable.name" => SORT_ASC ],
					'desc' => [ "$modelTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'slug' => [
					'asc' => [ "$modelTable.slug" => SORT_ASC ],
					'desc' => [ "$modelTable.slug" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Slug'
				],
				'title' => [
					'asc' => [ "$modelTable.title" => SORT_ASC ],
					'desc' => [ "$modelTable.title" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Title'
				],
				'visibility' => [
					'asc' => [ "$modelTable.visibility" => SORT_ASC ],
					'desc' => [ "$modelTable.visibility" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Visibility'
				],
				'status' => [
					'asc' => [ "$modelTable.status" => SORT_ASC ],
					'desc' => [ "$modelTable.status" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Status'
				],
				'cdate' => [
					'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
					'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Created At'
				],
				'pdate' => [
					'asc' => [ "$modelTable.publishedAt" => SORT_ASC ],
					'desc' => [ "$modelTable.publishedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Published At'
				],
				'udate' => [
					'asc' => [ "$modelTable.updatedAt" => SORT_ASC ],
					'desc' => [ "$modelTable.updatedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Updated At'
				]
			]
		]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = true;
		}

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = Post::queryWithAuthor();
		}

		// Filters ----------

		// Filter - Status
		$status	= Yii::$app->request->getQueryParam( 'status' );

		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}
		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'name' => "$modelTable.name",
				'title' => "$modelTable.title"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'summary' => "$contentTable.summary",
			'content' => "$contentTable.content"
		];

		// Result -----------

		$config[ 'conditions' ][ "$modelTable.type" ] = static::$parentType;

		return parent::getPage( $config );
	}

	public function getPageForSimilar( $config = [] ) {

		$modelClass	= static::$modelClass;

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

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public static function findPage( $config = [] ) {

		// Model Class and Table
		$modelClass	= static::$modelClass;
		$modelTable = $modelClass::tableName();

		$contentTable	= ModelContent::tableName();

		$sort = isset( $config[ 'sort' ] ) ? $config[ 'sort' ] : false;

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

		// Model Class and Table
		$modelClass	= static::$modelClass;
		$modelTable = $modelClass::tableName();
		$parentType	= static::$parentType;

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

			$commentTable	= ModelComment::tableName();
			$approved		= ModelComment::STATUS_APPROVED;

			$query->leftJoin( $commentTable,
				"$commentTable.parentId=$modelTable.id AND $commentTable.parentType='$parentType' AND
				$commentTable.type='$type' AND $commentTable.status=$approved" );
		}

		// Option Filters
		if( count( $optionFilters ) > 0 ) {

			$query			= $config[ 'query' ];
			$optionTable	= Option::tableName();
			$mOptionTable	= ModelOption::tableName();

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
