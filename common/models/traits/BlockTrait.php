<?php
namespace cmsgears\cms\common\models\traits;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\ModelBlock;

/**
 * BlockTrait can be used to form page using blocks.
 */
trait BlockTrait {

	/**
	 * @return array - ModelBlock associated with parent
	 */
	public function getModelBlocks() {

    	return $this->hasMany( ModelBlock::className(), [ 'parentId' => 'id' ] )
					->where( "parentType='$this->parentType'" );
	}

	/**
	 * @return array - Block associated with parent
	 */
	public function getBlocks() {

    	return $this->hasMany( Block::className(), [ 'id' => 'blockId' ] )
					->viaTable( CmsTables::TABLE_MODEL_BLOCK, [ 'parentId' => 'id' ], function( $query ) {

						$modelCategory	= CoreTables::TABLE_MODEL_BLOCK;

                      	$query->onCondition( [ "$modelCategory.parentType" => $this->parentType ] );
					});
	}
}

?>