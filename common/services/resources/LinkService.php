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

use cmsgears\cms\common\services\interfaces\resources\ILinkService;

use cmsgears\core\common\services\base\ResourceService;

/**
 * LinkService provide service methods of link model.
 *
 * @since 1.0.0
 */
class LinkService extends ResourceService implements ILinkService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\resources\Link';

	public static $parentType	= CmsGlobal::TYPE_LINK;

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

	// LinkService ---------------------------

	// Data Provider ------

	public function getPage( $config = [] ) {

		$modelClass	= static::$modelClass;
		$modelTable	= $this->getModelTable();

		$pageTable = Yii::$app->factory->get( 'pageService' )->getModelTable();

		// Sorting ----------

		$sort = new Sort([
			'attributes' => [
				'id' => [
					'asc' => [ "$modelTable.id" => SORT_ASC ],
					'desc' => [ "$modelTable.id" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Id'
				],
				'page' => [
					'asc' => [ "$pageTable.name" => SORT_ASC ],
					'desc' => [ "$pageTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Page',
				],
				'name' => [
					'asc' => [ "$modelTable.name" => SORT_ASC ],
					'desc' => [ "$modelTable.name" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Name'
				],
				'url' => [
					'asc' => [ "$modelTable.url" => SORT_ASC ],
					'desc' => [ "$modelTable.url" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Url'
				],
	            'type' => [
	                'asc' => [ "$modelTable.type" => SORT_ASC ],
	                'desc' => [ "$modelTable.type" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Type'
	            ],
	            'target' => [
	                'asc' => [ "$modelTable.target" => SORT_ASC ],
	                'desc' => [ "$modelTable.target" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Target'
	            ],
	            'absolute' => [
	                'asc' => [ "$modelTable.absolute" => SORT_ASC ],
	                'desc' => [ "$modelTable.absolute" => SORT_DESC ],
	                'default' => SORT_DESC,
	                'label' => 'Absolute'
	            ],
				'blog' => [
					'asc' => [ "$modelTable.blog" => SORT_ASC ],
					'desc' => [ "$modelTable.blog" => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'Blog'
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

			$config[ 'hasOne' ] = true;
		}

		// Filters ----------

		// Params
		$type	= Yii::$app->request->getQueryParam( 'type' );
		$filter	= Yii::$app->request->getQueryParam( 'model' );

		// Filter - Type
		if( isset( $type ) ) {

			$config[ 'conditions' ][ "$modelTable.type" ] = $type;
		}

		// Filter - Model
		if( isset( $filter ) ) {

			switch( $filter ) {

				case 'target': {

					$config[ 'conditions' ][ "$modelTable.target" ] = true;

					break;
				}
				case 'absolute': {

					$config[ 'conditions' ][ "$modelTable.absolute" ] = true;

					break;
				}
				case 'blog': {

					$config[ 'conditions' ][ "$modelTable.blog" ] = true;

					break;
				}
			}
		}

		// Searching --------

		$searchCol = Yii::$app->request->getQueryParam( 'search' );

		if( isset( $searchCol ) ) {

			$search = [
				'name' => "$modelTable.name",
				'url' => "$modelTable.url"
			];

			$config[ 'search-col' ] = $search[ $searchCol ];
		}

		// Reporting --------

		$config[ 'report-col' ]	= [
			'name' => "$modelTable.name",
			'url' => "$modelTable.url",
			'target' => "$modelTable.target",
			'absolute' => "$modelTable.absolute",
			'blog' => "$modelTable.blog"
		];

		// Result -----------

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read ---------------

	// Read - Models ---

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	// Update -------------

	public function update( $model, $config = [] ) {

		$attributes = isset( $config[ 'attributes' ] ) ? $config[ 'attributes' ] : [
			'pageId', 'name', 'url', 'target', 'absolute', 'blog'
		];

		return parent::update( $model, [
			'attributes' => $attributes
		]);
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete mapping
		Yii::$app->factory->get( 'modelObjectService' )->deleteByParent( $model->id, static::$parentType );

		// Delete model
		return parent::delete( $model, $config );
	}

	// Bulk ---------------

	protected function applyBulk( $model, $column, $action, $target, $config = [] ) {

		switch( $column ) {

			case 'model': {

				switch( $action ) {

					case 'target': {

						$model->target = true;

						$model->update();

						break;
					}
					case 'absolute': {

						$model->absolute = true;

						$model->update();

						break;
					}
					case 'blog': {

						$model->blog = true;

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

	// LinkService ---------------------------

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
