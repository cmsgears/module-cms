<?php
namespace cmsgears\cms\common\models\entities;

class PageMeta extends ContentMeta {

	// Instance methods --------------------------------------------------

	/**
	 * @return Page set as meta parent.
	 */
	public function getPage() {

		return $this->hasOne( Page::className(), [ 'id' => 'pageId' ] );
	}

	// Static methods --------------------------------------------------

	// PageMeta ---------------------------

}

?>