<?php
namespace cmsgears\cms\common\models\entities;

class PostMeta extends ContentMeta {

	// Instance methods --------------------------------------------------

	/**
	 * @return Post set as meta parent.
	 */
	public function getPost() {

		return $this->hasOne( Post::className(), [ 'id' => 'pageId' ] );
	}

	// Static methods --------------------------------------------------

	// PageMeta ---------------------------

}

?>