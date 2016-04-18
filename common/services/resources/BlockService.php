<?php
namespace cmsgears\cms\common\services\resources;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\forms\BlockElement;
use cmsgears\core\common\models\entities\ObjectData;
use cmsgears\cms\common\models\base\CmsTables;
use cmsgears\cms\common\models\resources\Block;

use cmsgears\core\common\services\resources\FileService;

use cmsgears\core\common\utilities\SortUtil;

class BlockService extends \cmsgears\core\common\services\base\Service {

	// Static Methods ----------------------------------------------

	// Read ----------------

	/**
	 * @param integer $id
	 * @return Block
	 */
	public static function findById( $id ) {

		return Block::findById( $id );
	}

	/**
	 * @param string $name
	 * @return Block
	 */
    public static function findByName( $name ) {

		return Block::findByName( $name );
    }

	/**
	 * @param string $slug
	 * @return Block
	 */
    public static function findBySlug( $slug ) {

		return Block::findBySlug( $slug );
    }

	/**
	 * @return array - of all block ids
	 */
	public static function getIdList() {

		return self::findList( 'id', CmsTables::TABLE_BLOCK );
	}

	/**
	 * @return array - having block id, name as sub array
	 */
	public static function getIdNameList() {

		return self::findIdNameList( 'id', 'name', CmsTables::TABLE_BLOCK );
	}

	public static function getElements( $block, $associative = false ) {

		$objectData		= $block->generateObjectFromJson();
		$elements		= [];
		$blockElements	= [];
		$elementObjects	= [];

		if( isset( $objectData->elements ) ) {

			$elements	= $objectData->elements;
		}

		foreach ( $elements as $element ) {

			$element			= new BlockElement( $element );
			$elementObjects[]	= $element;

			if( $associative ) {

				$blockElements[ $element->elementId ]	= $element;
			}
		}

		if( $associative ) {

			return $blockElements;
		}

		return $elementObjects;
	}

	public static function getElementsForUpdate( $block, $elements ) {

		$blockElements	= self::getElements( $block, true );
		$keys			= array_keys( $blockElements );
		$elementObjects	= [];

		foreach ( $elements as $element ) {

			if( in_array( $element[ 'id' ], $keys ) ) {

				$blockElement		= $blockElements[ $element[ 'id' ] ];
				$blockElement->name	= $element[ 'name' ];
				$elementObjects[]		= $blockElement;
			}
			else {

				$blockElement				= new BlockElement();
				$blockElement->elementId	= $element[ 'id' ];
				$blockElement->name			= $element[ 'name' ];
				$elementObjects[]			= $blockElement;
			}
		}

		return $elementObjects;
	}

	// Data Provider ----

	/**
	 * @param array $config to generate query
	 * @return ActiveDataProvider
	 */
	public static function getPagination( $config = [] ) {

		return self::getDataProvider( new Block(), $config );
	}

	// Create -----------

	/**
	 * @param Block $block
	 * @param CmgFile $banner
	 * @param CmgFile $texture
	 * @param CmgFile $video
	 * @return Block
	 */
	public static function create( $block, $banner = null, $video = null, $texture = null ) {

		if( isset( $block->templateId ) && $block->templateId <= 0 ) {

			$block->templateId = null;
		}

		FileService::saveFiles( $block, [ 'bannerId' => $banner, 'videoId' => $video, 'textureId' => $texture ] );

		// Create Block
		$block->save();

		return $block;
	}

	// Update -----------

	/**
	 * @param Block $block
	 * @param CmgFile $banner
	 * @param CmgFile $texture
	 * @param CmgFile $video
	 * @return Block
	 */
	public static function update( $block, $banner = null, $video = null, $texture = null ) {

		if( isset( $block->templateId ) && $block->templateId <= 0 ) {

			$block->templateId = null;
		}

		$blockToUpdate		= self::findById( $block->id );

		$blockToUpdate->copyForUpdateFrom( $block, [ 'templateId', 'name', 'description', 'active', 'htmlOptions', 'title', 'icon', 'content', 'data' ] );

		FileService::saveFiles( $blockToUpdate, [ 'bannerId' => $banner, 'videoId' => $video, 'textureId' => $texture ] );

		$blockToUpdate->update();

		return $blockToUpdate;
	}

	public static function updateElements( $block, $elements ) {

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

					$objectData->elements[] 	= $element;
				}
			}
		}

		$objectData->elements	= SortUtil::sortObjectArrayByNumber( $objectData->elements, 'order', true );

		$block->generateJsonFromObject( $objectData );

		$block->update();

		return true;
	}

	// Delete -----------

	/**
	 * @param Block $block
	 * @return boolean
	 */
	public static function delete( $block, $banner = null, $video = null, $texture = null ) {

		$existingBlock	= self::findById( $block->id );

		// Delete Block
		$existingBlock->delete();

		// Delete Files
		FileService::deleteFiles( [ $banner, $video, $texture ] );

		return true;
	}
}

?>