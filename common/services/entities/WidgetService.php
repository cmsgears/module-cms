<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\cms\common\services\entities;

// Yii Imports
use Yii;
use yii\data\Sort;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\services\interfaces\entities\IWidgetService;

use cmsgears\core\common\services\entities\ObjectDataService;

/**
 * WidgetService provide service methods of widget model.
 *
 * @since 1.0.0
 */
class WidgetService extends ObjectDataService implements IWidgetService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Widget';

	public static $parentType	= CmsGlobal::TYPE_WIDGET;

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

	// ElementService ------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass		= static::$modelClass;
		$modelTable		= static::$modelTable;

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'name' => [
					'asc' => [ 'name' => SORT_ASC ],
					'desc' => ['name' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'name'
				],
				'slug' => [
					'asc' => [ 'slug' => SORT_ASC ],
					'desc' => ['slug' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'slug'
				],
				'template' => [
					'asc' => [ 'template' => SORT_ASC ],
					'desc' => ['template' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'template',
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

		// Filters ----------

		// Searching --------

		$searchCol	= Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [ 'name' => "$modelTable.name",  'title' =>  "$modelTable.title", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template" ];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name", 'slug' => "$modelTable.slug", 'template' => "$modelTable.template",  'active' => "$modelTable.active"
		];

		// Result -----------

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_WIDGET;

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getByName( $name, $first = false ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_WIDGET;

		return parent::getByName( $config );
	}

	// Read - Lists ----

	public function getIdList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_WIDGET;

		return parent::getIdList( $config );
	}

	public function getIdNameList( $config = [] ) {

		$modelTable	= static::$modelTable;

		$config[ 'conditions' ][ "$modelTable.type" ] =	 CmsGlobal::TYPE_WIDGET;

		return parent::getIdNameList( $config );
	}

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'delete': {

						$this->delete( $model );

						Yii::$app->factory->get( 'activityService' )->deleteActivity( $model, self::$parentType );

						break;
					}
				}

				break;
			}
		}
	}

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

	// ElementService ------------------------

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
