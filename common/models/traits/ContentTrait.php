<?php
namespace cmsgears\cms\common\models\traits;

use cmsgears\cms\common\models\entities\ModelContent;

/**
 * ContentTrait can be used to add seo optimised content to relevant models to form public pages.
 */
trait ContentTrait {

	/**
	 * @return ModelContent associated with parent.
	 */
	public function getContent() {

		$parentType	= $this->contentType;

    	return $this->hasOne( ModelContent::className(), [ 'parentId' => 'id' ] )
					->where( "parentType='$parentType'" );
	}
}

?>