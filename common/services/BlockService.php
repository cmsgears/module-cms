<?php
namespace cmsgears\cms\common\services;

// Yii Imports
use \Yii;

// CMG Imports
use cmsgears\cms\common\config\CmsGlobal;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\Block;

use cmsgears\core\common\services\FileService;

class BlockService extends \cmsgears\core\common\services\Service {

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
	public static function create( $block, $banner = null, $texture = null, $video = null ) {

		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $block, 'attribute' => 'bannerId' ] );
		}

		if( isset( $texture ) ) {

			FileService::saveImage( $texture, [ 'model' => $block, 'attribute' => 'textureId' ] );
		}

		if( isset( $video ) ) {

			FileService::saveImage( $video, [ 'model' => $block, 'attribute' => 'videoId' ] );
		}

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
	public static function update( $block, $banner = null, $texture = null, $video = null ) {

		$blockToUpdate		= self::findById( $block->id );

		$blockToUpdate->copyForUpdateFrom( $block, [ 'name', 'description', 'htmlOptions', 'backgroundClass', 'textureClass', 'content' ] );

		if( isset( $banner ) ) {

			FileService::saveImage( $banner, [ 'model' => $blockToUpdate, 'attribute' => 'bannerId' ] );
		}

		if( isset( $texture ) ) {

			FileService::saveImage( $texture, [ 'model' => $blockToUpdate, 'attribute' => 'textureId' ] );
		}

		if( isset( $video ) ) {

			FileService::saveImage( $video, [ 'model' => $blockToUpdate, 'attribute' => 'videoId' ] );
		}

		$blockToUpdate->update();

		return $blockToUpdate;
	}

	// Delete -----------

	/**
	 * @param Block $block
	 * @return boolean
	 */
	public static function delete( $block ) {

		$existingBlock	= self::findById( $block->id );

		// Delete Block
		$existingBlock->delete();

		return true;
	}
}

?>