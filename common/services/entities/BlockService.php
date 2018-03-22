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

use cmsgears\cms\common\models\forms\BlockElement;
use cmsgears\cms\common\models\mappers\ModelBlock;

use cmsgears\cms\common\services\interfaces\entities\IBlockService;

use cmsgears\core\common\services\entities\ObjectDataService;

use cmsgears\core\common\utilities\DataUtil;

/**
 * BlockService provide service methods of block model.
 *
 * @since 1.0.0
 */
class BlockService extends ObjectDataService implements IBlockService {

	// Variables ---------------------------------------------------

	// Globals -------------------------------

	// Constants --------------

	// Public -----------------

	public static $modelClass	= '\cmsgears\cms\common\models\entities\Block';

	public static $parentType	= CmsGlobal::TYPE_BLOCK;

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

	// BlockService --------------------------

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
				],
				'cdate' => [
					'asc' => [ 'createdAt' => SORT_ASC ],
					'desc' => ['createdAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'cdate',
				],
				'udate' => [
					'asc' => [ 'modifiedAt' => SORT_ASC ],
					'desc' => ['modifiedAt' => SORT_DESC ],
					'default' => SORT_DESC,
					'label' => 'udate',
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

		return parent::getPage( $config );
	}

	// Read ---------------

	// Read - Models ---

	public function getElements( $model, $associative = false ) {

		$objectData		= $model->generateObjectFromJson();
		$elements		= [];
		$modelElements	= [];
		$elementObjects	= [];

		if( isset( $objectData->elements ) ) {

			$elements	= $objectData->elements;
		}

		foreach ( $elements as $element ) {

			$element			= new BlockElement( $element );
			$elementObjects[]	= $element;

			if( $associative ) {

				$modelElements[ $element->elementId ]	= $element;
			}
		}

		if( $associative ) {

			return $modelElements;
		}

		return $elementObjects;
	}

	public function getElementsForUpdate( $model, $elements ) {

		$modelElements	= self::getElements( $model, true );
		$keys			= array_keys( $modelElements );
		$elementObjects	= [];

		foreach ( $elements as $element ) {

			if( in_array( $element[ 'id' ], $keys ) ) {

				$modelElement		= $modelElements[ $element[ 'id' ] ];
				$modelElement->name	= $element[ 'name' ];
				$elementObjects[]		= $modelElement;
			}
			else {

				$modelElement				= new BlockElement();
				$modelElement->elementId	= $element[ 'id' ];
				$modelElement->name			= $element[ 'name' ];
				$elementObjects[]			= $modelElement;
			}
		}

		return $elementObjects;
	}

	// Read - Lists ----

	// Read - Maps -----

	// Read - Others ---

	// Create -------------

	public function create( $model, $config = [] ) {

		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$texture	= isset( $config[ 'texture' ] ) ? $config[ 'texture' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'textureId' => $texture, 'videoId' => $video ] );

		return parent::create( $model, $config );
	}

	// Update -------------

	public function update( $model, $config = [] ) {

		$banner		= isset( $config[ 'banner' ] ) ? $config[ 'banner' ] : null;
		$texture	= isset( $config[ 'texture' ] ) ? $config[ 'texture' ] : null;
		$video		= isset( $config[ 'video' ] ) ? $config[ 'video' ] : null;

		$this->fileService->saveFiles( $model, [ 'bannerId' => $banner, 'textureId' => $texture, 'videoId' => $video ] );

		return parent::update( $model, [
			'attributes' => [ 'templateId', 'bannerId', 'textureId', 'videoId', 'name', 'description', 'active', 'htmlOptions', 'title', 'icon', 'content', 'data' ]
		]);
	}

	public function updateElements( $block, $elements ) {

		$block		= self::findById( $block->id );
		$objectData	= $block->generateObjectFromJson();

		// Clear all existing mappings
		$objectData->elements	= [];

		// Add Page Links
		if( isset( $elements ) && count( $elements ) > 0 ) {

			foreach ( $elements as $element ) {

				if( $element->element ) {

					if( !isset( $element->order ) || strlen( $element->order ) == 0 ) {

						$element->order	= 0;
					}

					$objectData->elements[]		= $element;
				}
			}
		}

		$objectData->elements	= DataUtil::sortObjectArrayByNumber( $objectData->elements, 'order', true );

		$block->generateJsonFromObject( $objectData );

		$block->update();

		return true;
	}

	// Delete -------------

	public function delete( $model, $config = [] ) {

		// Delete files
		$this->fileService->deleteFiles( [ $model->banner, $model->texture, $model->video ] );

		// Delete mappings
		ModelBlock::deleteByModelId( $model->id );

		// Delete model
		return parent::delete( $model, $config );
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

	// Bulk ---------------

	// Notifications ------

	// Cache --------------

	// Additional ---------

	// Static Methods ----------------------------------------------

	// CMG parent classes --------------------

	// BlockService --------------------------

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
