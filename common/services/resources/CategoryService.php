<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\resources;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\resources\ModelContent;

use cmsgears\cms\common\services\interfaces\resources\ICategoryService;
use cmsgears\cms\common\services\interfaces\resources\IModelContentService;

/**
 * CategoryService provide service methods of category model.
 *
 * @since 1.0.0
 */
class CategoryService extends \cmsgears\core\common\services\resources\CategoryService implements ICategoryService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\resources\Category';

	// Protected --------------

	// Variables -----------------------------

	// Public -----------------

	// Protected --------------

	protected $modelContentService;

	// Private ----------------

	// Traits ------------------------------------------------------

	// Constructor and Initialisation ------------------------------

	public function __construct( IModelContentService $modelContentService, $config = [] ) {

		$this->modelContentService = $modelContentService;

		parent::__construct( $config );
	}

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// yii\base\Component -----

	// CMG interfaces ------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$searchParam	= $config[ 'search-param' ] ?? 'keywords';
		$searchColParam	= $config[ 'search-col-param' ] ?? 'search';

		$defaultSort = isset( $config[ 'defaultSort' ] ) ? $config[ 'defaultSort' ] : [ 'id' => SORT_DESC ];

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$templateTable = Yii::$app->factory->get( 'templateService' )->getModelTable();

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
					'label' => 'Template'
				],
				'parent' => [
					'asc' => [ 'parent.name' => SORT_ASC ],
					'desc' => [ 'parent.name' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Parent'
				],
				'root' => [
					'asc' => [ 'root.name' => SORT_ASC ],
					'desc' => [ 'root.name' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Root'
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
	            'order' => [
	                'asc' => [ "$modelTable.`order`" => SORT_ASC ],
	                'desc' => [ "$modelTable.`order`" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Order'
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
			'pinned' => "$modelTable.pinned",
			'featured' => "$modelTable.featured",
			'popular' => "$modelTable.popular",
			'order' => "$modelTable.order",
			'pname' => 'parent.name',
			'pdesc' => 'parent.description',
			'rname' => 'root.name',
			'rdesc' => 'root.description'
		];

		// Result -----------

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$content	= isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;
		$widgetSlug	= isset( $config[ 'widgetSlug' ] ) ? $config[ 'widgetSlug' ] : null;

		// Model content is required for all the tags to form tag page
		if( !isset( $content ) ) {

			$content = new ModelContent();
		}

		// Copy Template
		$config[ 'template' ] = $content->template;

		$this->copyTemplate( $model, $config );

		$model = parent::create( $model, $config );

		if( $model ) {

			$config[ 'parent' ]		= $model;
			$config[ 'parentType' ]	= static::$parentType;
			$config[ 'publish' ]	= isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : true;

			$this->modelContentService->create( $content, $config );

			if( isset( $widgetSlug ) ) {

				$categoryWidget = Yii::$app->factory->get( 'widgetService' )->getBySlugType( $widgetSlug, CmsGlobal::TYPE_WIDGET );

				if( isset( $categoryWidget ) ) {

					Yii::$app->factory->get( 'modelWidgetService' )->createByParams([
						'modelId' => $categoryWidget->id, 'type' => CmsGlobal::TYPE_WIDGET,
						'parentId' => $model->id, 'parentType' => static::$parentType
					]);
				}
			}
		}

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$content = isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

		$attributes = isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'name', 'slug', 'icon', 'texture', 'title',
			'description', 'htmlOptions', 'content'
		];

		// Copy Template
		if( isset( $content ) ) {

			$config[ 'template' ] = $content->template;

			if( $this->copyTemplate( $model, $config ) ) {

				$attributes[] = 'data';
			}
		}

		$model = parent::update( $model, $config );

		if( isset( $content ) ) {

			$config[ 'publish' ] = isset( $config[ 'publish' ] ) ? $config[ 'publish' ] : true;

			$this->modelContentService->update( $content, $config );
		}

		return $model;
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		$content = isset( $config[ 'content' ] ) ? $config[ 'content' ] : ( isset( $model->modelContent ) ? $model->modelContent : null );

		if( isset( $content ) ) {

			$this->modelContentService->delete( $content, $config );
		}

		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// CategoryService -----------------------

	// Data Provider ------

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	// Delete -------------

}
