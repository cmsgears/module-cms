<?php
namespace cmsgears\cms\common\models\traits;

use cmsgears\cms\common\models\entities\ModelBlock;

/**
 * BlockTrait can be used to form page blocks/modules.
 */
trait BlockTrait {

	/**
	 * @return array - ModelBlock associated with parent.
	 */
	public function getBlocks() {

		$parentType	= $this->blockType;

    	return $this->hasMany( ModelBlock::className(), [ 'parentId' => 'id' ] )
					->where( "parentType='$parentType'" );
	}
}

?>