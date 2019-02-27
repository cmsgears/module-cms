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
use cmsgears\cms\common\models\resources\ModelContent;

use cmsgears\cms\common\services\interfaces\resources\IModelContentService;
use cmsgears\cms\common\services\interfaces\resources\ITagService;

use cmsgears\core\common\services\resources\TagService as BaseTagService;

/**
 * TagService provide service methods of tag model.
 *
 * @since 1.0.0
 */
class TagService extends BaseTagService implements ITagService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass = '\cmsgears\cms\common\models\resources\Tag';

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

	// TagService ----------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

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
			'defaultOrder' => [
				'id' => SORT_DESC
			]
		]);

		if( !isset( $config[ 'sort' ] ) ) {

			$config[ 'sort' ] = $sort;
		}

		// Query ------------

		if( !isset( $config[ 'query' ] ) ) {

			$config[ 'hasOne' ] = $modelClass::queryWithContent();
		}

		// Filters ----------

		// Searching --------

		// Reporting --------

		// Result -----------

		return parent::findPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$model = parent::create( $model, $config );

		$content = isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

		// Model content is required for all the tags to form tag page
		if( !isset( $content ) ) {

			$content = new ModelContent();
		}

		$config[ 'parent' ]		= $model;
		$config[ 'parentType' ]	= self::$parentType;

		$this->modelContentService->create( $content, $config );

		return $model;
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$model = parent::update( $model, $config );

		$content = isset( $config[ 'content' ] ) ? $config[ 'content' ] : null;

		if( isset( $content ) ) {

			$config[ 'publish' ] = true;

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

	// TagService ----------------------------

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
