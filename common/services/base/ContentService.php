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

use cmsgears\core\common\models\resources\ModelComment;

use cmsgears\cms\common\services\interfaces\base\IContentService;

use cmsgears\core\common\services\base\EntityService;

use cmsgears\core\common\services\traits\base\ApprovalTrait;
use cmsgears\core\common\services\traits\resources\DataTrait;
use cmsgears\core\common\services\traits\base\MultiSiteTrait;
use cmsgears\core\common\services\traits\base\NameTypeTrait;
use cmsgears\core\common\services\traits\base\SlugTypeTrait;
use cmsgears\core\common\services\traits\cache\GridCacheTrait;

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

	use ApprovalTrait;
	use DataTrait;
	use GridCacheTrait;
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

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$contentTable	= Yii::$app->factory->get( 'modelContentService' )->getModelTable();
		$templateTable	= Yii::$app->factory->get( 'templateService' )->getModelTable();

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
					'asc' => [ "$templateTable.name" => SORT_ASC ],
					'desc' => [ "$templateTable.name" => SORT_DESC ],
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
	            'type' => [
	                'asc' => [ "$modelTable.type" => SORT_ASC ],
	                'desc' => [ "$modelTable.type" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
	            'icon' => [
	                'asc' => [ "$modelTable.icon" => SORT_ASC ],
	                'desc' => [ "$modelTable.icon" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Icon'
	            ],
				'title' => [
					'asc' => [ "$modelTable.title" => SORT_ASC ],
					'desc' => [ "$modelTable.title" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Title'
				],
				'status' => [
					'asc' => [ "$modelTable.status" => SORT_ASC ],
					'desc' => [ "$modelTable.status" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Status'
				],
				'visibility' => [
					'asc' => [ "$modelTable.visibility" => SORT_ASC ],
					'desc' => [ "$modelTable.visibility" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Visibility'
				],
				'order' => [
					'asc' => [ "$modelTable.order" => SORT_ASC ],
					'desc' => [ "$modelTable.order" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Order'
				],
				'pinned' => [
					'asc' => [ "$modelTable.pinned" => SORT_ASC ],
					'desc' => [ "$modelTable.pinned" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Pinned'
				],
				'featured' => [
					'asc' => [ "$modelTable.featured" => SORT_ASC ],
					'desc' => [ "$modelTable.featured" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Featured'
				],
				'cdate' => [
					'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
					'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Created At'
				],
				'udate' => [
					'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
					'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
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

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'query' ] = $modelClass::queryWithContent();
		}

		// Filters ----------

		// Params
		$type	= Yii::$app->request->getQueryParam( 'type' );
		$status	= Yii::$app->request->getQueryParam( 'status' );
		$filter	= Yii::$app->request->getQueryParam( 'model' );

		// Filter - Type
		if( isset( $type ) ) {

			$config[ 'conditions' ][ "$modelTable.type" ] = $type;
		}

		// Filter - Status
		if( isset( $status ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'pinned': {

					$config[ 'conditions' ][ "$modelTable.pinned" ] = true;

					break;
				}
				case 'featured': {

					$config[ 'conditions' ][ "$modelTable.featured" ] = true;

					break;
				}
			}
		}

		// Searching --------

		$searchCol = Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'name' => "$modelTable.name",
				'title' => "$modelTable.title",
				'desc' => "$modelTable.description",
				'summary' => "modelContent.summary",
				'content' => "modelContent.content"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'summary' => "modelContent.summary",
			'content' => "modelContent.content",
			'status' => "$modelTable.status",
			'visibility' => "$modelTable.visibility",
			'order' => "$modelTable.order",
			'pinned' => "$modelTable.pinned",
			'featured' => "$modelTable.featured"
		];

		// Result -----------

		return parent::getPage( $config );
	}

	public function getPageByType( $type, $config = [] ) {

		$modelTable = $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.type" ] = $type;

		return $this->getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getWithContent( $id, $slug = null ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		if( isset( $slug ) ) {

			return $modelClass::queryWithContent( [ 'conditions' => [ "$modelTable.slug" => $slug ] ] )->one();
		}

		return $modelClass::queryWithContent( [ 'conditions' => [ "$modelTable.id" => $id ] ] )->one();
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'status': {

				switch( $action ) {

					case 'confirmed': {

						$this->confirm( $model );

						break;
					}
					case 'rejected': {

						$this->reject( $model );

						break;
					}
					case 'active': {

						$this->approve( $model );

						break;
					}
					case 'frozen': {

						$this->freeze( $model );

						break;
					}
					case 'blocked': {

						$this->block( $model );

						break;
					}
					case 'terminated': {

						$this->terminate( $model );

						break;
					}
				}

				break;
			}
			case 'model': {

				switch( $action ) {

					case 'pinned': {

						$model->pinned = true;

						$model->update();

						break;
					}
					case 'featured': {

						$model->featured = true;

						$model->update();

						break;
					}
					case 'delete': {

						$this->delete( $model );

						break;
					}
				}

				break;
			}
		}
	}

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public static function findPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $modelClass::tableName();

		$contentTable	= Yii::$app->factory->get( 'modelContentService' )->getModelTable();
		$templateTable	= Yii::$app->factory->get( 'templateService' )->getModelTable();

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
					'template' => [
						'asc' => [ "$templateTable.name" => SORT_ASC ],
						'desc' => [ "$templateTable.name" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Template',
					],
					'cdate' => [
						'asc' => [ "$modelTable.createdAt" => SORT_ASC ],
						'desc' => [ "$modelTable.createdAt" => SORT_DESC ],
						'default' => SORT_DESC,
						'label' => 'Created At'
					],
					'udate' => [
						'asc' => [ "$modelTable.modifiedAt" => SORT_ASC ],
						'desc' => [ "$modelTable.modifiedAt" => SORT_DESC ],
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

			$config[ 'sort' ] = $sort;
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

		$modelClass	= static::$modelClass;
		$modelTable	= $modelClass::tableName();
		$parentType	= static::$parentType;

		// Search
		if( $searchContent && isset( $keywords ) ) {

			$cache = CacheProperties::getInstance()->isCaching();

			// Search in model cache - full search
			if( $cache ) {

				$config[ 'search-col' ][] = "$modelTable.gridCache";
			}
			// Search in model content only
			else {

				// Search Query
				$config[ 'query' ] = isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::queryWithAll( [ 'relations' => [ 'modelContent', 'modelContent.template' ] ] );

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

			$commentTable	= Yii::$app->factory->get( 'modelCommentService' )->getModelTable();
			$approved		= ModelComment::STATUS_APPROVED;

			$query->leftJoin( $commentTable,
				"$commentTable.parentId=$modelTable.id AND $commentTable.parentType='$parentType' AND
				$commentTable.type='$type' AND $commentTable.status=$approved" );
		}

		// Option Filters
		if( count( $optionFilters ) > 0 ) {

			$query			= $config[ 'query' ];
			$optionTable	= Yii::$app->factory->get( 'optionService' )->getModelTable();
			$mOptionTable	= Yii::$app->factory->get( 'modelOptionService' )->getModelTable();

			foreach( $optionFilters as $key => $option ) {

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
