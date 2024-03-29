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

use cmsgears\core\common\services\traits\base\ApprovalTrait;
use cmsgears\core\common\services\traits\base\FeaturedTrait;
use cmsgears\core\common\services\traits\base\MultiSiteTrait;
use cmsgears\core\common\services\traits\base\NameTypeTrait;
use cmsgears\core\common\services\traits\base\SlugTypeTrait;
use cmsgears\core\common\services\traits\base\VisibilityTrait;
use cmsgears\core\common\services\traits\cache\GridCacheTrait;
use cmsgears\core\common\services\traits\resources\DataTrait;
use cmsgears\core\common\services\traits\resources\VisualTrait;

/**
 * ContentService is base service of page and post.
 *
 * @since 1.0.0
 */
abstract class ContentService extends \cmsgears\core\common\services\base\EntityService implements IContentService {

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

	use DataTrait;
	use FeaturedTrait;
	use GridCacheTrait;
	use MultiSiteTrait;
	use NameTypeTrait;
	use SlugTypeTrait;
	use VisibilityTrait;
	use VisualTrait;

	use ApprovalTrait {

		activate as baseActivate;
	}

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// ContentService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$searchParam	= $config[ 'search-param' ] ?? 'keywords';
		$searchColParam	= $config[ 'search-col-param' ] ?? 'search';

		$defaultSort = isset( $config[ 'defaultSort' ] ) ? $config[ 'defaultSort' ] : [ 'id' => SORT_DESC ];

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

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
				'popular' => [
					'asc' => [ "$modelTable.popular" => SORT_ASC ],
					'desc' => [ "$modelTable.popular" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Popular'
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
					'asc' => [ "modelContent.publishedAt" => SORT_ASC ],
					'desc' => [ "modelContent.publishedAt" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Published At'
				]
			],
			'defaultOrder' => $defaultSort
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
		if( isset( $status ) && empty( $config[ 'conditions' ][ "$modelTable.status" ] ) && isset( $modelClass::$urlRevStatusMap[ $status ] ) ) {

			$config[ 'conditions' ][ "$modelTable.status" ]	= $modelClass::$urlRevStatusMap[ $status ];
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'pinned': {

					if( empty( $config[ 'conditions' ][ "$modelTable.pinned" ] ) ) {

						$config[ 'conditions' ][ "$modelTable.pinned" ] = true;
					}

					break;
				}
				case 'featured': {

					if( empty( $config[ 'conditions' ][ "$modelTable.featured" ] ) ) {

						$config[ 'conditions' ][ "$modelTable.featured" ] = true;
					}

					break;
				}
				case 'popular': {

					if( empty( $config[ 'conditions' ][ "$modelTable.popular" ] ) ) {

						$config[ 'conditions' ][ "$modelTable.popular" ] = true;
					}

					break;
				}
			}
		}

		// Searching --------

		$searchCol		= Yii::$app->request->getQueryParam( $searchColParam );
		$keywordsCol	= Yii::$app->request->getQueryParam( $searchParam );

		$search = [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'summary' => "modelContent.summary",
			'content' => "modelContent.content"
		];

