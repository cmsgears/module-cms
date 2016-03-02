<?php
namespace cmsgears\cms\common\models\traits;

use cmsgears\cms\common\models\entities\CmsTables;
use cmsgears\cms\common\models\entities\ModelContent;

/**
 * ContentTrait can be used to add seo optimised content to relevant models to form public pages.
 */
trait ContentTrait {

	/**
	 * @return ModelContent associated with parent.
	 */
	public function getContent() {

		$modelTagTable	= CmsTables::TABLE_MODEL_CONTENT;

    	return $this->hasOne( ModelContent::className(), [ 'parentId' => 'id' ] )
					->where( "$modelTagTable.parentType='$this->parentType'" );
	}

	public function getTemplateViewPath() {

		$content	= $this->content;
		$template	= $content->template;

		return $template->viewPath;
	}
}

?>