		if( isset( $searchCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search[ $searchCol ];
		}
		else if( isset( $keywordsCol ) ) {

			$config[ 'search-col' ] = $config[ 'search-col' ] ?? $search;
		}

		// Reporting --------

		$config[ 'report-col' ]	= $config[ 'report-col' ] ?? [
			'name' => "$modelTable.name",
			'title' => "$modelTable.title",
			'desc' => "$modelTable.description",
			'summary' => "modelContent.summary",
			'content' => "modelContent.content",
			'status' => "$modelTable.status",
			'visibility' => "$modelTable.visibility",
			'order' => "$modelTable.order",
			'pinned' => "$modelTable.pinned",
			'featured' => "$modelTable.featured",
			'popular' => "$modelTable.popular"
		];

		// Result -----------

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getWithContentById( $id, $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$config[ 'conditions' ][ "$modelTable.id" ]	= $id;

		return $modelClass::queryWithContent( $config )->one();
	}

	/**
	 * It assumes that the slug is unique irrespective of the model type.
	 *
	 * @param string $slug
	 * @param array $config
	 * @return \cmsgears\core\common\models\base\ActiveRecord
	 */
	public function getWithContentBySlug( $slug, $config = [] ) {

		$siteId		= isset( $config[ 'siteId' ] ) ? $config[ 'siteId' ] : Yii::$app->core->siteId;
		$ignoreSite	= isset( $config[ 'ignoreSite' ] ) ? $config[ 'ignoreSite' ] : false;

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		if( $modelClass::isMultiSite() && !$ignoreSite ) {

			$config[ 'conditions' ][ "$modelTable.siteId" ]	= $siteId;
		}

		$config[ 'conditions' ][ "$modelTable.slug" ] = $slug;

		return $modelClass::queryWithContent( $config )->one();
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function activate( $model, $config = [] ) {

		$content = $model->modelContent;

		if( isset( $content ) && empty( $content->publishedAt ) ) {

			Yii::$app->factory->get( 'modelContentService' )->publish( $content );
		}

		return $this->baseActivate( $model, $config );
	}

	// Delete -------------

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		$direct = isset( $config[ 'direct' ] ) ? $config[ 'direct' ] : false; // Trigger direct notifications
		$users	= isset( $config[ 'users' ] ) ? $config[ 'users' ] : []; // Trigger user notifications

		switch( $column ) {

			case 'status': {

				switch( $action ) {

					case 'accept': {

						$this->accept( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'confirm': {

						$this->confirm( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'approve': {

						$this->approve( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'reject': {

						$this->reject( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'activate': {

						$this->activate( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'freeze': {

						$this->freeze( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'block': {

						$this->block( $model, [ 'direct' => $direct, 'users' => $users ] );

						break;
					}
					case 'terminate': {

						$this->terminate( $model, [ 'direct' => $direct, 'users' => $users ] );

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
					case 'popular': {

						$model->popular = true;

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

	/**
	 * Generate search query using tag and category tables.
	 */
	public static function findPageForSearch( $config = [] ) {

		// Search
		$searchContent	= isset( $config[ 'searchContent' ] ) ? $config[ 'searchContent' ] : false;
		$searchParam	= isset( $config[ 'search-param' ] ) ? $config[ 'search-param' ] : 'keywords';

		$keywords = Yii::$app->request->getQueryParam( $searchParam );

		// Sort
		$ratingComment	= isset( $config[ 'ratingComment' ] ) ? $config[ 'ratingComment' ] : false;
		$ratingReview	= isset( $config[ 'ratingReview' ] ) ? $config[ 'ratingReview' ] : false;

		// Filters
		$optionFilters = isset( $config[ 'optionFilters' ] ) ? $config[ 'optionFilters' ] : [];

		// Public
		$config[ 'public' ] = true;

		$modelClass	= static::$modelClass;
		$modelTable	= $modelClass::tableName();
		$parentType	= static::$parentType;

		// Search
		if( $searchContent && isset( $keywords ) ) {

			$cache = CacheProperties::getInstance()->isCaching();

			// Search in model cache - full text search
			if( $cache ) {

				$config[ 'search-col' ][] = "$modelTable.gridCache";
			}
			// Search in model content only
			else {

				// Search Query
				$config[ 'query' ] = isset( $config[ 'query' ] ) ? $config[ 'query' ] : $modelClass::queryWithAll( [ 'relations' => [ 'modelContent', 'modelContent.template' ] ] );

				// Search in model content
				$config[ 'search-col' ] = [ 'modelContent.content' ];
			}
		}

		// Sort
		$sortParam	= Yii::$app->request->get( 'sort' );
		$sortParam	= preg_replace( '/-/', '', $sortParam );

		// Sort using ModelComment Table
		if( ( $ratingComment || $ratingReview ) && $sortParam == 'rating' ) {

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

			$query = $config[ 'query' ];

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
